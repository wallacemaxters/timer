<?php

namespace WallaceMaxters\Timer;

interface DiffInterface
{
    public function diff(Time $time);
    public function setTime(Time $time);
}