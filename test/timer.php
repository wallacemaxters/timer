<?php

include_once __DIR__ . '../../../../../vendor/autoload.php';

use WallaceMaxters\Timer\Time;

$time = Time::create(1);

while ($time->getSeconds() > 0) {

	$time->addMinutes(-10);

	var_dump($time->format('%h:%i:%s'));
}
