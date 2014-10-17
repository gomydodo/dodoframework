<?php
require dirname(__DIR__) . '/vendor/autoload.php';

Dodo\Application::getInstance(dirname(__DIR__) . '/app')-> run();