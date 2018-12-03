<?php
	date_default_timezone_set('America/Los_Angeles');
	require_once 'define.php';
	function __autoload($clasName){
		if(file_exists(LIBRARY_PATH . "{$clasName}.php")){
			require_once LIBRARY_PATH . "{$clasName}.php";
		}
	}
	Session::init();
	
	$bootstrap = new Bootstrap();
	$bootstrap->init();