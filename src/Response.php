<?php

namespace Dodo;

class Response{

	private $body;
	private $headers = array();

	private $vars = array();

	public function send(){
		$this->sendHeader();
		echo $this->body;
	}

	public function setHeader($header){
		$this->headers[] = $header;
		return $this;
	}

	public function write($data){
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

	final public function render($file, $data=null){
		$path = Dodo::app()->getConfig('app.path');
		$view = Dodo::app()->getConfig('view.path');
		
		if((in_array(substr($file, 0,1), array('\\','/'))))
			$file = substr($file, 1);
		
        if ((substr($file, -4) != '.php'))
            $file .= '.php';

        $this->template =  $path.'/'.$view.'/'.$file;

        if (!file_exists($this->template)){
            throw new \Exception("Template file not found: {$this->template}.");
        }

        if (is_array($data)) {
            $this->vars = array_merge($this->vars, $data);
        }

        extract($this->vars);

        include $this->template;
	}

}