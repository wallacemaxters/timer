<?php

include_once __DIR__ . '/../vendor/autoload.php';

use WallaceMaxters\Timer\Time;

$time = new Time;

try {

	$time->addHours(-15)
		 ->addMinutes(10);

} catch (Exception $e) {

	var_dump($e->getMessage());
}
