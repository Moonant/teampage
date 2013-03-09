<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Access);

/*
 * login view class
 */

class View_Register extends View{

  //@fun: default method
  public function _default(){

    $this->setSpace('first');
    $this->setCss('page');
    $this->setJs('page');
    $this->loadHtml('first');
  }

  public function re_two(){
    $this->setSpace('second');
    $this->setCss('page');
    $this->setJs('page');
    $this->loadHtml('second');
  }

}

?>
