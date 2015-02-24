<?php

namespace WallaceMaxters\Timer;

class Diff implements DiffInterface
{
	protected $time;

	public function __construct($time = null)
	{
		if ($time !== null) {

			$this->setTime($time);
		}
	}


	/**
	* @param WallaceMaxters\Timer\Time $time = Time for comparision
	* @return WallaceMaxters\Timer\Time new object with secondos of comparision result
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
	*/
    
    public function setTime(Time $time)
    {
        $this->time = $time;
        
        return $this;
    }
}