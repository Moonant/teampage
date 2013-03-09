<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Load_Error);

/*
  user class
*/

class SYS_User{

  const visitorStatus = 0;
  private $sys_userId = self::visitorStatus;
  private $sys_username = '';
  private $auth_member = 'Auth_member';

  public function __construct(){
    $this->setUserStatus();
  }

  public function __clone(){}

  private function setUserStatus(){
    $session = &loadSysClass('session');
    $sid = $session->get('uid');
    if($sid === false){
      $session->set('uid', self::visitorStatus);
      $this->setUserId(self::visitorStatus);
    }else
      $this->setUserId($sid);
  }

  public function setUserId($id){
    $this->sys_userId = $GLOBALS['FW']['Main']['Id'] = $id;
  }
  public function getUserId(){
    return $this->sys_userId;
  }

  public function getUserStatus(){
    if($this->sys_userId == self::visitorStatus && $this->getUserId() == self::visitorStatus)
      return false;
    else
      return true;
  }
  public function isLoginIn(){
    return $this->getUserStatus();
  }

  public function isRegister(){
    $db = &loadSysClass('db');
    $db->setDatabase();
    $result = $db->select($this->auth_member, '*', "`uid`='". $this->sys_userId . "'");
    if($result === false)
      return false;
    else
      return true;
  }
}

?>