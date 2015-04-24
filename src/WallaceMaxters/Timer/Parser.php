<?php

namespace WallaceMaxters\Timer;

use InvalidArgumentException;

class Parser
{

    /**
    * @var \WallaceMaxters\Timer\Time
    */
    protected $time;

    /**
    * @var array
    */
    protected $replacementFormats = [
        Time::HOUR_FORMAT   => '\d{1,2}',
        Time::MINUTE_FORMAT => '\d{1,2}',
        Time::SECOND_FORMAT => '\d{1,2}',
    ];

    /**
    * Object Constructor
    * @return void
    */

    public function __construct()
    {
        $this->time = new Time;
    }

    /**
    * @return \WallaceMaxters\Timer\Time
    */
    public function getTime()
    {
        return $this->time;
    }

    /**
    * @access public
    * @param string $format
    * @param string $value
    * @param string $separator = Format of separator
    * @return \WallaceMaxters\Timer\Time
    * @throws \InvalidArgumentException
    */

    public function parseFormat($format, $value, $separator = ':')
    {
        $regexPart = strtr(preg_quote($format), $this->replacementFormats);

        if (! preg_match("/^{$regexPart}$/", $value)) {

            throw new InvalidArgumentException('Non-compatible format in comparison with value');
        }

        $values = array_map('intval', explode($separator, $value));

        $formats = array_map('trim', explode($separator, $format));

        $combined = array_combine($formats, $values);

        if (isset($combined[Time::HOUR_FORMAT])) {

            $this->time->addHours($combined[Time::HOUR_FORMAT]);
        }

        if (isset($combined[Time::MINUTE_FORMAT])) {

            $this->time->addMinutes($combined[Time::MINUTE_FORMAT]);
        }

        if (isset($combined[Time::SECOND_FORMAT])) {

            $this->time->addSeconds($combined[Time::SECOND_FORMAT]);  
        }

        return $this;
    }

}