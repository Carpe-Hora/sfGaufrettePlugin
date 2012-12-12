<?php
/**
 * This file declare the AmazonS3 class.
 *
 * @package     sfGaufrettePlugin
 * @subpackage  lib.adapter
 * @author      Kévin Gomez <kevin_gomez@carpe-hora.com>
 * @copyright   (c) Carpe Hora SARL 2012
 * @since       2012-03-27
 */

use \AmazonS3 as AmazonClient;

/**
 * The amazon s3 optionnable adapter
 */
class AmazonS3Adapter extends Gaufrette\Adapter\AmazonS3
{
  public function __construct(AmazonClient $service, $bucket, $options = array())
  {
    parent::__construct($service, $bucket, $options);

    if (!empty($options['directory']))
    {
      $this->setDirectory($options['directory']);
    }
  }
} // END OF AmazonS3