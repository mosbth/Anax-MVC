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
    * Constructor
    *
    */
    public function __construct() 
    {
        ;
    }



    /**
    * Roll the dice
    *
    */
    public function roll($times) 
    {
        $this->lastRoll = array();
        for($i = 0; $i < $times; $i++) {
              $this->lastRoll[] = rand(1, 6);
        }
    }



    /**
    * Get the array that contains the last roll(s).
    *
    */
    public function getResults() 
    {
        return $this->lastRoll;
    }



    /**
    * Get the total from the last roll(s).
    *
    */
    public function getTotal() 
    {
        return array_sum($this->lastRoll);
    }
}
