<?php

namespace Dodo;

class Dodo{

	private $request;
	private $response;
	private static $app;
	private $_data;
	public $actionPath = 'actions';

	private function __construct(){
		$this->request = new Request();
		$this->response = new Response();
	}

	public function __set($name, $val){
		$this->_data[$name] = $val;
	}

	public function __get($name){
		return isset($this->_data[$name]) ? $this->_data[$name] : null;
	}

	public static function app(){
		return self::$app;
	}

	public static function getInstance($path){
		if(self::$app === null){
			$path = realpath($path);
			$namespace = basename($path);
			spl_autoload_register(function($name) use ($namespace, $path){
				if(strpos($name, $namespace) === 0){
					$file  = dirname($path) . '/' . str_replace("\\", "/", $name) . '.php';
					if(file_exists($file))
						include $file;
				}
			});
			self::$app = new static();
			self::$app->namespace = $namespace;
		}
		return self::$app;
	}

	private function getAction(){
		$path = $this->request->getPath();
		if($path == ''){
			$action = 'Home';
		}else{
			$path = explode("/", $path);
			$action = ucfirst(array_pop($path));
			$action = empty($path) ? $action : implode($path, "\\") . "\\" . $action;
		}

		$clsAction = $this->namespace  . "\\{$this->actionPath}\\" . $action;
		if(class_exists($clsAction)){
			$clsAction = new $clsAction($this->request, $this->response);
			$method = $this->request->method;
			$clsAction->$method($this->request, $this->response);
		}else{
			$this->response->notFound();
		}
	}

	public function run($config=null){
		$this->getAction();
	}
}