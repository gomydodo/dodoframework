<?php

namespace Dodo;

class Request{

	private $data = array();
	
	public function __construct(){
		$config = array(
			'method' => strtolower($_SERVER['REQUEST_METHOD']),
			'port' => $_SERVER['SERVER_PORT'],
			'host' => $_SERVER['HTTP_HOST'],
			'ip' => $_SERVER['REMOTE_ADDR'],
		);

		$this->init($config);
	}

	public function __set($name, $val){
		$this->data[$name] = $val;
	}

	public function __get($name){
		return isset($this->data[$name]) ? $this->data[$name] : null;
	}

	private function init($config){
		foreach($config as $name => $val){
			$this->$name = $val;
		}

		$this->parseHeaders();
	}

	private function parseHeaders(){
		foreach($_SERVER as $key => $val){
			$header = strtolower($key);
			if(strpos($header, 'http_') === 0){
				$headerName = str_replace("_", "-", str_replace("http_", "", $header));
				$this->$headerName = $val;
			}
		}
	}

	public function getPath(){
		$scriptName = $_SERVER['SCRIPT_NAME'];
		$queryUri = $_SERVER['REQUEST_URI'];
		$queryString = $_SERVER['QUERY_STRING'];
		$path = str_replace("?" . $queryString, "", $queryUri);
		if(strpos($path, $scriptName) !== false){
			$path = str_replace($scriptName, "", $path);
		}
		return strtolower(trim($path, '/'));
	}

	public function getQuery(){
		return $_GET;
	}

	public function getBody(){
		return $_POST ?: file_get_contents("php://input");
	}
}