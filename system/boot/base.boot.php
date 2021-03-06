<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Access);

/*
 * base bootstrap  class
 */

class Boot_Base extends FW_Boot{

 
  //@override
  public function _boot(){
    return array(
      //the entrance to other config file
      C_Sys_Boot_Key=>array(
        "cache",  //cache class
        "db",  //db class
        "language", //language class
        "session",  //session class
        "load",  //load class
        "variables",//variables class
        "integrate",//integrate class
        "url",  //url class
	"code",  //code class
	"plugin",  //plugin class
	"execute",  //execute class
	"modelverify",  //modelverify class
	"view",  //view php
      ),
    );
  }

}

?>
