<?php

namespace Dodo;

abstract class Middleware{
	
	private $next = null;

	public function hasNext(){
		return $this->next !== null;
	}

	public function getNextMiddleware(){
		return $this->hasNext()
			? $this->next
			: null;
	}

	public function setNextMiddleware(Middleware $mw){
		$this->next = $mw;
	}

	public function call(){
		$this->exec();
		if($this->hasNext())
			$this->getNextMiddleware()->call();
	}

	abstract public function exec();
}