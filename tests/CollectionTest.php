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

		$collection->push(50);

		$this->assertFalse($collection->isEmpty());
	}

	public function testFilter()
	{

		$collection = Collection::create([
			10, 11, 12, 13, 14, 15
		]);	

		$collection->filter(function ($time)
		{
			return $time->getSeconds() % 2 == 0;
		});
		

		$this->assertEquals(
			10 + 12 + 14,
			$collection->sum()->getSeconds()
		);
	}
}