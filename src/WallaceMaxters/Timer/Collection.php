<?php

namespace WallaceMaxters\Timer;

use IteratorAggregate;
use ArrayAccess;
use ArrayIterator;
use Countable;

class Collection implements Countable, IteratorAggregate
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

        $this->items = new \SplObjectStorage;

        $this->fromArray($times);
        
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

    public function fromArray(array $times)
    {
        foreach ($times as $key => $time) {

            if (! $time instanceof Time) {

                $time = new Time(0, 0, $time);

            }

            $this->attach($time);
        }
        return $this;
    }

    public function merge(self $collection)
    {
        foreach ($collection as $time) {

            $this->attach($time);
        }

        return $this;
    }

    public function getIterator()
    {
        return clone $this->items;
    }

    public function sortAsc()
    {    
        $this->sort(function ($a, $b)
        {
            return $a->getSeconds() - $b->getSeconds();
        });

        return $this;
    }

    public function attach(Time $time)
    {
        $this->items->attach($time, $time->getSeconds());

        return $this;
    }

    public function detach(Time $time)
    {
        $this->items->detach($time);

        return $this;
    }

    public function contains(Time $time)
    {
        return $this->items->contains($time);
    }

    public function sort(callable $callback)
    {
        $array = $this->toArray();

        usort($array, $callback);

        $this->clear()->fromArray($array);

        return $this;
    }

    public function sortDesc()
    {
        return $this->sort(function ($a, $b)
        {
            return $b->getSeconds() - $a->getSeconds();
        });
    }

    /**
    * Create a new instance of WallaceMaxters\Timer\Time with all
    *  seconds of items of colection objets summed
    * @return WallaceMaxters\Timer\Time
    */

    public function sum()
    {
        return new Time(0, 0, array_sum($this->toArrayOfSeconds()));
    }

    /**
    * Filter all items and create a new instance 
    */
    public function filter(callable $callback, $true = true)
    {
        foreach ($this->items as $time) {

            if ($callback($time) != $true) {

                $this->detach($time);
            }
        }

        return $this;
    }

    /**
     * Return element where is not rejected by callback
     * @param callable $callback
     * */
    public function reject(callable $callback)
    {
        return $this->filter($callback, false);
    }

    /**
     * @return array
     * */
    public function toArrayOfSeconds()
    {
        return array_map(function ($time) {

            return $time->getSeconds();

        }, $this->toArray());
    }

    public function toArray()
    {
        return iterator_to_array($this->items);
    }

    public function clear()
    {
        $this->items->removeAll($this->items);

        return $this;
    }

    public function count()
    {
        return $this->items->count();
    }
    
    /**
     * Search time object and return the first 
     * @param callable $callback
     * @return \WallaceMaxters\Timer\Time | null
     * */
    public function first(callable $callback)
    {
        foreach ($this->items as $time) {

            if ($callback($time)) return $time;
        }
    }

    public function isEmpty()
    {
        return $this->count() == 0;
    }

    public function max()
    {
        return new Time(0, 0, max($this->toArrayOfSeconds()));
    }

    public function min()
    {
        return new Time(0, 0, min($this->toArrayOfSeconds()));
    }

    public function avg()
    {
        $avg = floor($this->sum()->getSeconds() / $this->count());

        return new Time(0, 0, $avg);
    }

    
}