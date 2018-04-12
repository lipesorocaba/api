<?php
class Controller {

	protected $db;

	public function __construct() {
		global $config;
		$this->db = new PDO("mysql:dbname=".$config['dbname'].';charset=utf8'.";host=".$config['host'], $config['dbuser'], $config['dbpass']);

	}
	
	public function loadView($viewName, $viewData = array()) {
		extract($viewData);
		include 'views/'.$viewName.'.php';
	}

	public function loadTemplate($viewName, $viewData = array()) {
		include 'views/template.php';
	}

	public function loadViewInTemplate($viewName, $viewData) {
		extract($viewData);
		include 'views/'.$viewName.'.php';
	}
        
        public function loadTemplate_insc($viewName, $viewData = array()) {
		include 'views/template_insc.php';
	}

	public function loadViewInTemplate2($viewName, $viewData) {
		extract($viewData);
		include 'views/'.$viewName.'.php';
	}

}