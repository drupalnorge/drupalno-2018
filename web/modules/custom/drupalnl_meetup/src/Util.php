<?php

namespace Drupal\drupalnl_meetup;

use GuzzleHttp\Client;

/**
 * Class with Util functions.
 */
class Util {
  /**
   * Runs an import for a specific url.
   *
   * Expected is that the given URL returns JSON.
   *
   * @param string $url
   *   The url to import from.
   *
   * @return \Drupal\drupalnl_meetup\MeetupSource
   *   A MeetupSource instance.
   */
  public static function runImport($url) {
    $source = new MeetupSource($url, new Client());
    $source->fetch()
      ->parse()
      ->process();

    return $source;
  }

  /**
   * Composes a message to display or log.
   *
   * @param \Drupal\drupalnl_meetup\MeetupSource $source
   *   The source to compose the results for.
   *
   * @return string
   *   The composed message.
   */
  public static function meetupSourceComposeMessage(MeetupSource $source) {
    $message = '@url: @created items were created, @updated items were updated, @skipped items were skipped and @failed items failed.';

    // Get results.
    $vars = $source->getState()->getResults();
    foreach ($vars as $type => $number) {
      $vars['@' . $type] = $number;
      unset($vars[$type]);
    }

    // Get url.
    $vars['@url'] = $source->getUrl();

    return [
      'message' => $message,
      'variables' => $vars,
    ];
  }
}
