<?php
include dirname(__FILE__) . '/../bootstrap/functional.php';

$browser = new sfTestFunctional(new sfBrowser());


// remove the uploaded files when the tests are over
function cleanFiles()
{
  $files = sfFinder::type('file')
    ->name('*.gif')
    ->in(sfConfig::get('sf_upload_dir'));

  foreach ($files as $file)
  {
    unlink($file);
  }
}
register_shutdown_function('cleanFiles');


// start the tests
$browser
  ->get('/uploadForm/index')

  ->with('request')->begin()
    ->isParameter('module', 'uploadForm')
    ->isParameter('action', 'index')
  ->end()

  ->with('response')->begin()
    ->isStatusCode(200)
    ->isValid()
    ->checkElement('h1', 'Upload Form')
    ->checkForm(new UploadForm())
  ->end()

  ->click('Upload!', array('upload' => array(
    'file' => sfConfig::get('sf_data_dir').'/fixtures/lawl.gif',
  )))

  ->with('response')->begin()
    ->isRedirected()
    ->followRedirect()
  ->end()

  ->with('request')->begin()
    ->isParameter('module', 'uploadForm')
    ->isParameter('action', 'index')
  ->end()

  ->with('response')->begin()
    ->isStatusCode(200)
    ->isValid()
    ->checkElement('h1', 'Upload Form')
    ->checkForm(new UploadForm())
  ->end();

$files = sfFinder::type('file')
  ->name('*.gif')
  ->in(sfConfig::get('sf_upload_dir'));

$browser->test()->is(count($files), 1, 'The file has been uploaded to the uploads dir');
