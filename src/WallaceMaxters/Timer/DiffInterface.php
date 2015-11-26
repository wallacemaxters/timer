<?php

namespace WallaceMaxters\Timer;

interface DiffInterface
{
	/**
	 * @param \WallaceMaxters\Timer\Time $time
	 * @return \WallaceMaxters\Timer\Time
	 * */
    public function diff(Time $time);

    /**
     * @param \WallaceMaxters\Timer\Time $time
     * */
    public function setTime(Time $time);
}