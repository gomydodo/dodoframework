<?php

namespace Dodo;

class View{
	
	private $vars = array();

	private $file = null;
	private $param = array();

	private $path = '';

	private $config = array();

	public function __construct($path='.'){
		$this->path = $path;
		$this->defaultConfig();
	}

	public function defaultConfig(){
		$this->config = array(
			'view.path'=>'views',
			);
	}

	public function getConfig($key=null){
		return isset($this->config[$key]) ? $this->config[$key] : null;
	}

	public function render($args){
		// echo '<Br>';
		self::setRenderVars($args);
		echo 'view/render';
	}

	private function setRenderVars($args){
		$this->file = $args[0];
		$this->param = $args[1];
		$this->vars = $args[2];
	}

	public function get(){

	}

	public function exist(){

	}



	private function ht($str){
		return htmlspecialchars($str);
	}


}