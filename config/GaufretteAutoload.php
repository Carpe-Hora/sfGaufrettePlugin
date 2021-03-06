<?php

/**
 * Simple autoloader that follow the PHP Standards Recommendation #0 (PSR-0)
 * @see https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md for more informations.
 *
 * Code inspired from the SplClassLoader RFC
 * @see https://wiki.php.net/rfc/splclassloader#example_implementation
 */
class GaufretteAutoloader
{
  static protected $instance;

  public static function registerAutoload()
  {
    if (is_null(self::$instance))
    {
      self::$instance = new GaufretteAutoloader();
    }
  }

  protected function __construct()
  {
    spl_autoload_register(array($this, 'autoload'));
  }

  public function autoload($className)
  {
    $className = ltrim($className, '\\');
    if (0 != strpos($className, 'Gaufrette'))
    {
      return false;
    }

    $fileName = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\'))
    {
      $namespace = substr($className, 0, $lastNsPos);
      $className = substr($className, $lastNsPos + 1);
      $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }

    if(sfConfig::get('app_gaufrette_path'))
    {
      $fileName = implode(DIRECTORY_SEPARATOR, array(
        sfConfig::get('app_gaufrette_path'), 'src', $fileName.$className.'.php'
      ));
    }
    else
    {
      $fileName = implode(DIRECTORY_SEPARATOR, array(
        __DIR__, '..', 'lib', 'vendor', 'Gaufrette', 'src', $fileName.$className.'.php'
      ));
    }

    if (is_file($fileName))
    {
      require $fileName;

      return true;
    }

    return false;
  }
}

GaufretteAutoloader::registerAutoload();
