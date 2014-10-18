<?php

namespace Dodo;

class Router{
	private $_map = [];

	public function map($pattern, $callback, $method){
		$this->_map[$pattern][$method] = $callback;
	}

	public function match(Request $request){
		$path = $request->getPath();
		$method = $request->method;
		return isset($this->_map[$path][$method]) ? $this->_map[$path][$method] : false;
	}
}