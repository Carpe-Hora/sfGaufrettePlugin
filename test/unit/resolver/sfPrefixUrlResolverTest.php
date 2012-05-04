<?php
include dirname(__FILE__) . '/../../bootstrap/unit.php';

$t = new lime_test(2);
$resolver = new sfPrefixUrlResolver('/uploads/');

$t->diag(' > Test the sfPrefixUrlResolver');
$t->ok($resolver instanceof sfUrlResolverInterface, 'The sfPrefixUrlResolver implements the "sfUrlResolverInterface"');
$t->is($resolver->resolve('toto.jpg'), '/uploads/toto.jpg', 'A key is correctly resolved.');