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
     * s
     * */
    public function setTime(Time $time);
}