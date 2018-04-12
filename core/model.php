<?php
class Model {
	
	protected $db;

	public function __construct() {
		global $config;
		$this->db = new PDO("mysql:dbname=".$config['dbname'].';charset=utf8'.";host=".$config['host'], $config['dbuser'], $config['dbpass']);
	}

}
?>