<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Access);

/*
 * config bootstrap  class
 */
 
class Boot_Config extends FW_Boot{
  
  //@override
  public function _boot(){
    return array(
      //the entrance to other config file
      C_Sys_Boot_Key=>array(
        "dir",  //system file config
        "db",  //system db contants
      ),
    );
  }
}
?>
