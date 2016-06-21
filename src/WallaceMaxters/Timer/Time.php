<?php

namespace WallaceMaxters\Timer;

use JsonSerializable;
use PHPLegends\Collections\Arrayable;

/**
 * Class for work with Times
 *
 * @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
 *
 * */
class Time implements JsonSerializable
{

    const HOUR_FORMAT = '%h';

    const MINUTE_FORMAT = '%i';

    const SECOND_FORMAT = '%s';

    const TOTAL_MINUTES_FORMAT = '%I';

    const SIGN_NEGATIVE = '%r';

    const SIGN_ANY = '%R';

    const DEFAULT_FORMAT = '%r%h:%i:%s';

    /**
     * @var float
     * */

    protected $seconds = 0;

    /**
     * @var string
     * The output format
     * */
    protected $format = self::DEFAULT_FORMAT;


    /**
    * The constructor
    * @param float $hours
    * @param float $minutes
    * @param float $seconds
    */
    public function __construct($hours = 0, $minutes = 0, $seconds = 0)
    {
        $this->setTime($hours, $minutes, $seconds);
    }

    /**
    * Easy way for chainability
    * @static
    * @param float $hours
    * @param float $minutes
    * @param float $seconds
    * @return static
    */

    public static function create($hours = 0, $minutes = 0, $seconds = 0)
    {
        return new static($hours, $minutes, $seconds);
    }

    /**
     * @param float $hours
     * @param float $minutes
     * @param float $seconds
     * @return $this
     * */

    public function setTime($hours, $minutes, $seconds)
    {
        $this->seconds  = ((float) $hours) * 3600;

        $this->seconds += ((float) $minutes) * 60;

        $this->seconds += (float) $seconds;

        return $this;
    }

    /**
     * @param float $seconds
     * */
    public function setSeconds($seconds)
    {
        $this->seconds = $seconds;

        return $this;
    }

    /**
     * @param float $minutes
     * */
    public function setMinutes($minutes)
    {
        return $this->setTime(0, $minutes, 0);
    }

    /**
     * @param float $hours
     * */
    public function setHours($hours)
    {
        return $this->setTime($hours, 0, 0);
    }

    /**
     * Add seconds
     * @param float $seconds
     * */
    public function addSeconds($seconds)
    {
        return $this->setTime(0, 0, $this->seconds + (float) $seconds);
    }

    /**
     * Add minutes
     * @param float $minutes
     * */
    public function addMinutes($minutes)
    {
        return $this->setTime(0, $minutes, $this->seconds);
    }

    /**
     * Add hours
     * @param float $hours
     * */
    public function addHours($hours)
    {
        return $this->setTime($hours, 0, $this->seconds);
    }

    /**
     * Get seconds from total hours defined
     * @return float
     * */
    public function getSeconds()
    {
        return $this->seconds;
    }

    /**
     * Format the output timey
     * @param string $format
     * @return string
     * */
    public function format($format = null)
    {
        $format ?: $format = $this->format;

        return strtr($format, $this->getFormattedReplacements());
    }

    /**
     * Define the format used in self::__toString
     * @param string $format
     * */
    public function setFormat($format)
    {
        $this->format = (string) $format;

        return $this;
    }

    /**
     * @return string
     * */

    public function __toString()
    {
        return $this->format($this->format);
    }

    /**
     * Get a new instance of WallaceMaxters\Timer\Time of diff with another Time
     *
     * @param Time $time time for comparation
     * @param boolean $absolute
     * @return \WallaceMaxters\Timer\Time
     * */
    public function diff(Time $time, $absolute = true)
    {
        $diff = $this->getSeconds() - $time->getSeconds();

        return new self(0, 0, $absolute ? abs($diff) : $diff);
    }

    /**
    * Create time from format
    * @static
    * @param string $format = Format from creation
    * @param string $value = string value of time intended for parse
    * @return \WallaceMaxters\Timer\Time
    */
    public static function createFromFormat($format, $value)
    {
        return (new Parser())->fromFormat($format, $value);
    }

    /**
    * @param string $time
    * @return \WallaceMaxters\Timer\Time
    */
    public static function createFromString($time)
    {
        return new static(0, 0, strtotime($time, 0));
    }

    /**
     * @return boolean
     * */

    public function isNegative()
    {
        return $this->seconds < 0;
    }

    /**
     * Implementation for \JsonSerializable
     * @return array
     * */

    public function jsonSerialize()
    {
        return $this->__toString();
    }

    /**
    *
    * @param float $hours
    * @param float $minutes
    * @param float $seconds
    * @return self
    */

    public function add($hours = 0, $minutes = 0, $seconds = 0)
    {
        return $this->addHours($hours)
                    ->addMinutes($minutes)
                    ->addSeconds($seconds);
    }

    /**
     * @param float $number
     * @return self
     * */

    public function divide($number)
    {
        $number = (float) $number;

        if ($number == 0) {

            throw new \InvalidArgumentException('Division by zero');
        }

        return $this->setSeconds($this->getSeconds() / $number);
    }

    /**
     * @param float $number
     * @return $this
     * */
    public function multiply($number)
    {
        $number = (float) $number;

        return $this->setSeconds($this->getSeconds() * $number);
    }

    /**
     * Get members of time in an array
     * @return array
     * */
    public function getMembers()
    {
        $time = [];

        $seconds = abs($this->getSeconds());

        $time['hours'] = floor($seconds / 3600);

        $time['minutes'] = floor(($seconds - ($time['hours'] * 3600)) / 60);

        $time['seconds'] = floor($seconds % 60);

        $time['total_minutes'] = ($time['hours'] * 60) + $time['minutes'];

        return $time;

    }

    /**
     * Gets replacements for the format method
     *
     * @return array
     * */
    protected function getFormattedReplacements()
    {
        $time = $this->getMembers();

        $negative = $this->isNegative();

        return [
            self::HOUR_FORMAT          => sprintf('%02d', $time['hours']),
            self::MINUTE_FORMAT        => sprintf('%02d', $time['minutes']),
            self::SECOND_FORMAT        => sprintf('%02d', $time['seconds']),
            self::TOTAL_MINUTES_FORMAT => sprintf('%02d', $time['total_minutes']),
            self::SIGN_ANY             => $negative ? '-' : '+',
            self::SIGN_NEGATIVE        => $negative ? '-'  : '',
        ];
    }

    /**
     * Gets the default format
     *
     * @return string
    */

    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Is zero?
     *
     * @return boolean
     * */

    public function isZero()
    {
        return $this->getSeconds() == 0;
    }

}
