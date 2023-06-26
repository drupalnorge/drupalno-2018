<?php

namespace Drupal\drupalnl_meetup;

use Drupal\datetime\Plugin\Field\FieldType\DateTimeItemInterface;
use Exception;
use Drupal;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\node\Entity\Node;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;

/**
 * Fetches and parses meetup events.
 *
 * @todo This functionality could be replaced by the Feeds module + Feeds
 * extensible parsers module when that is ready.
 */
class MeetupSource {
  /**
   * The content type being used.
   *
   * @var string
   */
  const CONTENT_TYPE = 'meetup_event';

  /**
   * The source URL.
   *
   * @var string
   */
  private $url;

  /**
   * The Guzzle client.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $client;

  /**
   * The raw result.
   *
   * @var string
   */
  protected $raw;

  /**
   * The parsed results.
   *
   * @var array
   */
  protected $rows = [];

  /**
   * The state.
   *
   * @var \Drupal\drupalnl_meetup\State
   */
  private $state;

  /**
   * MeetupSource object constructor.
   *
   * @param string $url
   *   The url to fetch content from.
   * @param \GuzzleHttp\ClientInterface $client
   *   The Guzzle client.
   */
  public function __construct($url, ClientInterface $client) {
    $this->url = $url;
    $this->client = $client;
    $this->state = new State();
  }

  /**
   * Returns URL.
   *
   * @return string
   */
  public function getUrl() {
    return $this->url;
  }

  /**
   * Returns the state of imported items.
   *
   * @return \Drupal\drupalnl_meetup\State
   *   A State instance.
   */
  public function getState() {
    return $this->state;
  }

  /**
   * Fetches from source.
   */
  public function fetch() {
    try {
      $response = $this->client->get($this->url);
      if ($response->getStatusCode() == 200) {
        $this->raw = (string) $response->getBody();
      }
    }
    catch (RequestException $e) {
      $args = ['%site' => $url, '%error' => $e->getMessage()];
      throw new \RuntimeException($this->t('The feed from %site seems to be broken because of error "%error".', $args));
    }

    return $this;
  }

  /**
   * Parses the raw data.
   */
  public function parse() {
    $this->rows = json_decode($this->raw);
    return $this;
  }

  /**
   * Processes the data.
   */
  public function process() {
    $this->state = new State();

    foreach ($this->rows as $row) {
      // Process an item.
      $result = $this->processItem($row);
      // Keep track of what happened to the item.
      $this->state->report($result);
    }

    return $this;
  }

  /**
   * Processes a single item.
   *
   * @param object $item
   *   The item to process.
   *
   * @return string
   *   What happened to the item to import.
   *   Can be 'created', 'updated', 'skipped' or 'failed'.
   */
  public function processItem($item) {
    if (!empty($item->id)) {
      $entity = $this->findExisting($item->id);
    }

    if (empty($entity)) {
      // An item is going to be inserted.
      $result = State::ITEM_CREATED;

      // Create a new node.
      $entity = Node::create([
        'type' => static::CONTENT_TYPE,
      ]);
    }
    else {
      // An item is going to be updated.
      $result = State::ITEM_UPDATED;
    }

    // Generate a hash of the item to check if it has changed.
    $hash = $this->hash($item);
    if ($entity->field_hash->getString() == $hash) {
      // Hashes are equal. Do not update the item.
      return State::ITEM_SKIPPED;
    }

    // Correct the data.
    // Timestamps are milliseconds, convert them to seconds.
    $item->time = $item->time / 1000;
    $item->created = $item->created / 1000;
    $item->updated = $item->updated / 1000;

    // Convert time value to date.
    $item->time = DrupalDateTime::createFromTimestamp($item->time, DateTimeItemInterface::STORAGE_TIMEZONE)
      ->format(DateTimeItemInterface::DATETIME_STORAGE_FORMAT);

    // Mapping.
    $entity->field_meetup_id = $item->id;
    $entity->field_hash = $hash;
    $entity->setTitle($item->name);
    $entity->field_datetime = $item->time;
    $entity->field_source = $item->link;
    $entity->setCreatedTime($item->created);
    $entity->setChangedTime($item->updated);
    // Outcommented setting published status based on visibility because
    // sometimes events are placed on both drupal.nl and meetup.com. The idea is
    // that these meetup events are unpublished manually by a drupal.nl admin
    // user. In this case, we don't want to republish such an item.
    //$entity->setPublished($item->visibility == 'public');

    // Save the entity.
    try {
      $entity->save();

      // Whether an item is created or updated was decided earlier.
      return $result;
    }
    catch (Exception $e) {
      // If exceptions occur, saving failed.
      // @todo log exception?
      return State::ITEM_FAILED;
    }
  }

  /**
   * Finds an existing node.
   *
   * @param string $meetup_id
   *   The meetup ID.
   *
   * @return \Drupal\node\Entity\Node|null
   *   A node object, if found.
   *   Null otherwise.
   */
  public function findExisting($meetup_id) {
    // @todo require QueryFactory in constructor?
    $query = \Drupal::entityQuery('node')
      ->condition('type', static::CONTENT_TYPE)
      ->condition('field_meetup_id.value', $meetup_id);
    $result = $query->execute();

    $entities = entity_load_multiple('node', $result);

    if (count($entities)) {
      return reset($entities);
    }
  }

  /**
   * Creates an MD5 hash of an item.
   *
   * @param object $item
   *   The item to hash.
   *
   * @return string
   *   An MD5 hash.
   */
  protected function hash($item) {
    return hash('md5', serialize($item));
  }
}
