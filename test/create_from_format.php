<?php

include_once __DIR__ . '/../vendor/autoload.php';

use WallaceMaxters\Timer\Time;

$time = Time::createFromFormat('%h:%i', '00:86');

print_r($time);

var_dump($time->format('%h hour(s) and %i minute(s) and %s second(s)'));


while (true) {
	
	var_dump(Time::createFromNow()->format('%h:%i:%s'));	

	sleep(1);
}
