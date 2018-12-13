<?php

namespace Drupal\cta\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Call to Action entities.
 */
class CallToActionViewsData extends EntityViewsData implements EntityViewsDataInterface {
  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['cta']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Call to Action'),
      'help' => $this->t('The Call to Action ID.'),
    );

    return $data;
  }

}
