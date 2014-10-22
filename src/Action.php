<?php

namespace Dodo;

class Action{

	private $vars = array();

	public function __construct($req, $res){
		$this->request = $req;
		$this->response = $res;
	}

	final public function render($file=null, $data=null){
		Dodo::app()->render($file, $data);
	}

	final public function setAttr($key=null, $value=null){
		$this->vars[$key] = $value;
	}

	public function __set($key, $val){
		$this->setAttr($key, $val);
	}

	public function __get($key){
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