<?php
/**
 * cli command to test plugin in a standalone environment.
 *
 * See the test/bootstrap/options.php file to see the available options
 */

include_once dirname(__FILE__).'/../bootstrap/options.php';
include dirname(__FILE__).'/../bootstrap/unit.php';

$h = new lime_harness(new lime_output_color());
$h->register(sfFinder::type('file')->name('*Test.php')->in(dirname(__FILE__).'/..'));

$old_dir = getcwd();
chdir(dirname(__FILE__).'/../fixtures/project');

// run tests
$ret = !$h->run() ? 1 : 0;

chdir($old_dir);

// export to xml ?
if ($options['xml'])
{
  file_put_contents($options['xml'], $h->to_xml());
}

exit($ret);