<?php
error_reporting(E_ALL ^ E_NOTICE);
include '../../SoftUniFw/App.php';

$app = \SoftUniFw\App::getInstance();

$app->run();
