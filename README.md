#WallaceMaxters\Timer\Time

Classe para trabalhar com tempo. Você pode trabalhar com tempos semelhantemente aos crônometos, que ultrapassam os limites das 24 horas impostos pelo "tempo do relógio".

A classe `DateTime` não conseguirá atingir o resultado desejado caso precise de um tempo como `28:00:00`. Pois isso será convertido para 4 horas e 1 dia. 

Através da classe `WallaceMaxters\Timer\Time` podemos contornar esse problema.


Exemplos:

O `WallaceMaxters\Timer` pode ser instalado através do composer:

```json
{
    "require": {
        "wallacemaxters/timer": "1.1.*"
    }
}

```
#inclusão das classes
```php
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
```

```php 
$time1 = new Time();

$time1->addSeconds(3600)->addSeconds(24);

$time2 = new Time();

$time2->addSeconds(-10);

$diff = $time1->diff($time2);
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
Com o objeto `WallaceMaxters\Timer\Collection` é possível adicionar uma lista de `Time` à coleção. Isso torna possível a utilização de filtros, somas e afins.

```
$collection = new Collection([50, 60, 70]);

// OR

$collection = new Collection([
     Time::create(0,0,50),
     Time::create(0,0,60)
]);

// Retorna um Time com os resultados somados

echo $collection->sum()->getSeconds();

$collection->filter(function ($second) {
   return $second->getSeconds() > 30;
});
```

#LARAVEL 4

Para utilizar no Framework Laravel, basta instalar a versão `1.1.0 >=` e adicionar os seguintes trechos no arquivo `config/app.php` 

**Facade**
```php 
'Time' =>  'WallaceMaxters\Timer\Laravel\TimeFacade',
```

**ServiceProvider**
```php
'WallaceMaxters\Timer\Laravel\TimeServiceProvider',
```

No Laravel é possível fazer a chamada:

```php
Time::addSeconds(30)->addSeconds(30)->format('%h:%i');
```

*Atenção*

O ServiceProvider torna a instância de `WallaceMaxters\Timer\Time` única.

Para contornar isso, você poderá usar o método `Time::create`

```php
Time::create()->addSeconds(30);
```

