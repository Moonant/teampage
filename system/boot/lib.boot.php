<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Access);

/*
 * lib bootstrap  class
 */
 
class Boot_Lib extends FW_Boot{
  
  //@override
  public function _boot(){
    return array(
      //the entrance to other config file
      C_Sys_Boot_Key=>array(
        "index",  //index class
        "singleton",  //singleton class
	"model",  //model class
      ),
    );
  }
}


?>
