<?php

namespace Drupal\drupalnl_partners\Plugin\Field\FieldFormatter;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\Exception\UndefinedLinkTemplateException;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceFormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'entity reference label' formatter.
 *
 * @FieldFormatter(
 *   id = "entity_reference_partner",
 *   label = @Translation("Partner"),
 *   description = @Translation("Display the partner details."),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class EntityReferencePartnerFormatter extends EntityReferenceFormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($this->getEntitiesToView($items, $langcode) as $delta => $entity) {
      $label = $entity->label();
      $uri_view = FALSE;
      $uri_edit = FALSE;
      // If the link is to be displayed and the entity has a uri, display a
      // link.
      if (!$entity->isNew()) {
        try {
          $uri_view = $entity->toUrl();
          $uri_edit = $entity->toUrl('edit-form');
        }
        catch (UndefinedLinkTemplateException $e) {
          // This exception is thrown by \Drupal\Core\Entity\Entity::urlInfo()
          // and it means that the entity type doesn't have a link template nor
          // a valid "uri_callback", so don't bother trying to output a link for
          // the rest of the referenced entities.
          return $elements;
        }
      }

      if ($uri_view && $uri_edit) {
        $elements[$delta] = [
          ['#markup' => $this->t('<a href=":view_uri">@label</a> (<a href=":edit_uri">Edit</a>)', [
              '@label' => $label,
              ':view_uri' => $uri_view->toString(),
              ':edit_uri' => $uri_edit->toString(),
            ])],
        ];

        if (!empty($items[$delta]->_attributes)) {
          $elements[$delta]['#options'] += ['attributes' => []];
          $elements[$delta]['#options']['attributes'] += $items[$delta]->_attributes;
          // Unset field item attributes since they have been included in the
          // formatter output and shouldn't be rendered in the field template.
          unset($items[$delta]->_attributes);
        }
      }
      $elements[$delta]['#cache']['tags'] = $entity->getCacheTags();
    }

    return $elements;
  }

  public function view(FieldItemListInterface $items, $langcode = NULL) {
    $elements = parent::view($items, $langcode);

    /** @var \Drupal\user\UserInterface $user */
    $user = \Drupal::routeMatch()->getParameter('user');
    if ($user->id() == \Drupal::currentUser()->id()) {
      $elements['#title'] = $this->t('Your organisation');
    }

    return $elements;
  }

}
