<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Access);

/*
 * login model (config file)
 */

class Model_Login extends Model{


  public function __construct(){
  
  }

  //@override
  public function _default(){
    return array(
      'param'=>array(
      ),
    );
  }

  //@fun: check login message
  public function check(){
    return array(
      'param'=>array(
        'user'=>'',
        'pwd'=>'',
      ),
    );
  }

}

?>
