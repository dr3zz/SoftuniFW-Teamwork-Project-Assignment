<?php
$cnf['default']['connection_uri'] = 'mysql:host=localhost;dbname=test';
$cnf['default']['username'] = 'yavor';
$cnf['default']['password'] = '1234';
$cnf['default']['pdo_options'][PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES 'UTF8'";
$cnf['default']['pdo_options'][PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;

$cnf['session']['connection_uri'] = 'mysql:host=localhost;dbname=session';
$cnf['session']['username'] = 'yavor';
$cnf['session']['pass'] = '1234';
$cnf['session']['pdo_options'][PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES 'UTF8'";
$cnf['session']['pdo_options'][PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;

return $cnf;