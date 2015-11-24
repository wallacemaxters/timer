<?php

include_once __DIR__ . '/../vendor/autoload.php';

use WallaceMaxters\Timer\Time;


$time = new Time();

$time->addHours(20);

$time->addMinutes(120); // Equivalent to "2 hours"

$time->addSeconds(58);

var_dump($time->format('%h:%i:%s'));