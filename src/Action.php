<?php

namespace Dodo;

class Action{

	public function __construct($req, $res){
		$this->request = $req;
		$this->response = $res;
	}

	final public function render(){
		Dodo::app()->render();
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