<?php
require 'environment.php';

define("BASE","http://localhost:8082/api/");



global $config;
$config = array();
if(ENVIRONMENT == 'development') {
	$config['dbname'] = 'websistema';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = '';
} else {
	$config['dbname'] = 'u734983106_web';
	$config['host'] = 'sql130.main-hosting.eu';
	$config['dbuser'] = '';
	$config['dbpass'] = '';
}
?>