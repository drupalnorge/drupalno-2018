<?php

$settings['hash_salt'] = 'WrEUmGDEt0xEHaV0jPZPIwImzfappybKHnHRZUrpfLLoLXPh0LzqBRH8iHPL8YnsltqtnIyLcQ';
$config['config_split.config_split.development']['status'] = FALSE;
$settings['config_sync_directory'] =  '../config/sync';
$settings['file_private_path'] = 'sites/default/private';

// Automatically generated include for settings managed by ddev.
if (file_exists($app_root . '/' . $site_path . '/settings.ddev.php') && getenv('IS_DDEV_PROJECT') == 'true') {
  include $app_root . '/' . $site_path . '/settings.ddev.php';
  $config['config_split.config_split.development']['status'] = TRUE;
}

if (file_exists($app_root . '/' . $site_path . '/settings.local.php')) {
  include $app_root . '/' . $site_path . '/settings.local.php';
}
