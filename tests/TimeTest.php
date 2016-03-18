<?php

use WallaceMaxters\Timer\Time;

class TimeTest extends PHPUnit_Framework_TestCase
{
	public function testInstance()
	{
		$time = new Time(0, 2, 10);

		$this->assertEquals('00:02:10', $time->format('%h:%i:%s'));
	}

	public function testSeconds()
	{
		$time = new Time(1, 0, 0);

		$this->assertEquals(3600, $time->getSeconds());

		$time->addHours(1);

		$this->assertEquals(7200, $time->getSeconds());
	}


	public function testNegative()
	{

		$time = new Time(2, 20);

		$time->addHours(-1)->addMinutes(-10);

		$this->assertEquals(
			'01:10:00',
			$time->format('%h:%i:%s')
		);

		$time = new Time(0, 0, -50);

		$this->assertEquals(
			'-00:00:50',
			$time->format()
		);
	}

	public function testCreateFromFormat()
	{

		$time = new Time(0, 0, 10);

		$time2 = Time::createFromFormat('%h:%i:%s', '00:00:10');

		$this->assertEquals(
			$time->format(),
			$time2->format()
		);
	}
}