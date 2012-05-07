<?php

class UploadForm extends BaseForm
{
  public function configure()
  {
    $this->setWidget('file', new sfWidgetFormInputFile());
    $this->setValidator('file', new sfGaufretteFileValidator(array(
      'required'    => true,
      'gaufrette'   => $this->getOption('gaufrette'),
      'mime_types'  => 'web_images',
    )));

    $this->getWidgetSchema()->setLabels(array(
      'file' => 'File',
    ));

    $this->mergePostValidator(new sfValidatorCallback(array(
      'callback' => array(&$this, 'doUpload')
    )));

    $this->widgetSchema->setNameFormat('upload[%s]');
  }

  /**
   * As we are not in a form object, the save method is not called
   * automatically, so we use this trick to finalize the file upload.
   */
  public function doUpload($validator, $values)
  {
    if ($values['file'])
    {
      $values['file']->save();
    }

    return $values;
  }
} // END OF UploadForm
