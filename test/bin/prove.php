<?php
/**
 * cli command to test plugin in a standalone environment.
 *
 * you can provide following options:
 * * --symfony : the symfony lib directory
 * * --xml : export results to this file
 */

// first parse options
$options = array_merge(array(
                // default symfony path
                'symfony' => '/usr/share/php/symfony/',
                'xml'     => false
              ), getopt("", array("symfony:", "xml:")));

// create the common include for lib path
$sf_lib_path_include = dirname(dirname(__FILE__)).'/bootstrap/sf_test_lib.inc';
file_put_contents($sf_lib_path_include, sprintf('<?php if (!isset($_SERVER[\'SYMFONY\'])) {$_SERVER[\'SYMFONY\'] = "%s";}', $options['symfony']));

include dirname(__FILE__).'/../bootstrap/unit.php';

$h = new lime_harness(new lime_output_color());
$h->register(sfFinder::type('file')->name('*Test.php')->in(dirname(__FILE__).'/..'));

// run tests
$ret = $h->run() ? 1 : 0;

// export to xml ?
if ($options['xml'])
{
  file_put_contents($options['xml'], $h->to_xml());
}

// remove the common include for lib path
unlink($sf_lib_path_include);

exit($ret);
