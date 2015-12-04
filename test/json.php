<?php

include_once __DIR__ . '/../vendor/autoload.php';

use WallaceMaxters\Timer\Collection;


$collection = Collection::create()
						->push(50)
						->push(10)
						->mergeArray([10, 50, 700])
						->push(100);

$collection->setFormat()

var_dump(json_encode($collection, JSON_PRETTY_PRINT));

var_dump(json_encode($collection->sum(), JSON_PRETTY_PRINT));

