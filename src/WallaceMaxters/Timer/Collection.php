<?php

namespace WallaceMaxters\Timer;

use IteratorAggregate;
use ArrayAccess;
use ArrayIterator;

class Collection implements ArrayAccess, IteratorAggregate
{

    protected $items = [];

    protected $format = null;
    
    /**
    * @param array $times
    * @param string $format = Default format for all items of collection
    */
    public function __construct(array $times = [], $format = null)
    {
        $this->format = $format;

        foreach($times as $key => $time) {

            if ($time instanceof Time) {
                $this[$key] = $time;
            } else {
                $this[$key] = new Time(0, 0, $time);
            }
        }
    }

    /**
    * Easy way for chainability
    * @static
    * @param array $times
    * @param string $format = Default format for all items of collection
    * @return static
    */
    public static function create(array $times = [], $format = null)
    {
        return new static($times, $format);
    }

    public function setTime($key, Time $time)
    {
        $time->setFormat($this->format);

        if ($key === null) {

            $this->items[] = $time;

        } else {

            $this->items[$key] = $time;

        }

        return $this;
    }

    public function offsetSet($key, $value)
    {
        return $this->setTime($key, $value);
    }

    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    public function offsetExists($key)
    {
        return array_key_exists($key, $this->items);
    }

    public function offsetGet($key)
    {
        if ($this->offsetExists($key)) {

            return $this->items[$key];
        } 

        return null;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    public function sortAsc()
    {    
        asort($this->items);

        return $this;
    }

    public function sortDesc()
    {
        arsort($this->items);

        return $this;
    }

    /**
    * Create a new instance of WallaceMaxters\Timer\Time with all
    *  seconds of items of colection objets summed
    * @return WallaceMaxters\Timer\Time
    */

    public function sum()
    {
        return new Time(0, 0, array_sum($this->toIntegerList()));
    }

    /**
    * Filter all items and create a new instance 
    */

    public function filter($callback)
    {
        return new static(array_filter($this->items, $callback));
    }

    public function clear()
    {
        $this->items = [];

        return $this;
    }

    public function toIntegerList()
    {
        $callback = function ($time)
        {
            return $time->getSeconds();
        };

        return array_map($callback, $this->items);
    }
}