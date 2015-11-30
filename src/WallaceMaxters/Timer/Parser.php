<?php

namespace WallaceMaxters\Timer;

use InvalidArgumentException;

/**
 * @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
*/
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
        Time::HOUR_FORMAT   => '\d+',
        Time::MINUTE_FORMAT => '\d{1,2}',
        Time::SECOND_FORMAT => '\d{1,2}',
    ];

    /**
    * Object Constructor
    * @return void
    */

    public function __construct(Time $time = null)
    {
        $this->time = $time ?: new Time;
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

    public function fromFormat($format, $value, $separator = ':')
    {
        $regexPart = strtr(preg_quote($format), $this->replacementFormats);

        if (! preg_match("/^{$regexPart}$/", $value)) {

            throw new InvalidArgumentException('Non-compatible format in comparison with value');
        }

        // Example: %h:%i

        $formats = array_map('trim', explode($separator, $format));

        // Example 01:23

        $values = array_map('intval', explode($separator, $value));

        // Returned example: ['%h' => 10, '%i' => 10]

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

    /**
     * @deprecated use format instead of
     * */
    public function parseFormat($format, $value, $separator = ':')
    {
        return $this->fromFormat($format, $value, $separator);
    }

}