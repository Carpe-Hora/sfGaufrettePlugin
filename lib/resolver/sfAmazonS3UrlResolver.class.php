<?php
/**
 * This file declare the sfAmazonS3UrlResolver class.
 *
 * @package     sfGaufrettePlugin
 * @subpackage  lib.resolver
 * @author      Kévin Gomez <kevin_gomez@carpe-hora.com>
 * @copyright   (c) Carpe Hora SARL 2012
 * @since       2012-03-27
 */

/**
 * Amazon S3 URL resolver.
 */
class sfAmazonS3UrlResolver implements sfUrlResolverInterface
{
  protected $bucket;
  protected $host;
  protected $path;


  public function __construct($bucket, $host, $path)
  {
    $this->bucket = $bucket;
    $this->host = $host;
    $this->path = $path;
  }

  /**
   * resolve url for given key
   *
   * @return string
   */
  public function resolve($key)
  {
    return sprintf('http://%s.%s/%s/%s', $this->bucket, $this->host, $this->path, $key);
  }
} // END OF sfAmazonS3UrlResolver