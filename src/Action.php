<?php

namespace Dodo;

class Action{

	public function get(){
		throw new Exception("override by your own", 1);
	}

	public function post(){
		throw new Exception("override by your own", 1);
	}

	public function put(){
		throw new Exception("override by your own", 1);
	}

	public function delete(){
		throw new Exception("override by your own", 1);
	}
}