<?php

namespace WallaceMaxters\Timer;

use PHPLegends\Collections\Collection as BaseCollection;

/**
 * @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
 * */

class Collection extends BaseCollection
{

    /**
     * @var string
     * */

    protected $format = Time::DEFAULT_FORMAT;
    
    /**
     * @{inheritdoc}
     * */
    public function setItems(array $items)
    {
        return parent::setItems(
            $this->castItemsToTime($items)
        );
    }

    /**
     * @{inheritdoc}
     * */
    public function add($time)
    {
        $time = $this->getAsTime($time);

        return parent::add($time);
    }

    /**
     * @param int|string $key
     * @param Time|int $time
     * */
    public function set($key, $time)
    {
        $time = $this->getAsTime($time);

        return parent::set($key, $time);
    }
    
    /**
     * @param array $items
     * @param false $recursive
     * @return $this
     * */
    public function merge(array $items, $recursive = false)
    {
        parent::merge($this->castItemsToTime($items), false);

        return $this;
    }

    /**
     * Attaches a time object to collection 
     * @param \WallaceMaxters\Timer\Time $time
     * @return  \Wallacemaxters\Timer\Collection
     * */

    public function attach(Time $time)
    {
        $time->setFormat($this->format);

        $this->add($time);

        return $this;
    }

    /**
     * Detaches a time of collection
     * @param \WallaceMaxters\Timer\Collection $collection
     * @return  \Wallacemaxters\Timer\Collection
     * */
    public function detach(Time $time)
    {
        $key = $this->search($time);

        if ($key !== false) {

            unset($this->items[$key]);
        }

        return $this;
    }

    /**
    * Create a new instance of WallaceMaxters\Timer\Time with all
    * seconds of items of colection objets summed
    * @return \Wallacemaxters\Timer\Collection
    */

    public function sum()
    {
        $seconds = $this->reduce(function ($result, Time $time)
        {
            return $result += $time->getSeconds();

        }, 0);

        return $this->createTime(0, 0, $seconds);
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
     * Returns the major time
     * @return \WallaceMaxters\Timer\Time
     * */
    public function max()
    {
        return $this->createTime(0, 0, max($this->toArrayOfSeconds()));
    }

    /**
     * Return the minor time
     * @return \WallaceMaxters\Timer\Time
    **/
    public function min()
    {
        return $this->createTime(0, 0, min($this->toArrayOfSeconds()));
    }

    /**
     * Returns the averaged time of the collection
     * @return Time
     * */
    public function average()
    {
        $average = floor($this->sum()->getSeconds() / $this->count());

        return $this->createTime(0, 0, $average);
    }

    /**
     * Defines the format used in all items of collection
     * @return \Wallacemaxters\Timer\Collection
     * */
    public function setFormat($format)
    {
        $this->format = (string) $format;

        foreach ($this->items as $time) {

            $time->setFormat($format);
        }

        return $this;
    }

    /**
     * Return the format
     * @return string
     * */
    public function getFormat()
    {
        return $this->format;
    }

    /**
    * Make a instance of Time with collection time format
    * @param int $hours
    * @param int $minutes
    * @param int $seconds
    * @return \WallaceMaxters\Timer\Time
    */
    protected function createTime($hours = 0, $minutes = 0, $seconds = 0)
    {
        return (new Time($hours, $minutes, $seconds))->setFormat($this->format);
    }

    protected function castItemsToTime(array $items)
    {
        return array_map([$this, 'getAsTime'], $items);
    }

    /**
     * @param Time|int $item
     * @return Time
     * */
    protected function getAsTime($time)
    {
        if (! $time instanceof Time) {

            $time = $this->createTime(0, 0, $time);
        }

        return $time;
    }
   
}