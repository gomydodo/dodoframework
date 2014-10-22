<?php

namespace Dodo;

class View{
	
	private $vars = array();

	private $file = null;
	private $param = array();

	private $path = '';

	private static $app = null;

	private $config = array();

	public function __construct($path = '.'){
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

	public function render($file, $data=null){
		$this->template = $this->getTemplate($file);

        if (!file_exists($this->template)){
            throw new \Exception("Template file not found: {$this->template}.");
        }

        if (is_array($data)) {
            $this->vars = array_merge($this->vars, $data);
        }

        extract($this->vars);

        include $this->template;
	}

	// public function exist($filename='.'){
	// 	if(!file_exists($filename))
			// $this->path = dirname(__DIR__);
	// }

	public function getTemplate($file) {
		if((in_array(substr($file, 0,1), array('\\','/'))))
			$file = substr($file, 1);
		
        if ((substr($file, -4) != '.php'))
            $file .= '.php';

        return $this->path.'/'.$this->getConfig('view.path').'/'.$file;
    }

}