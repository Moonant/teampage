<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Load_Error);

/*
 * integrate class
 */

class SYS_Integrate{

  public function __construct(){
  }

  private function __clone(){}

  //@fun: integrate user config information
  public function inteUserConfigInfo(){
    configItemInfo('dir');
    configItemInfo('file');
  }

  //$fun
  public function inteSysBaseInfo(){
    $this->integrateUserDir();
    $this->integrateStyle();
    //$this->integrateRequest();
    $this->integrateUserInfo();
  }

  //@fun: integrate user directory
  public function integrateUserDir(){
    $dir = getConfig('dir');
    $result = array();
    if($dir === false)
      exit("Unable to closed to dir.config.php");
    foreach($dir as $key=>$value)
      $result[$key] = C_File_Path_Main.$value.C_Sep;
    setConfig('dir', $result);
  }

  //@fun: integrate user message
  private function integrateUserInfo(){
    $variables = &loadSysClass('variables');
    $session = &loadSysClass('session');
    $uid = $session->get('uid');
    $uid = ($uid === false ? 0 : $uid);
    $variables->setVariables(array('user', 'uid'), $uid);
    if(($username = $session->get('username')) !== false)
      $variables->setVariables(array('user', 'username'), $username);
  }

  //@fun: integrate css/js
  private function integrateStyle(){
    $css = getConfig('file', array('style', 'css'));
    $js = getConfig('file', array('style', 'javascript'));
    $cssArr = array();
    $jsArr = array();
    $_styleDir = explode(C_Sep, rtrim(getConfig('dir', 'style'), C_Sep));
    $_styleDir = C_Dir_Current.$_styleDir[count($_styleDir) - 1].C_Sep;
    foreach($css as $value)
      array_push($cssArr, $_styleDir.'css'.C_Sep.$value);
    foreach($js as $value)
      array_push($jsArr, $_styleDir.'js'.C_Sep.$value);

    setConfig('file', array('style', 'css'), $cssArr);
    setConfig('file', array('style', 'javascript'), $jsArr);
  }

  //@fun: destory integrate information
  public function destoryInteInfo(){
    unset($_GET);
    unset($_POST);
  }



}

?>
