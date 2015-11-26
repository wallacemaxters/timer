<?php

namespace WallaceMaxters\Timer;

use UnexpectedValueException;

/**
 * @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
 * 
 * Time class for work with timer
 * */
class Time
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
     * @var WallaceMaxters\Timer\Diff
     * */
    protected $diff;

    protected static $negativeException = true;

    
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

        $this->negativeHandler();

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
     * Format the output time
     * <code>
     *      Time::create(1, 59, 59)->format('%h:%i:%s');
     *      // "1:59:59"
     * </code>
     * @param string $format 
     * */
    public function format($format = null)
    {

        if (null === $format) {
            $format = $this->format;
        }

        $hours =   floor($this->seconds / 3600);

        $minutes = floor(($this->seconds - ($hours * 3600)) / 60);

        $seconds = floor($this->seconds % 60);

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

        return str_replace($aliases, $elements, $format);
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
     * 
     * @deprecated since 1.2 . Use setDiff instead of
     * */

    public function setDiffObject(DiffInterface $diff)
    {
        return $this->setDiff($diff);
    }

    /**
     * @param \WallaceMaxters\Timer\DiffInterface $diff
     * @return $this
     * */
    public function setDiff(DiffInterface $diff)
    {
        $this->diff = $diff;

        $this->diff->setTime($this);

        return $this;
    }

    /**
     * @return WallaceMaxters\Timer\DiffInterface
     * */
    public function getDiff()
    {
        return $this->diff ?: $this->diff = new Diff($this);
    }
    
    /**
     * Get a new instance of WallaceMaxters\Timer\Time of diff with another Time
     * 
     * @param Time $time time for comparation
     * @return \WallaceMaxters\Timer\Time
     * */
    public function diff(Time $time)
    {
        return $this->getDiff()->diff($time);
    }

    /**
    * Create time from format
    * @static
    * @param string $format = Format from creation
    * @param string $value = string value of time intended for parse
    * @param string $separator (optional)
    * @return \WallaceMaxters\Timer\Time
    */
    public static function createFromFormat($format, $value, $separator = ':')
    {

        $parser = new Parser(new self);

        $parser->parseFormat($format, $value, $separator);

        return $parser->getTime();
    }

    /**
     * Handles the negative values of seconds
     * If exceptions enable, throws \Unexceptedvalueexception
     * @return void
     * */
    protected function negativeHandler()
    {

        if ($this->seconds < 0) {

            $this->setTime(0, 0, 0);

            if (static::$negativeException == true) {

                throw new UnexpectedValueException('Invalid time defined. Negative time is not accepted');
            }
        }
    }

    public static function enableExceptionOnNegative()
    {
        static::$negativeException = true;
    }

    public static function disableExceptionOnNegative()
    {
        static::$negativeException = false;
    }
}