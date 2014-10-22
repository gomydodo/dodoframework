<?php

namespace Dodo;

class Response{

	private $body;
	private $headers = array();

	public function send(){
		$this->sendHeader();
		echo $this->body;
	}

	public function setHeader($header){
		$this->headers[] = $header;
		return $this;
	}

	public function write($data=''){
		$this->body .= $data;
		return $this;
	}
	
	public function notFound(){
		$this->setHeader("HTTP/1.1 404 Not Found")
		->write("not found")
		->send();
	}

	private function sendHeader(){
		foreach($this->headers as $header){
			header($header);
		}
	}
}