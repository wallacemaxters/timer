<?php

namespace WallaceMaxters\Timer;

use ArrayAcess
use IteratorAggregate;

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
            
            $this[$key] = new Time(0, 0, $time);
        }
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

}