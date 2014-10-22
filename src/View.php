<?php

namespace Dodo;

class View{
	
	private $vars = array();

	private $file = null;
	private $param = array();

	private $path = '';

	private static $app = null;

	private $config = array();

	public function __construct($path='.'){
		self::$app = $this;
		$this->path = $path;
		$this->defaultConfig();
	}

	public static function app(){
		new View();
		return self::$app;
	}

	public function defaultConfig(){
		$this->config = array(
			'view.path'=>'views',
			);
	}

	public function getConfig($key=null){
		return isset($this->config[$key]) ? $this->config[$key] : null;
	}

	public function render($args=array()){
		echo 'view/render';
	}

	public function get(){

	}

	public function exist(){

	}



	private function ht($str){
		return htmlspecialchars($str);
	}


}