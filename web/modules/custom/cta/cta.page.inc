<?php

/**
 * @file
 * Contains cta.page.inc.
 *
 * Page callback for Call to Action entities.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for Call to Action templates.
 *
 * Default template: cta.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_cta(array &$variables) {
  // Fetch CallToAction Entity Object.
  $cta = $variables['elements']['#cta'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
