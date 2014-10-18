<?php
require dirname(__DIR__) . '/vendor/autoload.php';

$app = Dodo\Dodo::getInstance(dirname(__DIR__) . '/app');

$app->get('/user', function($req, $res){
	$res->write("hello, user get<form action='/user' method='post'><input type='submit' value='submit'></form>")->send();
});

$app->post('/user', function($req, $res){
	$res->write("hello, user post")->send();
});

$app->get('/user/test', function($req, $res){
	$res->write('user/test')->send();
});

$app->get('/user/test1', function($req, $res){
	$res->write('user/test1')->send();
});

$app->get('/user/test2', function($req, $res){
	var_dump($req->getQuery());
	$res->write('user/test2')->send();
});

$app-> run();