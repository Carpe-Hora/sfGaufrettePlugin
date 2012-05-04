<?php

if (!isset($_SERVER['SYMFONY']))
{
  throw new RuntimeException('Could not find symfony core libraries.');
}

require_once $_SERVER['SYMFONY'].'/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->setPlugins(array(
      'sfGaufrettePlugin'
    ));

    $this->setPluginPath('sfGaufrettePlugin', dirname(__FILE__).'/../../../..');
  }


  /********************************************************************\
  *                                                                    *
  *      You should not have to change anything in the code below      *
  *                                                                    *
  \********************************************************************/

  protected $dependancies_dir;


  public function loadPlugins()
  {
    $this->fixSetup();

    parent::loadPlugins();
  }

  protected function fixSetup()
  {
    // make sure that the plugins directory exists
    $pluginsDir = sprintf('%s/plugins', sfConfig::get('sf_root_dir'));
    if (!is_dir($pluginsDir))
    {
      $fs = new sfFileSystem();
      $fs->mkdirs($pluginsDir);
    }

    // make sure that all the generated things will go into the plugin's
    // dir
    $this->forceSymlink(
      dirname(__FILE__).'/../../../..',
      sprintf('%s/plugins/sfGaufrettePlugin', sfConfig::get('sf_root_dir'))
    );

    $this->used_dependancies[] = sprintf('%s/plugins/sfGaufrettePlugin', sfConfig::get('sf_root_dir'));
  }

  public function getPluginPaths()
  {
    if (!isset($this->pluginPaths['']))
    {
      $pluginPaths = $this->getAllPluginPaths();

      $this->pluginPaths[''] = array();
      foreach ($this->getPlugins() as $plugin)
      {
        if (isset($pluginPaths[$plugin]))
        {
          $this->pluginPaths[''][] = $pluginPaths[$plugin];
        }
        // plugin not found, try our dependancies directory
        else if (($path = $this->getDependancy($plugin)))
        {
          $plugin_dir = sprintf('%s/plugins/%s', sfConfig::get('sf_root_dir'), $plugin);
          $this->used_dependancies[] = $plugin_dir;

          $this->forceSymlink($path, $plugin_dir);
          $this->pluginPaths[''][] = $plugin_dir;
        }
        else
        {
          throw new InvalidArgumentException(sprintf('The plugin "%s" does not exist.', $plugin));
        }
      }
    }

    return $this->pluginPaths[''];
  }

  protected function forceSymlink($origin, $destination)
  {
    $fs = new sfFileSystem();

    if (file_exists($destination))
    {
      $fs->remove($destination);
    }

    $fs->symlink($origin, $destination);
  }

  protected function guessDependanciesDirectory()
  {
    // if we are not in standelone, this will point to the "parent"
    // symfony project's plugin directory
    $this->dependancies_dir = dirname(__FILE__).'/../../../../../..';

    if (!empty($_SERVER['sfGaufrettePlugin_DEPENDANCIES']))
    {
      $this->dependancies_dir = $_SERVER['sfGaufrettePlugin_DEPENDANCIES'];
    }
  }

  protected function getDependancy($plugin)
  {
    if (is_null($this->dependancies_dir))
    {
      $this->guessDependanciesDirectory();
    }

    $path = sprintf('%s/plugins/%s', $this->dependancies_dir, $plugin);

    return is_dir($path) ? $path : false;
  }

  public function __destruct()
  {
    foreach ($this->used_dependancies as $dep)
    {
      if (is_link($dep))
      {
        unlink($dep);
      }
    }
  }
}
