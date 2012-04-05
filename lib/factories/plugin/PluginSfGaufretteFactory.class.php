<?php
/**
 * This file declare the PluginSfGaufretteFactory class.
 *
 * @package sfGaufrettePlugin
 * @subpackage lib.factories
 * @author Julien Muetton <julien_muetton@carpe-hora.com>
 * @copyright (c) Carpe Hora SARL 2012
 * @since 2012-01-26
 */

use Gaufrette\Adapter\Cache as CacheAdapter;

/**
 * gaufrette factory class
 */
class PluginSfGaufretteFactory
{
  protected $instances = array();

  private static $initialized = false;

  public function __construct()
  {
    if (self::$initialized == false)
    {
      require_once sfConfig::get('sf_plugins_dir') . '/sfGaufrettePlugin/config/GaufretteAutoload.php';
      self::$initialized = true;
    }
  }

  /**
   * return given factory
   *
   * @return Gaufrette\Filesystem
   */
  public function get($name = 'default')
  {
    if (!isset($this->instances[$name]))
    {
      $this->createInstance($name);
    }

    return $this->instances[$name];
  }

  protected function createInstance($name = 'default')
  {
    $config = sfConfig::get(sprintf('app_gaufrette_%s', $name), null);
    if (null === $config)
    {
      throw new RuntimeException(sprintf('The gaufrette "%s" does not exist!', $name));
    }

    $config = array_merge(array(
      'adapter'       => array(),
      'cache'         => null,
      'url_resolver'  => array()
    ), $config);

    $adapter = $this->createAdapter($config['adapter']);

    if ($config['cache'])
    {
      $cache = $this->createAdapter($config['cache']);
      $adapter = new CacheAdapter($adapter, $cache, isset($config['cache']['ttl']) ? $config['cache']['ttl'] : 3600);
    }

    $resolver = $this->createUrlResolver($config['url_resolver']);

    $this->instances[$name] = new sfGaufretteFilesystem($adapter, $resolver);
  }

  protected function createAdapter($config)
  {
    $config = array_merge(array(
      'class'   => '\Gaufrette\Adapter\Local',
      'param'   => array('directory' => sfConfig::get('sf_upload_dir'))
    ), $config);

    return $this->createObjectFromConfiguration($config);
  }

  protected function createUrlResolver($config)
  {
    $config = array_merge(array(
      'class'   => 'sfPrefixUrlResolver',
      'param'   => array()
    ), $config);

    return $this->createObjectFromConfiguration($config);
  }

  /**
   * create object from configuration
   *
   * @return mixed
   */
  protected function createObjectFromConfiguration($parameters)
  {
    $arguments = $this->prepareArguments($parameters['param']);
    $arguments = null === $arguments ? array() : $arguments;

    $reflector = new ReflectionClass($parameters['class']);
    return $reflector->newInstanceArgs($arguments);
  }

  protected function prepareArguments($parameters)
  {
    if (!is_array($parameters))
    {
      return $parameters;
    }

    foreach ($parameters as $key => $value)
    {
      // this argument should be transformed to an object
      if (is_array($value) && isset($value['class']))
      {
        $parameters[$key] = $this->createObjectFromConfiguration($value);
      }
    }

    return $parameters;
  }
} // END OF PluginSfGaufretteFactory
