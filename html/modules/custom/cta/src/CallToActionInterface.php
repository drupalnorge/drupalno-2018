<?php

namespace Drupal\cta;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Call to Action entities.
 *
 * @ingroup cta
 */
interface CallToActionInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {
  // Add get/set methods for your configuration properties here.
  /**
   * Gets the Call to Action name.
   *
   * @return string
   *   Name of the Call to Action.
   */
  public function getName();

  /**
   * Sets the Call to Action name.
   *
   * @param string $name
   *   The Call to Action name.
   *
   * @return \Drupal\cta\CallToActionInterface
   *   The called Call to Action entity.
   */
  public function setName($name);

  /**
   * Gets the Call to Action creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Call to Action.
   */
  public function getCreatedTime();

  /**
   * Sets the Call to Action creation timestamp.
   *
   * @param int $timestamp
   *   The Call to Action creation timestamp.
   *
   * @return \Drupal\cta\CallToActionInterface
   *   The called Call to Action entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Call to Action published status indicator.
   *
   * Unpublished Call to Action are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Call to Action is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Call to Action.
   *
   * @param bool $published
   *   TRUE to set this Call to Action to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\cta\CallToActionInterface
   *   The called Call to Action entity.
   */
  public function setPublished($published);

}
