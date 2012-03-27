<?php
/**
 * This file declare the PluginSfGaufretteFileValidator class.
 *
 * @package sfGaufrettePlugin
 * @subpackage lib.validator.plugin
 * @author Julien Muetton <julien_muetton@carpe-hora.com>
 * @copyright (c) Carpe Hora SARL 2012
 * @since 2012-01-26
 */

/**
 * gaufrette enabled file validator.
 *
 * adds following options to default sfValidatorFile :
 * - gaufrette : the gaufrette object to use
 *
 * path option is unused.
 */
class PluginSfGaufretteFileValidator extends sfValidatorFile
{
  public function configure($options = array(), $messages = array())
  {
    $this->addRequiredOption('gaufrette');

    parent::configure($options, $messages);

    $this->setOption('validated_file_class', 'sfGaufretteValidatedFile');
    $this->setOption('path', $options['gaufrette']);
  }
} // END OF PluginSfGaufretteFileValidator

