#WallaceMaxters\Timer Library

This is a library to work only with time in PHP.

Sometimes we need to work with hours, passing 24 in php, but the DateTime class or other functions to date do not have a satisfactory solution;

So developed the Timer library.

With it you can work with the time very simply:


```php
use WallaceMaxters\Timer\Time;

$time = Time::create(0, 0, 10);

$time->format('%h:%i%s'); // '00:00:10'

$time->addSeconds(30);

$time->format(); // '00:00:40'

$time->addSeconds(-50);

$time->format('%h:%i%s'); // '-00:00:10'

```

If necessary you can also also use the Collection class, to facilitate some operations over time.

```php

use WallaceMaxters\Timer\Collection;

$collection = new Collection;

$collection[] = Time::create(0, 10, 0);

$collection[] = Time::createFromString('10 seconds');

$collection[] = Time::createFromFormat('%h:%i', '00:50');

$collection->sum(); // new Time(0, 11, 0);

$collection->min(); // new time(0, 0, 10); 

```

An example for time greather than 24 hours:

```php
// DateTime
$date = DateTime::createFromFormat('25:00:00');

var_dump($date->format('H:i:s')); // 01:00:00

// WallaceMaxters\Timer\Timer

$time = Time::createFromFormat('%h:%i:%s', '26:00:00');

var_dump($time->format()); // '26:00:00'

```
