<?php

namespace Dodo;

class Router{

	private $_map = [];
	private $app;
	public $methods = ['get', 'post', 'put', 'delete'];

	public function __construct(){
		$this->app = Dodo::app();
	}


	public function map($pattern, $callback, $method){
		$this->_map[$pattern][$method] = $callback;
	}

	public function getMap(Request $request){
		$path = $request->getPath();
		$method = $request->method;
		return isset($this->_map[$path][$method]) ? $this->_map[$path][$method] : false;
	}

	public function match(){
		return $this->getMap($this->app->request) ?: $this->getAction();
	}

	private function getAction(){
		$path = trim($this->app->request->getPath(), '/');
		if($path == ''){
			$action = $this->app->getConfig('action.default');
		}else{
			$path = explode("/", $path);
			$action = ucfirst(array_pop($path));
			$action = empty($path) ? $action : implode($path, "\\") . "\\" . $action;
		}
		$clsAction = $this->app->getConfig('namespace')  
					. "\\{$this->app->getConfig('action.path')}\\" . $action;

		if(class_exists($clsAction)){
			$method = $this->app->request->method;

			if(in_array($method, $this->methods) && method_exists($clsAction, $method)){
				return function($req, $res) use ($clsAction, $method){
					$cls = new $clsAction($req, $res);
					$cls->$method();
				};
			}
		}
		return false;
	}
}