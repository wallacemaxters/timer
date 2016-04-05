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

		$this->assertTrue($time->isNegative());
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


	public function testDiff()
	{
		$time = new Time(0, 0, 10);

		$time2 = new Time(0, 0, 5);


		$this->assertEquals(
			5,
			$time->diff($time2, true)->getSeconds()
		);

		$this->assertEquals(
			-5,
			$time2->diff($time, false)->getSeconds()
		);

		$this->assertEquals(
			5,
			$time2->diff($time, true)->getSeconds()
		);
	}

	public function testAddMethod()
	{
		$time = Time::create();

		$time->add(7);

		$time->add(0, 50);

		$time->add(0, 0, 20);

		$time->add(-3);

		$this->assertEquals(
			'04:50:20',
			$time->format()
		);
	}


	public function testCreateFromString()
	{
		$time = Time::createFromString('+2 day');

		$time->addMinutes(25);

		$this->assertEquals(
			'48:25:00',
			$time->format()
		);

		$time2 = Time::createFromString('100 hours 5 minutes');

		$this->assertEquals(
			'100:05:00',
			$time2->format()
		);
	}


	public function testFormat()
	{

		$time = Time::create(23, 59, 59);

		$time->setFormat("%hh%im%ss");

		$this->assertEquals(
			'23h59m59s',
			$time->format()
		);

		$this->assertEquals(
			'H[23]M[59]S[59]',
			$time->format("H[%h]M[%i]S[%s]")
		);
	}


	public function testTotalMinutes()
	{
		$time = Time::create(2, 20, 0);

		$this->assertEquals(
			'140:00',
			$time->format('%I:%s')
		);
	}
}