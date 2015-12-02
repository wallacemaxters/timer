<?php

include_once __DIR__ . '/../vendor/autoload.php';

use WallaceMaxters\Timer\Time;
use WallaceMaxters\Timer\Collection;


$collection = Collection::create()
		   ->attach(Time::createFromString('1 hour 3 minutes'))
		   ->attach(Time::createFromString('3 hours'));


echo "Collection total time\n\n";

print_r($collection->toArray());

var_dump($collection->sum()->format());

echo "Time comparision: \n\n";

$time = Time::create(5, 0, 0);

var_dump($collection->sum()->getSeconds() > $time->getSeconds());

$collection->push(5000);

var_dump($collection->sum()->format());

var_dump($collection->sum()->getSeconds() > $time->getSeconds());

