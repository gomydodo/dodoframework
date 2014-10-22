<?php

namespace Dodo;

class Action{

	private $vars = array();

	public function __construct($req, $res){
		$this->request = $req;
		$this->response = $res;
	}

	final public function render($file=null, $param=array()){
		Dodo::app()->render($file, $param, $this->vars);
	}

	final public function setAttr($key=null, $value=null){
		$this->vars[$key] = $value;
	}

	final public function getAttr($key=null){
		return isset($this->vars[$key]) ? $this->vars[$key] : null;
	}

	public function get(){
	}

	public function post(){
	}

	public function put(){
	}

	public function delete(){
	}
}