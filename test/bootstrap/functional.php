<?php

// try to include the command line argument symfony
include_once dirname(__FILE__).'/options.php';

if (!isset($app))
{
  $app = 'frontend';
}

if (!isset($_SERVER['SYMFONY']))
{
  $_SERVER['SYMFONY'] = dirname(__FILE__).'/../../../../lib/vendor/symfony/lib';
}

if (!is_dir($_SERVER['SYMFONY']))
{
  throw new RuntimeException('Could not find symfony core libraries.');
}

require_once $_SERVER['SYMFONY'].'/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

function sfGaufrettePlugin_cleanup()
{
  sfToolkit::clearDirectory(dirname(__FILE__).'/../fixtures/project/cache');
  sfToolkit::clearDirectory(dirname(__FILE__).'/../fixtures/project/log');
}
sfGaufrettePlugin_cleanup();
register_shutdown_function('sfGaufrettePlugin_cleanup');

chdir(dirname(__FILE__).'/../fixtures/project');

require_once 'config/ProjectConfiguration.class.php';
$configuration = ProjectConfiguration::getApplicationConfiguration($app, 'test', isset($debug) ? $debug : true);
sfContext::createInstance($configuration);
