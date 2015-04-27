<?php
error_reporting(E_ALL ^ E_NOTICE);
include '../../SoftniFw/App.php';

$app = \SoftUniFW\App::getInstance();


$app->run();
$app->getSession()->counter+=1;
echo $app->getSession()->counter;