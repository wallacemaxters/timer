<?php

include_once __DIR__ . '/../vendor/autoload.php';

use WallaceMaxters\Timer\Collection as TimeCollection;
use WallaceMaxters\Timer\Time;

$time = new Time(0, 0, 40);

$collection = TimeCollection::create([40, 50, 60, $time]);

$collection->sortAsc();

$collection->reject(function ($time)
{
	return $time->getSeconds() == 40;	
});

$collection->sortDesc();

print_r($collection);



var_dump($collection->contains($time));