<?php
/**
 * This file declare the sfGaufretteFilesystem class.
 *
 * @package sfGaufrettePlugin
 * @subpackage lib
 * @author Julien Muetton <julien_muetton@carpe-hora.com>
 * @copyright (c) Carpe Hora SARL 2012
 * @since 2012-01-27
 */

/**
 * the gaufrette asset filesystem
 */
class sfGaufretteFilesystem extends Gaufrette\Filesystem
{
  protected $resolver;

  public function __construct(Gaufrette\Adapter $adapter, sfUrlResolverInterface $resolver)
  {
    parent::__construct($adapter);
    $this->resolver = $resolver;
  }

  public function getUrl($key)
  {
    return $this->resolver->resolve($key);
  }

  public function __toString()
  {
    return '';
  }
} // END OF sfGaufretteFilesystem