<?php

namespace WallaceMaxters\Timer;

use JsonSerializable;

/**
 * @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
 * 
 * Time class for work with timer
 * */
class Time implements JsonSerializable
{
    const HOUR_FORMAT = '%h';

    const MINUTE_FORMAT = '%i';

    const SECOND_FORMAT = '%s';

    const TOTAL_MINUTES_FORMAT = '%I';

    const DEFAULT_FORMAT = '%h:%i:%s';

    /**
     * @var int
     * */

    protected $seconds = 0;

    /**
     * @var string
     * The output format
     * */
    protected $format = self::DEFAULT_FORMAT;
    

    /**
    * The constructor
    * @param int $hours
    * @param int $minutes
    * @param int $seconds
    */
    public function __construct($hours = 0, $minutes = 0, $seconds = 0)
    {
        $this->setTime($hours, $minutes, $seconds);
    }

    /**
    * Easy way for chainability
    * @static
    * @param int $hours
    * @param int $minutes
    * @param int $seconds
    * @return static
    */

    public static function create($hours = 0, $minutes = 0, $seconds = 0)
    {
        return new static($hours, $minutes, $seconds);
    }

    /**
     * @param int $hours 
     * @param int $minutes
     * @param int $seconds 
     * @return $this
     * */

    public function setTime($hours, $minutes, $seconds)
    {

        $this->seconds  = ((int) $hours) * 3600;
        $this->seconds += ((int) $minutes) * 60;
        $this->seconds += (int) $seconds;

        return $this;
    }

    /**
     * @param int $seconds
     * */
    public function setSeconds($seconds)
    {
        return $this->setTime(0, 0, $seconds);
    }

    /**
     * @param minutes $minutes
     * */
    public function setMinutes($minutes)
    {
        return $this->setTime(0, $minutes, 0);
    }

    /**
     * @param int $hours
     * */
    public function setHours($hours)
    {
        return $this->setTime($hours, 0, 0);
    }

    /**
     * Add seconds
     * @param $seconds
     * */
    public function addSeconds($seconds)
    {
        return $this->setTime(0, 0, $this->seconds + (int)$seconds);
    }

    /**
     * Add minutes
     * @param int $minutes
     * */
    public function addMinutes($minutes)
    {
        return $this->setTime(0, (int) $minutes, $this->seconds);
    }

    /**
     * Add hours
     * @param int $hours
     * */
    public function addHours($hours)
    {
        return $this->setTime((int) $hours, 0, $this->seconds);
    }
    
    /**
     * Get seconds from total hours defined
     * @return int
     * */
    public function getSeconds()
    {
        return $this->seconds;
    }

    /**
     * Format the output timey
     
     * @param string $format 
     * */
    public function format($format = null)
    {

        if (null === $format) {
            $format = $this->format;
        }

        $absoluteSeconds = abs($this->seconds);

        $hours =   floor($absoluteSeconds / 3600);

        $minutes = floor(($absoluteSeconds - ($hours * 3600)) / 60);

        $seconds = floor($absoluteSeconds % 60);

        $totalMinutes = $hours * 60;

        $elements = array_map(function ($value)
        {   
            return sprintf('%02d', $value);

        },[$hours, $minutes, $seconds, $totalMinutes]);

        $aliases = [
            self::HOUR_FORMAT,
            self::MINUTE_FORMAT, 
            self::SECOND_FORMAT, 
            self::TOTAL_MINUTES_FORMAT,
        ];

        $output = str_replace($aliases, $elements, $format);

        if ($this->isNegative()) {

            return '-' . $output;
        }

        return $output;

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
    * Create full hours from current timestamp
    * @static
    * @return \WallaceMaxters\Timer\Time
    */
    public static function createFromCurrentTimestamp()
    {
        return new static(0, 0, strtotime('now'));
    }

    /**
    * Create the time from now time only
    * @static
    * @param $timezone null|\DateTimeZone
    * @return \WallaceMaxters\Timer\Time
    */

    public static function createFromNow(\DateTimeZone $timezone = null)
    {
        return static::createFromFormat(
            '%h:%i:%s',
            (new \DateTime('now', $timezone))->format('H:i:s')
        );
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
        return [
            'formatted' => $this->format(),
            'seconds'   => $this->getSeconds(),
        ];
    }


    /**
    * 
    * @param int $hours
    * @param int $minutes
    * @param int $seconds
    * @return \WallaceMaxters\Timer\Time
    */

    public function add($hours = 0, $minutes = 0, $seconds = 0)
    {
        return $this->addHours($hours)
                    ->addMinutes($minutes)
                    ->addSeconds($seconds);
    }

    
}