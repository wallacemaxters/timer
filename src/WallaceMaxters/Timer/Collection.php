<?php

namespace WallaceMaxters\Timer;

use IteratorAggregate;
use ArrayAccess;
use ArrayIterator;
use Countable;

/**
 * @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
 * */

class Collection implements Countable, IteratorAggregate
{

    /**
     * @var \SplObjectStorage
     * */
    protected $items;

    /**
     * @var string
     * */

    protected $format;
    
    /**
    * @param array $times = array of seconds or Wallacemaxters\Timer\Time instance
    * @param string $format = Default format for all items of collection
    */

    public function __construct(array $times = [], $format = Time::DEFAULT_FORMAT)
    {
        $this->format = $format;

        $this->items = new \SplObjectStorage;

        $this->mergeArray($times);
        
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

    /**
     * @deprecated since 1.5 use self::mergeArray insteadOf
     * @todo remover na versão 1.6
     * */
    public function fromArray(array $times)
    {
        return $this->mergeArray(array $times);
    }

    /**
     * Merges the current collection with array
     * @param array $times
     * */
    public function mergeArray(array $times)
    {

        foreach ($times as $key => $time) {

            if (! $time instanceof Time) {

                $time = new Time(0, 0, (int) $time);

            }

            $this->attach($time);
        }

        return $this;
    }

    /**
     * Clear the collection and fill with new itens
     * @param array $times
     * @return $this
     * */

    public function exchangeArray(array $times)
    {
        return $this->clear()->mergeArray($times);
    }

    /**
     * Merge the collection with another collection
     * 
     * @param \WallaceMaxters\Timer\Collection $collection
     * @return $this
     * */
    public function merge(self $collection)
    {
        foreach ($collection as $time) {

            $this->attach($time);
        }

        return $this;
    }

    /**
     * Get a cloned instance of internal SplObjectStorage
     * 
     * */

    public function getIterator()
    {
        return clone $this->items;
    }

    /**
     * Sorts the collection by ascending direction
     * @return $this 
     * */

    public function sortAsc()
    {    
        $this->sort(function ($a, $b)
        {
            return $a->getSeconds() - $b->getSeconds();
        });

        return $this;
    }

    /**
     * Attaches a time object to collection 
     * 
     * @param \WallaceMaxters\Timer\Time $time
     * @return $This
     * */

    public function attach(Time $time)
    {
        $this->items->attach($time, $time->getSeconds());

        return $this;
    }

    /**
     * Detaches a time of collection
     * @param \WallaceMaxters\Timer\Collection $collection
     * @return $this
     * */
    public function detach(Time $time)
    {
        $this->items->detach($time);

        return $this;
    }

    /**
    * @param \WallaceMaxters\Timer\Collection $collection
    * @return boolean
    * */

    public function contains(Time $time)
    {
        return $this->items->contains($time);
    }

    /**
     * Sorts the collection by callback
     * @param callable $callback
     * @return $this
     * */
    public function sort(callable $callback)
    {
        $array = $this->toArray();

        usort($array, $callback);

        $this->clear()->fromArray($array);

        return $this;
    }

    /**
     * Sorts a collection by descending order
     * 
     * @return $this
     * */
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
    * Filter all items by callback. 
    * @param callable $callback
    * @param boolean $true = determine if filtering will be with "true" or "false" returned by callback
    * @return $this
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
     * Filter that returns element when is not rejected by callback
     * @param callable $callback
     * */
    public function reject(callable $callback)
    {
        return $this->filter($callback, false);
    }

    /**
     * Converts the collection to array of seconds
     * @return array
     * */
    public function toArrayOfSeconds()
    {
        return array_map(function ($time) {

            return $time->getSeconds();

        }, $this->toArray());
    }

    /**
     * Converts the collection to array
     * @return array
     * */
    public function toArray()
    {
        return iterator_to_array($this->items);
    }

    /**
     * Gives a empty collection 
     * @return this
     * */
    public function clear()
    {
        $this->items->removeAll($this->items);

        return $this;
    }

    /**
     * Implementation of Countable. Returns the number of items in collection
     * @return int
     * */
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

    /**
     * Is empty?
     * @return boolean
     * */
    public function isEmpty()
    {
        return $this->count() == 0;
    }

    /**
     * Returns the major time
     * @return \WallaceMaxters\Timer\Time
     * */
    public function max()
    {
        return new Time(0, 0, max($this->toArrayOfSeconds()));
    }

    /**
     * Return the minor time
     * @return \WallaceMaxters\Timer\Time
    **/
    public function min()
    {
        return new Time(0, 0, min($this->toArrayOfSeconds()));
    }

    /**
     * @deprecated since 1.5
     * */

    public function avg()
    {
        trigger_error(sprintf('Method %s is deprectated. Use Collection::average instead of', __METHOD__));

        return $this->average();
    }

    /**
     * Returns the averaged time of the collection
     * @return Time;
     * */
    public function average()
    {
        $average = floor($this->sum()->getSeconds() / $this->count());

        return new Time(0, 0, $avg);
    }
   
}