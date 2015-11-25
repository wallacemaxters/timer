<?php

include_once __DIR__ . '/../vendor/autoload.php';

use WallaceMaxters\Timer\Time;

$time = Time::create(0, 0, PHP_INT_MAX);

var_dump($time->format('%h:%i:%s'));