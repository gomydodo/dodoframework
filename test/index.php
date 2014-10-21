<?php
require dirname(__DIR__) . '/vendor/autoload.php';

error_reporting(E_ALL);

$config = ['app.path' => dirname(__DIR__) . '/app'];
Dodo\Dodo::getInstance($config)->run();