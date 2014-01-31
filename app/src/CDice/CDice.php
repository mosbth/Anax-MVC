<?php
/**
 * A CDice class to play around with a dice.
 *
 */
class CDice {

  /**
   * Properties
   *
   */
  private $lastRoll = array();



  /**
   * Constructor
   *
   */
  public function __construct() {
    ;
  }



  /**
   * Roll the dice
   *
   */
  public function Roll($times) {
    $this->lastRoll = array();
    for($i = 0; $i < $times; $i++) {
      $this->lastRoll[] = rand(1, 6);
    }
  }



  /**
   * Get the array that contains the last roll(s).
   *
   */
  public function GetResults() {
    return $this->lastRoll;
  }



  /**
   * Get the total from the last roll(s).
   *
   */
  public function GetTotal() {
    return array_sum($this->lastRoll);
  }

}
