<?php

namespace Dodo;

class Dodo{

	public $request;
	public $response;
	private $router;
	private $view;
	private static $app = null;
	private $config;

	private function __construct(array $config){
		self::$app = $this;

		$path = realpath($config['app.path']);
		$namespace = basename($path);
		$config['namespace'] = $namespace;
		$this->config = $this->defaultConfig();
		$this->config->arrayMerge($config);
		$this->config->set('namespace', $config['namespace']);
		$this->init();
	}

	private function init(){
		$this->request = new Request();
		$this->response = new Response();
		$this->router = new Router();
		$this->view = new View();
	}

	private function defaultConfig(){
		$config = [
			'action.path' => 'actions',
			'action.default' => 'Home',
			'action.defaultFile' => 'home',
			'app.path' => './app',
			'init.file' => 'start',
			'namespace' => 'app',
		];
		return new Collection($config);
	}

	public function getConfig($name){
		return $this->config->get($name);
	}

	public static function app(){
		return self::$app;
	}

	public static function getInstance($config=array()){
		if(self::$app === null){
			spl_autoload_register(array(__CLASS__, 'autoload'));
			return new static($config);
		}

		return self::$app;
	}

	public static function autoload($name){
		static $loadedClass = [];
		$file = '';

		$namespace = self::$app->config->get('namespace');
		$path = dirname(self::$app->config->get('app.path'));

		if(strpos($name, $namespace) === 0){

			$file  = $path . '/' . str_replace("\\", "/", $name) . '.php';
			if(! file_exists($file)){
				$classPath = str_replace("\\", "/", $name);
				$file = $path . '/' . dirname($classPath) . '.php';
			}

			if(file_exists($file) && !isset($loadedClass[$file])){
				$loadedClass[$file] = 1;
				include $file;
			}
		}
	}

	public function run(){

		//include the init file for some url not need create an action
		if(file_exists($initFile = $this->config->get('app.path') . '/' 
			. $this->config->get('init.file') . '.php'))
			include $initFile;

		if(($route = $this->router->match()) && is_callable($route)){
			$route($this->request, $this->response);
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