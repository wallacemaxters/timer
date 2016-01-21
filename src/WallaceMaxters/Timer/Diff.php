<?php

namespace WallaceMaxters\Timer;

/**
 * @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
*/

class Diff implements DiffInterface
{
    /**
    * @var \WallaceMaxters\Timer\Time
    */
    protected $time;

    public function __construct($time = null)
    {
        if ($time !== null) {

            $this->setTime($time);
        }
    }


    /**
    * Returns diff of times in new instance of Time
    * @param WallaceMaxters\Timer\Time $time
    * @return WallaceMaxters\Timer\Time
    */

    public function diff(Time $time)
    {
        $comparison = $this->time->getSeconds() - $time->getSeconds();

        // normalize number for a positive value

        if ($comparison < 0) {
            $comparison *= -1;
        }

        return (new Time())->setSeconds($comparison);
    }

    /**
    * Determine first object of WallaceMaxters\Timer\Time for comparision
    * @param \WallaceMaxters\Timer\Time $time
    * @return \WallaceMaxters\Timer\Diff
    */
    
    public function setTime(Time $time)
    {
        $this->time = $time;
        
        return $this;
    }
}