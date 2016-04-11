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


}