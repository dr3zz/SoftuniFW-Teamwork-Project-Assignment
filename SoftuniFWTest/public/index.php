<?php
error_reporting(E_ALL ^ E_NOTICE);
include '../../SoftUniFw/App.php';

$app = \SoftUniFw\App::getInstance();
$db = new \SoftUniFw\DB\SimpleDB();
$a = $db->prepare('SELECT * FROM users WHERE id=?',array(1))->execute()->fetchAllAssoc();
echo '<pre>'.print_r($a,true).'</pre>';
$app->run();
