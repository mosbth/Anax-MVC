<?php

namespace Mos\Dice;

/**
 * A CDice class to play around with a dice.
 *
 */
class CDice
{

    /**
    * Properties
    *
    */
    private $lastRoll = [];



    /**
     * Roll the dice
     *
     * @param int $times the number of times to roll.
     * 
     * @return void
     */
    public function roll($times) 
    {
        $this->lastRoll = array();
        for ($i = 0; $i < $times; $i++) {
              $this->lastRoll[] = rand(1, 6);
        }
    }



    /**
     * Get number of rolls in last roll
     *
     * @return int
     */
    public function getNumOfRolls() 
    {
        return count($this->lastRoll);
    }



    /**
     * Get the array that contains the last roll(s).
     *
     * @return void
     */
    public function getResults() 
    {
        return $this->lastRoll;
    }



    /**
     * Get the total from the last roll(s).
     *
     * @return void
     */
    public function getTotal() 
    {
        return array_sum($this->lastRoll);
    }
}
