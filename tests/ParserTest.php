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

    public function testValidateFormat()
    {
        $parser = new Parser;

        $valids = ['61:50:00', '00:59:10', '00:21:59'];

        foreach ($valids as $valid)
        {
            $this->assertTrue(
                $parser->isValidFormat('%h:%i:%s', $valid)
            );
        }

        $invalids = ['10:62:00', '00:06:70', '99:00:90', '0:0:1', '00:0:05'];

        foreach ($invalids as $invalid)
        {
            $this->assertFalse($parser->isValidFormat('%h:%i:%s', $invalid));
        }

    }

    public function testNegativeSign()
    {
       $parser = new Parser;
       
       $this->assertTrue($parser->isValidFormat('%r%h:%i:%s', '-00:00:05'));

       $this->assertTrue($parser->isValidFormat('%r%h:%i:%s', '00:00:05'));

       $this->assertFalse($parser->isValidFormat('%r%h:%i:%s', '+00:00:05'));

       $this->assertFalse($parser->isValidFormat('%r%h:%i:%s', '--00:00:05'));


       $time = $parser->fromFormat('%r%h:%i:%s', '-00:00:55');

       $this->assertTrue($time->isNegative());


       // Isso em que dar falso sempre!

       $this->assertFalse($parser->isValidFormat('%r%h:%i:%s', '+00:00:55'));

       $this->assertTrue($parser->isValidFormat('%R%h:%i:%s', '+00:00:55'));

       $this->assertTrue($parser->isValidFormat('%R%h:%i:%s', '-00:00:55'));
    }
}