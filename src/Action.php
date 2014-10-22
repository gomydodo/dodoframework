<?php

namespace Dodo;
use Dodo\View;

class Action{

	public function __construct($req, $res){
		$this->request = $req;
		$this->response = $res;
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