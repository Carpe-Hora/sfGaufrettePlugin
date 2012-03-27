<?php
/**
 * This file declare the sfUrlResolverInterface class.
 *
 * @package sfGaufrettePlugin
 * @subpackage liv.resolver
 * @author Julien Muetton <julien_muetton@carpe-hora.com>
 * @copyright (c) Carpe Hora SARL 2012
 * @since 2012-01-27
 */

/**
 * url resolver interface
 */
interface sfUrlResolverInterface
{
  /**
   * resolve url for given key
   *
   * @return string
   */
  public function resolve($key);
} // END OF sfUrlResolverInterface
