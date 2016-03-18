<?php

use WallaceMaxters\Timer\Parser;
use WallaceMaxters\Timer\Time;

class PaserTest extends PHPUnit_Framework_TestCase
{
	public function __construct()
	{
		$this->parser = new Parser(new Time);
	}

	public function testFromFormat()
	{
		$time = $this->parser->fromFormat('%h:%i:%s', '00:50:00');

		$time2 = $this->parser->fromFormat('%h horas e %i minutos', '100 horas e 50 minutos');

		$this->assertEquals(
			50 * 60,
			$time->getSeconds()
		);


		$this->assertEquals(
			'100:50:00',
			$time2->format()
		);
	}




	public function testException()
	{
		try {

			$this->parser->fromFormat('%i', '100');

			throw new Exception('Exceção InvalidArgumentException não lançada');

		} catch(\InvalidArgumentException $e) {

			$this->assertInstanceOf(
				'InvalidArgumentException',
				$e
			);
		}
	}
}