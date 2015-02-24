
include "vendor/autoload.php";


use WallaceMaxters\Timer\Time;
use WallaceMaxters\Timer\Collection;
use WallaceMaxters\Timer\Diff;


$time = new Time;

$time->setMinutes(70);


echo $time, PHP_EOL;


echo $time->diff(new Time(0, 20))->format('%h:%i:%s'), PHP_EOL;

$time1 = new Time();

$time1->addSeconds(3600)->addSeconds(24);

$time2 = new Time();

$time2->addSeconds(0)->addSeconds(-1);

$diff = new Diff($time1);

$intervalTime = $diff->diff($time2);



$collection = new Collection([50, 60, 70]);


echo $collection->sum()->getSeconds();


$filteredCollection = $collection->filter(function($second){
	return $second->getSeconds() > 30;
});



print_r($filteredCollection);
