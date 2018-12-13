<?php

namespace Drupal\drupalnl_meetup;

/**
 * Status of the import of a Meetup source.
 */
class State {
  /**
   * Flag indicating that an item was inserted.
   *
   * @var string
   */
  const ITEM_CREATED = 'created';

  /**
   * Flag indicating that an item was updated.
   *
   * @var string
   */
  const ITEM_UPDATED = 'updated';

  /**
   * Flag indicating that an item was inserted.
   *
   * @var string
   */
  const ITEM_DELETED = 'deleted';

  /**
   * Flag indicating that an item was skipped.
   *
   * @var string
   */
  const ITEM_SKIPPED = 'skipped';

  /**
   * Flag indicating that an item failed.
   *
   * @var string
   */
  const ITEM_FAILED = 'failed';

  /**
   * The total number of items being processed.
   *
   * @var int
   */
  protected $total = 0;

  /**
   * The number of entities created.
   *
   * @var int
   */
  protected $created = 0;

  /**
   * The number of entities updated.
   *
   * @var int
   */
  protected $updated = 0;

  /**
   * The number of entities deleted.
   *
   * @var int
   */
  protected $deleted = 0;

  /**
   * The number of entities skipped.
   *
   * @var int
   */
  protected $skipped = 0;

  /**
   * The number of failed entities.
   *
   * @var int
   */
  protected $failed = 0;

  /**
   * Report a processed item.
   *
   * @param string $code
   *   What happened to the imported item.
   */
  public function report($code) {
    $this->total++;
    $this->$code++;
  }

  /**
   * Returns the total number of items processed.
   *
   * @return int
   */
  public function getTotal() {
    return $this->total;
  }

  /**
   * Returns an array of results.
   */
  public function getResults() {
    return [
      static::ITEM_CREATED => $this->created,
      static::ITEM_UPDATED => $this->updated,
      static::ITEM_DELETED => $this->deleted,
      static::ITEM_SKIPPED => $this->skipped,
      static::ITEM_FAILED => $this->failed,
    ];
  }
}
