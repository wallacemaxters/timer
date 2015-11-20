<?php

include_once __DIR__ . '../../../../../vendor/autoload.php';

use WallaceMaxters\Timer\Time;

//Time::enableExceptionOnNegative();

$time = new Time;

try {
	$time->addHours(1);

} catch (Exception $e) {

	var_dump($e->getMessage());
}


var_dump($time->format('%I:%s'));