<?php
/**
 * @file
 * Contains \Drupal\forum_redirect\Controller\ForumRedirectController.
 */

namespace Drupal\forum_redirect\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\RedirectResponse;



/**
 * ForumRedirectController.
 */
class ForumRedirectController extends ControllerBase {

  /**
   * Redirects forum/* and forums/* to new page.
   */
  public function forumRedirect() {
    return new RedirectResponse('/een-nieuwe-website');
  }


}
