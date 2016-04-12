<?php

use WallaceMaxters\Timer\Collection;
use WallaceMaxters\Timer\Time;

class CollectionTest extends PHPUnit_Framework_TestCase
{
    public function testSum()
    {
        $collection = Collection::create([50, 60, 70]);

        $time = $collection->sum();

        $this->assertInstanceOf('WallaceMaxters\Timer\Time', $time);

        $this->assertEquals(
            180,
            $time->getSeconds()
        );

        $this->assertEquals(
            '00:03:00',
            $time->format('%h:%i:%s')
        );
    }

    public function testAverage()
    {
        $collection = Collection::create([50, 100, 50, 100]);

        $avg = (50 + 100 + 50 + 100) / 4;

        $this->assertEquals(
            $avg,
            $collection->average()->getSeconds()
        );

        $this->assertEquals(
            Time::create(0, 0, $avg)->format(),
            $collection->average()->format()
            
        );
    }


    public function testCount()
    {
        $collection = Collection::create([60, 70, new Time(0, 0, 70)]);

        $this->assertCount(3, $collection);

        $this->assertEquals(3, $collection->count());

        $this->assertInstanceOf('Countable', $collection);

        $this->assertEquals(3, count($collection));

    }

    public function testEmpty()
    {
        $collection = Collection::create([]);

        $this->assertTrue($collection->isEmpty());

        $collection->add(50); // seconds

        $this->assertFalse($collection->isEmpty());
    }

    public function testFilter()
    {

        $collection = Collection::create([
            10, 11, 12, 13, 14, 15
        ]); 

        // Now, filter method return new Collection instance

        $collection = $collection->filter(function ($time)
        {
            return $time->getSeconds() % 2 == 0;
        });
        

        $this->assertEquals(
            10 + 12 + 14,
            $collection->sum()->getSeconds()
        );
    }

    public function testInheritCollection()
    {
        $collection = Collection::create();

        $collection[] = Time::createFromFormat('%h:%i', '02:30');

        $collection[] = Time::createFromFormat('%h:%i', '01:30');

        $this->assertCount(2, $collection);

        $collection['special_time'] = Time::createFromString('+2 seconds');

        $this->assertCount(3, $collection);

        $this->assertEquals(
            '00:00:02',
            $collection['special_time']->format()
        );

        $this->assertEquals(
            '01:30:00',
            $collection[1]->format()
        );


        $time = $collection->shift();

        $this->assertEquals(
            '02:30:00',
            $time->format()
        );

        $this->assertCount(2, $collection);

        $this->assertEquals(
            '01:30:00',
            $collection->first()->format()
        );

    }

    public function testNumberCasts()
    {
        $collection = Collection::create();

        $collection->set('first', 40);

        $collection->merge([
            5,
            10,
            Time::createFromString('+18 seconds'),
            20,
            Time::create(0, 10, 10)
        ]);

        $collection->add(50);       

        // Check if all is Instance of time

        foreach ($collection as $key => $time)
        {
            $this->assertInstanceOf('WallaceMaxters\Timer\Time', $time);
        }

        $this->assertEquals(
            '00:00:40',
            $collection->first()->format()
        );

        $this->assertEquals(
            '00:00:50',
            $collection->last()->format()
        );
    }


    public function testMathMethodsWithCallbacks()
    {
        $times = Collection::create();

        $times->add(
            Time::createFromFormat(Time::DEFAULT_FORMAT, '00:20:00')
        );

        $times[] = Time::create(0, 20, 10);

        $seconds = $times->sum(function ($time)
        {
            return $time->getSeconds();
        });

        $this->assertEquals(
            (20 * 60) + ((20 * 60) + 10),
            $seconds
        );

    }

    public function testMaxMinAndAverage()
    {
        $c = Collection::create([10, 20, 30]);

        $this->assertEquals(30, $c->max()->getSeconds());

        $this->assertEquals(10, $c->min()->getSeconds());

        $this->assertEquals((10+20+30)/3, $c->average()->getSeconds());


        $c->max(function ($time)
        {
            return $time;
            
        })->getSeconds();


        // Test empty collection

        $this->assertEquals(0, $c->clear()->max()->getSeconds());

        $this->assertEquals(0, $c->clear()->min()->getSeconds());

        $this->assertEquals(0, $c->clear()->sum()->getSeconds());
    }

    public function testUnique()
    {
        $c = Collection::create([10, 20]);

        $c[] = Time::create(0, 0, 20); // repeated

        $c[] = 40; 

        $c[] = Time::create(0, 0, 40); // repeated

        $this->assertCount(3, $c->unique());

        $this->assertEquals(
            [10, 20, 40],
            array_values($c->unique()->toArrayOfSeconds())
        );
    }


    public function testAddAll()
    {


        $c1 = Collection::create([5, 10, 15, 20]);

        $c2 = Collection::create([4, 6, 8, 12]);

        $c1->addAll($c2);

        $this->assertCount(8, $c1);

    }

    public function testRemoveAll()
    {

        $c1 = Collection::create([1, 3, 6, 9]);

        $c2  = Collection::create([
            $c1[0], $c1[2], 10
        ]);

        $c1->removeAll($c2);

        $this->assertCount(2, $c1);
    }

    public function testRemove()
    {
        $time1 = Time::create(0, 20);

        $c1 = Collection::create([
            $time1, 30, 40, 50
        ]);

        $time2 = $c1[3];

        $deletes[] = $c1->remove($time1);

        $deletes[] = $c1->remove($time2);

        $this->assertEquals([0, 3], $deletes);
    }

    public function testSearch()
    {
        $c = Collection::create([10, 20, 30]);

        $time = $c->last();

        $this->assertEquals(
            2,
            $c->search($time)
        );
    }


}