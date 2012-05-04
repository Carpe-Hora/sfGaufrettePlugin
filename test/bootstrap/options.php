<?php
/**
 * cli command to test plugin in a standalone environment.
 *
 * you can provide following options:
 * * --symfony: the symfony lib directory
 * * --xml: export results to this file
 * * --dependancies: dependancies directory
 */

define('OPTIONS_FILE', dirname(__FILE__).'/options.save.php');

if (file_exists(OPTIONS_FILE))
{
  include OPTIONS_FILE;
}
else
{
  // first parse options
  $options = array_merge(
    array(
      // default symfony path
      'symfony'       => sprintf('/usr/share/php/symfony/:%s/../../../../lib/vendor/symfony/lib', dirname(__FILE__)),
      'xml'           => false,
      'dependancies'  => ''
    ),
    getopt('', array('symfony:', 'xml:', 'dependancies:'))
  );

  file_put_contents(OPTIONS_FILE, sprintf('<?php $options = %s;', var_export($options, true)));

  function sfGaufrettePlugin_cli_cleanup()
  {
    unlink(OPTIONS_FILE);
  }

  register_shutdown_function('sfGaufrettePlugin_cli_cleanup');
}


if (empty($_SERVER['SYMFONY']))
{
  foreach (explode(':', $options['symfony']) as $path)
  {
    if (is_dir($path))
    {
      $_SERVER['SYMFONY'] = $path;
      break;
    }
  }
}

if (empty($_SERVER['sfGaufrettePlugin_DEPENDANCIES']))
{
  $_SERVER['sfGaufrettePlugin_DEPENDANCIES'] = $options['dependancies'];
}