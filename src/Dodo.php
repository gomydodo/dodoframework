<?php

namespace Dodo;

class Dodo{

	private $request;
	private $response;
	private $router;
	private $view;
	private static $app;
	public $actionPath = 'actions';
	private $methods = ['get', 'post', 'put', 'delete'];
	private $config = ['init.file' => 'start.php'];

	private function __construct(){
		$this->request = new Request();
		$this->response = new Response();
		$this->router = new Router();
		// $this->view = new View();
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
			self::$app->appPath = $path;
			self::$app->namespace = $namespace;
		}
		return self::$app;
	}

	private function getAction(){
		$path = trim($this->request->getPath(), '/');
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
			if(method_exists($clsAction, $method)){
				$clsAction->$method();	
				return true;
			}
		}
		return false;
		// $this->response->notFound();
	}

	public function run($config=array()){
		$conf = array_merge($this->config, $config);

		//include the init file for some url not need create an action
		if(file_exists($initFile = self::$app->appPath . '/' . $conf['init.file']))
			include $initFile;

		if(($route = $this->match()) && is_callable($route)){
			$route($this->request, $this->response);
		}elseif($this->getAction() === true){
			//do nothing
		}else{
			$this->response->notFound();
		}
	}

	public  function render($args=array()){
		// var_dump($args);
		// $view = new View();
		// $view->render();
		echo 'dodo/render';
	}

	// public function view()

	public function map($args, $method='get'){
		$pattern = array_shift($args);
		$callback = array_pop($args);
		$this->router->map($pattern, $callback, $method);
	}

	public function match(){
		return $this->router->match($this->request);
	}

	public function get(){
		$args = func_get_args();
		$this->map($args, 'get');
	}

	public function post(){
		$args = func_get_args();
		$this->map($args, 'post');
	}

	public function delete(){
		$args = func_get_args();
		$this->map($args, 'delete');
	}

	public function put(){
		$args = func_get_args();
		$this->map($args, 'put');
	}

}