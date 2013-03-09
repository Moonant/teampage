<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Access);

/*
 * singleton pattern extends abstract class
 */

abstract class FW_Singleton{


  //@fun: singleton pattern function
  abstract public static function getInstance();

}

?>
