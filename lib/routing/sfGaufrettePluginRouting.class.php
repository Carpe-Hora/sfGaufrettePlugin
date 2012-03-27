<?php

/**
 * This file declare the sfGaufrettePluginRouting class.
 *
 * @package     sfGaufrettePlugin
 * @subpackage  routing
 * @author      julien muetton <julien_muetton@carpe-hora.com>
 * @version     SVN: $Id$
 */

/**
 * static methods used to register sfGaufrettePlugin routes
 */
class sfGaufrettePluginRouting
{
  /**
   * Listens to the routing.load_configuration event.
   *
   * @param sfEvent An sfEvent instance
   */
  static public function listenToRoutingLoadConfigurationEvent(sfEvent $event)
  {
    foreach (array(/* list your modules here */) as $module)
    {
      if (in_array($module, sfConfig::get('sf_enabled_modules')))
      {
        call_user_func(array('sfGaufrettePluginRouting',sprintf('prepend%sRoutes', ucfirst($module))), $event->getSubject());
      }
    }
  }

  /* define your prependMyModule($routing) methods to register routes */
}
