#Time Library

This is a library for PHP for work with time.

In PHP, the DateTime has a limitation because doesnt work with times greather than 24 hours.


The Timer library solves this problem.

See:


```php
use WallaceMaxters\Timer\Time;

$time = Time::create(0, 0, 10);

$time->format('%h:%i%s'); // '00:00:10'

$time->addSeconds(30);

$time->format(); // '00:00:40'

$time->addSeconds(-50);

$time->format('%h:%i%s'); // '-00:00:10'

```

For use collection:

``php


```