<?php

include_once __DIR__ . '/../vendor/autoload.php';

use WallaceMaxters\Timer\Collection as TimeCollection;
use WallaceMaxters\Timer\Time;


$collection = TimeCollection::create([40, 50, 60]);

$t = Time::create(0, 50, 0);

// Clear Test
$collection->clear();

// From Array Test
$collection->fromArray([
	50, 
	60,
	60, 
	$t,
	60, 
	70,
	75
]);


var_dump($collection->count());

$collection->detach($t);

var_dump($collection->count());


var_dump($collection->sum(), $collection->isEmpty());


var_dump($collection->first(function ($time, $key)
{
	return $time->getSeconds() == 60;
})->getSeconds());


var_dump($collection->last(function ($time, $key)
{
	return $time->getSeconds() == 60;

})->getSeconds());

var_dump($collection->last()->getSeconds());

echo "Testing min, max and average:\n\n";

var_dump($collection->min(), $collection->max(), $collection->average());
