<?php

include_once __DIR__ . '/../vendor/autoload.php';

use WallaceMaxters\Timer\Time;

$time1 = Time::create(2, 59); // 2:59:00

$time2 = Time::create(2, 20); // 2:20:00

$time1->addSeconds(-1); 

$diffTime = $time1->diff($time2);

var_dump($diffTime->format('%h:%i:%s')); // 00:38:59

// CreateFromFormat Test

$time3 = Time::createFromFormat('%i:%s', '1:30');

// Inversion of Diff

var_dump($time3->diff($diffTime)->format('%h:%i:%s')); // 00:37:29


