<?php

/**
 * sfGaufrettePlugin configuration.
 *
 * @package     sfGaufrettePlugin
 * @subpackage  config
 * @author      julien muetton <julien_muetton@carpe-hora.com>
 * @version     SVN: $Id$
 */
class sfGaufrettePluginConfiguration extends sfPluginConfiguration
{
  const VERSION = '1.0.0-DEV';

  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    $this->dispatcher->connect(
      'context.method_not_found',
      array($this, 'contextMethodNotFound')
    );
  }

  /**
   * This method is here to inject the sms sender object in the context's
   * factories. We can not use only the "context.load_factories" event
   * because the sms sender object is needed before this event is fully
   * propagated.
   *
   * @return bool
   * @author Kevin Gomez <kevin_gomez@carpe-hora.com>
   */
  public function contextMethodNotFound(sfEvent $event)
  {
    if ($event['method'] !== 'getGaufrette')
    {
      return false;
    }

    $sf_context = $event->getSubject();
    if ($sf_context->has('gaufrette'))
    {
      $gaufrette = $sf_context->get('gaufrette');
    }
    else
    {
      require_once sfConfig::get('sf_plugins_dir') . '/sfGaufrettePlugin/config/GaufretteAutoload.php';
      $gaufrette = $this->setGaufretteService($sf_context);
    }

    $event->setReturnValue(call_user_func_array(array($gaufrette, 'get'), $event['arguments']));
    return true;
  }


  public function setGaufretteService(sfContext $context)
  {
    $gaufrette = new sfGaufretteFactory();

    // to finish, add it to the current context
    $context->set('gaufrette', $gaufrette);

    return $gaufrette;
  }
}
