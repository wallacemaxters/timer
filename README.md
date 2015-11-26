
#Uso Básico

O `WallaceMaxters\Timer` pode ser instalado através do composer:

```
{
    "require": {
        "wallacemaxters/timer": "dev-master"
    }
   
}

```
#inclusão das classes
```php

include "vendor/autoload.php";


use WallaceMaxters\Timer\Time;
use WallaceMaxters\Timer\Collection;

```
#Criação da instância

O objeto **WallaceMaxters\Timer\Time** pode ser instanciado com parâmetro ou não

```php
  list($hours, $minutes, $seconds) = [1, 0, 30];
  
  new Time($hours, $minutes, $seconds);
```

Também os parâmetros podem ser passados depois da instanciação do objeto:

```php
$time = new Time();

$time->setSeconds(30);

$time->setMinutes(30);

$time->addMinutes(30); // Diferente dos métodos que inciam com "set", ele adiciona valores no já existente
```
#Maneira curta para definir o tempo
```php
$time->setTime($hours, $minutes, $seconds);

```
#testando o objeto Time
```php
$time = new Time;

$time->setMinutes(70);


echo $time, PHP_EOL; // 01:10:00
```
#Diferença entre dois tempos com o método **Time::diff**
```
echo $time->diff(new Time(0, 20))->format('%h:%i:%s'), PHP_EOL; // 00:50:00


echo $time->setFormat('%h horas %i minutos e %s segundos'), PHP_EOL; // 01 horas 10 minutos e 00 segundos

Time::disableExceptionOnNegative();

$time1 = new Time();

$time1->addSeconds(3600)->addSeconds(24);

$time2 = new Time();

// Cuidado! Se o valor do tempo alcancar negativos, pode ser lançadas exceções

$time2->addSeconds(-10);



```

#O objeto Diff.

Ao chamar o objeto Diff, ele retornará uma nova instância de Time, com os segundos comparados.

```php


$time1 = Time::create(0, 20, 0);

$time2 = Time::create(0, 15, 0);

$diff = $time1->diff($time2);
echo $diff->format('%h:%i:%s'); // 00:05:00

```

#O objeto **Collection**
```
$collection = new Collection([50, 60, 70]);

// OR

$collection = new Collection([
     Time::create(0,0,50),
     Time::create(0,0,60)
]);


echo $collection->sum()->getSeconds();


$collection->filter(function ($second) {
   return $second->getSeconds() > 30;
});


```
