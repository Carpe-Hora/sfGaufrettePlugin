<?php

/**
 * uploadForm actions.
 *
 * @package    frontend
 * @subpackage uploadForm
 * @author     Kévin Gomez <kevin_gomez@carpe-hora.com>
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class uploadFormActions extends sfActions
{
  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new UploadForm(array(), array(
      'gaufrette' => $this->getContext()->getGaufrette('uploads')
    ));
  }

  /**
   * Executes upload action
   *
   * @param sfRequest $request A request object
   */
  public function executeUpload(sfWebRequest $request)
  {
    $this->form = new UploadForm(array(), array(
      'gaufrette' => $this->getContext()->getGaufrette('uploads')
    ));

    $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
    if ($this->form->isValid())
    {
      $this->redirect('uploadForm/index');
    }

    $this->setTemplate('index');
  }
}