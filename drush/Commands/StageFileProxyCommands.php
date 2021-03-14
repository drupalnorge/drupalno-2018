<?php

namespace Drush\Commands;

use Consolidation\SiteAlias\SiteAliasManagerAwareInterface;
use Consolidation\SiteAlias\SiteAliasManagerAwareTrait;
use Drupal;

if (!interface_exists('Consolidation\SiteAlias\SiteAliasManagerAwareInterface')) {
  class StageFileProxyCommands extends DrushCommands {}
  return;
}

/**
 * Edit this file to reflect your organization's needs.
 */
class StageFileProxyCommands extends DrushCommands implements SiteAliasManagerAwareInterface {
  use SiteAliasManagerAwareTrait;

  /**
   * Enable stage_file_proxy and set configuration from the live alias.
   *
   * @command stage_file_proxy:enable
   * @aliases sfp-en
   * @bootstrap full
   *
   * @throws \Exception
   */
  public function enable() {
    $live_alias = $this->siteAliasManager()->getAlias('prod');
    if ($live_alias) {
      /** @var \Drupal\Core\Config\ConfigFactoryInterface $config_factory */
      $config_factory = Drupal::getContainer()->get('config.factory');
      $config = $config_factory->getEditable('stage_file_proxy.settings');

      // If config is new, the module is not installed, and we need to set it up. Otherwise, do nothing.
      if ($config->isNew()) {
        /** @var \Drupal\Core\Extension\ModuleInstallerInterface $module_installer */
        $module_installer = Drupal::getContainer()->get('module_installer');
        $modules = ['stage_file_proxy', 'config_exclude'];
        $ret = $module_installer->install($modules, FALSE);

        if ($ret) {
          $this->logger()->notice(dt('Successfully enabled: %modules', ['%modules' => implode(', ', $modules)]));
          $this->logger()->notice(dt('Setting configuration using live URL: %uri', ['%uri' => $live_alias->get('uri')]));
          $config->set('hotlink', TRUE);
          $config->set('origin', $live_alias->get('uri'));
          $config->set('origin_dir', '');
          $config->set('use_imagecache_root', TRUE);
          $config->set('verify', TRUE);
          $config->save();
        }
        else {
          $this->logger()->error(dt('Failed to enable: %modules', ['%modules' => implode(', ', $modules)]));
        }
      }
    }
  }

  /**
   * Disable stage_file_proxy.
   *
   * @command stage_file_proxy:disable
   * @aliases sfp-dis
   * @bootstrap full
   *
   * @throws \Exception
   */
  public function disable() {
    /** @var \Drupal\Core\Extension\ModuleInstallerInterface $module_installer */
    $module_installer = Drupal::getContainer()->get('module_installer');
    $ret = $module_installer->uninstall(['stage_file_proxy', 'config_exclude'], FALSE);

    if ($ret) {
      $this->logger()->notice(dt('Successfully disabled: %module', ['%module' => 'stage_file_proxy']));
    }
    else {
      $this->logger()->error(dt('Failed to disable: %module', ['%module' => 'stage_file_proxy']));
    }
  }

}
