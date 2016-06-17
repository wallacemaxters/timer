<?php

namespace WallaceMaxters\Timer;

/**
 * Parser for create Time instancef from format
 * 
 * @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
*/

class Parser
{

    /**
    * @param string $format
    * @param string $value
    * @return \WallaceMaxters\Timer\Time
    */

    public function fromFormat($format, $value)
    {
        $matches = $this->getMatches($format, $value);

        return new Time($matches['h'], $matches['i'], $matches['s']);
    }

    /**
    * @throws \InvalidArgumentException
    * @return array
    */
    protected function getReplacements()
    {
        return [
            Time::HOUR_FORMAT   => '(?<h>\d+)',
            Time::MINUTE_FORMAT => '(?<i>[0-5][0-9])',
            Time::SECOND_FORMAT => '(?<s>[0-5][0-9])',
        ];
    }


    /**
    * Get regex from format passed
    * @access protected
    * @param $format
    * @return string
    */
    protected function getRegex($format)
    {
        $regex = strtr($format, $this->getReplacements());

        return sprintf('/^%s$/', $regex);
    }

    /**
    * @param $format
    * @param $value
    * @return array
    */
    public function getMatches($format, $value)
    {
        if (! preg_match($regex = $this->getRegex($format), $value, $matches))
        {
            throw new \InvalidArgumentException(sprintf(
                'Invalid string format for "%s"',
                $value
            ));
        }

        $defaults = [
            'h' => 0,
            'i' => 0, 
            's' => 0,
        ];                                                                        

        $matches = array_intersect_key($matches, $defaults);

        return $matches + $defaults;
    }

    /**
     * @param string $format
     * @param string $value
     * @return boolean
     * */
    public function isValidFormat($format, $value)
    {
        return (boolean) preg_match($this->getRegex($format), $value);
    }


}