<?php

namespace WallaceMaxters\Timer;

class Time
{
    const HOUR_FORMAT = '%h';

    const MINUTE_FORMAT = '%i';

    const SECOND_FORMAT = '%s';

    const TOTAL_MINUTES_FORMAT = '%I';

    protected $seconds = 0;

    protected $format = '%h:%i:%s';
    
    protected $diff;

    
    public function __construct($hours = 0, $minutes = 0, $seconds = 0)
    {
        $this->setTime($hours, $minutes, $seconds);
        
        $this->setDiffObject(new Diff);
    }

    public function setTime($hours, $minutes, $seconds)
    {

        $this->seconds = intval($hours) * 3600;
        $this->seconds += intval($minutes) * 60;
        $this->seconds += intval($seconds);

        return $this;
    }

    public function setSeconds($seconds)
    {
        return $this->setTime(0, 0, $seconds);
    }

    public function setMinutes($minutes)
    {
        return $this->setTime(0, $minutes, 0);
    }

    public function setHours($hours)
    {
        return $this->setTime($hours, 0, 0);
    }

    public function addSeconds($seconds)
    {
        return $this->setTime(0, 0, $this->seconds + intval($seconds));
    }

    public function addMinutes($minutes)
    {
        return $this->setTime(0, intval($minutes), $this->seconds);
    }

    public function addHours($hours)
    {
        return $this->setTime(intval($hours), 0, $this->seconds);
    }
    
    public function getSeconds()
    {
        return $this->seconds;
    }

    public function format($format)
    {
        $hours = floor($this->seconds / 3600);

        $minutes = floor(($this->seconds - ($hours * 3600)) / 60);

        $seconds = floor($this->seconds % 60);

        $totalMinutes = $hours * 60;

        $elements = array_map(
            [$this, 'zeroPadding'],
            compact('hours', 'minutes', 'seconds', 'totalMinutes')
        );

        $aliases = [
            self::HOUR_FORMAT,
            self::MINUTE_FORMAT, 
            self::SECOND_FORMAT, 
            self::TOTAL_MINUTES_FORMAT,
        ];

        return str_replace($aliases, $elements, $format);
    }


    public function setFormat($format)
    {
        $this->format = (string) $format;

        return $this;
    }


    public function __toString()
    {
        return $this->format($this->format);
    }
    
    public function setDiffObject(DiffInterface $diff)
    {
        $this->diff = $diff;
        
        $this->diff->setTime($this);
        
        return $this;
    }
    
    public function diff(Time $time)
    {
        return $this->diff->diff($time);
    }

    protected function zeroPadding($value)
    {
        return sprintf('%02s', $value);
    }

    /**
    * @access public
    * @static
    * @uses func_get_args used by dinamic arguments call
    * @uses call_user_func_array used by call \WallaceMaxters\Timer\Parser::parseFormat
    * @return \WallaceMaxters\Timer\Time
    */
    public static function createFromFormat()
    {
        $parser = call_user_func_array([new Parser, 'parseFormat'], func_get_args());

        return $parser->getTime();
    }
}