<?php

namespace Drupal\cta;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Call to Action entity.
 *
 * @see \Drupal\cta\Entity\CallToAction.
 */
class CallToActionAccessControlHandler extends EntityAccessControlHandler {
  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\cta\CallToActionInterface $entity */
//    switch ($operation) {
//      case 'view':
//        if (!$entity->isPublished()) {
//          return AccessResult::allowedIfHasPermission($account, 'view unpublished call to action entities');
//        }
//        return AccessResult::allowedIfHasPermission($account, 'view published call to action entities');
//
//      case 'update':
//        return AccessResult::allowedIfHasPermission($account, 'edit call to action entities');
//
//      case 'delete':
//        return AccessResult::allowedIfHasPermission($account, 'delete call to action entities');
//    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add call to action entities');
  }

}
