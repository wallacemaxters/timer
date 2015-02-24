<?php

class Diff implements DiffInterface
{
	protected $time;

	public function __construct($time)
	{
		$this->setTime($time);
	}

	public function diff(Time $time)
	{
		$comparison = $this->time->getSeconds() - $time->getSeconds();

		if ($comparison < 0) {
			$comparison *= -1;
		}

		return (new Time())->setSeconds($comparison);
	}
    
    public function setTime(Time $time)
    {
        $this->time = $time;
        
        return $this;
    }
}