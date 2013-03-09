<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Load_Error);

/*
 * login view class
 */

class View_Login extends View{

  //@fun: default method
  public function _default(){

    $this->setSpace('login');
    $this->setCss(array('login'));
    $this->setHeadJs(array('md5'));
    $this->setJs(array('login'));
    $this->loadHtml('login');
  }

  //@fun: check login message
  public function check($user, $pwd){
    echo $this->api->check($user, $pwd);
  }
}

?>
