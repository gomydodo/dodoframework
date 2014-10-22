<?php

namespace Dodo;

class Collection implements \IteratorAggregate, \ArrayAccess, \Countable{

	private $d;

	public function __construct($data = array()){
		$this->d = $data;
	}

	public function set($key, $val){
		$this->d[$key] = $val;
	}

	public function get($key){
		return isset($this->d[$key]) ? $this->d[$key] : null;
	}

	public function clear(){
		$this->d = array();
	}

	public function has($key){
		return isset($this->d[$key]);
	}

	public function remove($key){
		unset($this->d[$key]);
	}

	public function arrayMerge(array $data){
		$this->d = array_merge($this->d, $data);
	}

	public function __set($key, $val){
		$this->set($key, $val);
	}

	public function __get($key){
		return $this->get($key);
	}

	public function __isset($key){
		return $this->has($key);
	}

	public function __unset($key){
		$this->remove($key);
	}

	public function getIterator(){
		return new \ArrayIterator($this->d);
	}

	public function offsetExists($offset){
		return $this->has($offset);
	}

	public function offsetGet ($offset){
		return $this->get($offset);
	}

	public function offsetSet ($offset, $val){
		$this->set($offset, $val);
	}

	public function offsetUnset ($offset){
		$this->remove($offset);
	}

	public function count(){
		return count($this->d);
	}
	
}