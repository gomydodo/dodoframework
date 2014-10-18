<?php
require dirname(__DIR__) . '/vendor/autoload.php';

Dodo\Dodo::getInstance(dirname(__DIR__) . '/app')-> run();
Dodo\Dodo::app()->get('/sss', function(){
	echo 'ssss';
});