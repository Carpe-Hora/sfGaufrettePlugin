<?php

/**
 * This file declare the sfGaufrettePluginUser class.
 *
 * @package     sfGaufrettePlugin
 * @subpackage  user
 * @author      julien muetton <julien_muetton@carpe-hora.com>
 * @version     SVN: $Id$
 */

/**
 * static methods used to register sfGaufrettePlugin user function
 */
class sfGaufrettePluginUser
{
  /**
   * listen to user.method_not_found event and call plugin function 
   * if exists.
   * this method is set up in sfGaufrettePluginConfiguration::initialize
   *
   * @param sfEvent $event the user.method_not_found event.
   */
  public static function methodNotFound(sfEvent $event)
  {
    if (method_exists('sfGaufrettePluginUser', $event['method']))
    {
      $event->setReturnValue(call_user_func_array(
        array('sfGaufrettePluginUser', $event['method']),
        array_merge(array($event->getSubject()), $event['arguments'])
      ));
      return true;
    }
  }

  /* define here your user methods. */
}
