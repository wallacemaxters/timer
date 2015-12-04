<?php

include_once __DIR__ . '/../vendor/autoload.php';

use WallaceMaxters\Timer\Collection;


$collection = Collection::create()
						->push(50)
						->push(10)
						->mergeArray([10, 50, 700])
						->push(100);

$collection->setFormat('%h hora %i minutes e %s segundos');


echo $collection->getFormat();

var_dump(json_encode($collection, JSON_PRETTY_PRINT));

var_dump(json_encode($collection->sum(), JSON_PRETTY_PRINT));


foreach($collection as $time)
{
	var_dump(json_encode($time));
}
