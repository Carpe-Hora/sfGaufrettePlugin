<?php
/**
 * This file declare the sfUrlResolver class.
 *
 * @package sfGaufrettePlugin
 * @subpackage lib.resolver
 * @author Julien Muetton <julien_muetton@carpe-hora.com>
 * @copyright (c) Carpe Hora SARL 2012
 * @since 2012-01-27
 */

/**
 * simple url resolver, join prefix
 *
 * paramters:
 *  - prefix
 */
class sfPrefixUrlResolver implements sfUrlResolverInterface
{
  public function __construct($prefix)
  {
    $this->prefix = $prefix;
  }

  /**
   * resolve url for given key
   *
   * @return string
   */
  public function resolve($key)
  {
    return $this->prefix . $key;
  }
} // END OF sfUrlResolver
