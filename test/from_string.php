<?php

include_once __DIR__ . '/../vendor/autoload.php';

use WallaceMaxters\Timer\Time;

$time = Time::createFromString('10 day');

$time->addMinutes(50);

var_dump($time->format('%h:%i:%s'));

var_dump($time->format('%h:%i:%s'));