<?php

include_once __DIR__ . '/../vendor/autoload.php';

use WallaceMaxters\Timer\Time;

$time = Time::createFromFormat('%h:%i', '00:86');

print_r($time);

var_dump($time->format('%h hour(s) and %i minute(s) and %s second(s)'));

$a = Time::createFromCurrentTimestamp();

$b = Time::createFromCurrentTimestamp(new DateTimeZone('America/Manaus'));

$c = Time::createFromString('4 hours 3 minutes 150 seconds');


var_dump((string)$a, (string)$b, (string)$c);


while (true) {
	
	var_dump(Time::createFromNow()->format('%h:%i:%s'));	
	var_dump(Time::createFromNow(new DateTimeZone('America/Manaus'))->format('%h:%i:%s'));	

	sleep(1);	
}
