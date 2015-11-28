<?php

include_once __DIR__ . '/../vendor/autoload.php';

use WallaceMaxters\Timer\Collection as TimeCollection;


$collection = TimeCollection::create([40, 50, 60]);

// Clear Test
$collection->clear();

// From Array Test
$collection->fromArray([
	50, 
	60,
	60, 
	60, 
	70,
	75
]);


var_dump($collection->sum(), $collection->isEmpty());


var_dump($collection->first(function ($time)
{
	return $time->getSeconds() == 600;
}));



var_dump($collection->min(), $collection->max(), $collection->avg());
