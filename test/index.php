<?php
require dirname(__DIR__) . '/vendor/autoload.php';


$config = ['app.path' => dirname(__DIR__) . '/app'];
Dodo\Dodo::getInstance($config)->run();