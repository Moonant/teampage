<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Access);

/*
 * login control class
 */

class Control_Login extends Control{

  //@fun: check user message
  public function check($user, $pwd){
    $pwd = trim($pwd);
    if($pwd == '')
      return 0;
    $_db =  &loadSysClass('db');
    $_db->setDatabase('login');
    $_con = "`username`='".trim($user)."' and `passwordMD5`='".md5(trim($pwd))."'";
    $_result = $_db->select('Auth_member', 'id', $_con);
    if($_result ===  false && empty($_reuslt['id']))
      return false;
    $session = &loadSysClass('session');
    $session->set('Uid', $_result['id']);
    return true;
  }

}

?>
