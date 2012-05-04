<?php
include dirname(__FILE__) . '/../../bootstrap/unit.php';

$t = new lime_test(2);
$resolver = new sfAmazonS3UrlResolver('my-bucket', 'joe.amazon.com', 'uploads/logo');

$t->diag(' > Test the sfAmazonS3UrlResolver');
$t->ok($resolver instanceof sfUrlResolverInterface, 'The sfAmazonS3UrlResolver implements the "sfUrlResolverInterface"');
$t->is($resolver->resolve('toto.jpg'), 'http://my-bucket.joe.amazon.com/uploads/logo/toto.jpg', 'A key is correctly resolved.');