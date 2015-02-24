<?php

namespace WallaceMaxters\Timer;

class Time
{
    protected $aliases = [
        '%h', '%i', '%s'
    ];

    protected $seconds = 0;

    protected $format = '%h:%i:%s';
    
    protected $diff;

    
    public function __construct($hours = 0, $minutes = 0, $seconds = 0)
    {
        $this->setTime($hours, $minutes, $seconds);
        
        $this->setDiffObject(new Diff));
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

        $elements = array_map([$this, 'zeroPadding'], compact('hours', 'minutes', 'seconds'));

        return str_replace($this->aliases, $elements, $format);
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
}