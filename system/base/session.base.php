<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Load_Error);

/*
 * session class
 */

/*
  dependent class
*/
//loadSysFile();

/*
  session class
*/
class SYS_Session{

  private $s_id;
  private $s_save_time;
  private $s_exp_id = '{^[a-zA-Z0-9]+$}';
  private $sys_errorInfo = 'Unable to closed to $_SESSION';

  public function __construct(){
    configItemInfo('session');
  }

  private function __clone(){}

  //@fun: create session
  public function create(){
    $variable = &loadSysClass('variables');
    $_phpsid = $this->getSessionName();
    if(empty($_COOKIE[$_phpsid]) || $this->checkSessionId($_COOKIE[$_phpsid]) === false){
      $_cong_sid = $variable->getVariables('session');
      if(isset($_cong_sid['Uid']) && $this->checkSessionId($_cong_sid['Uid']))
        session_id($_cong_sid['Uid']);
      else
        session_id(md5(uniqid()));
      $this->setCookie();
    }
    session_start();//启动缓存
  }

  //@fun: set cookie
  private function setCookie(){
    $time = time() + getConfig('session', 'saveTime');
    setCookie($this->getSessionName(), $this->getSessionId(), $time);
  }

  //@fun: get session variables
  public function get($name = array()){
    if(!is_array($name))
      $name = array($name);
    $number = count($name);
    if(!$number) return $_SESSION;
    $tempName = ucfirstFormat($name[0]);
    $result = '';
    switch($number){
    case 1 : {
      if(!isset($_SESSION[$tempName]))
        return false;
      $result = $_SESSION[$tempName];
      break;
    }
    case 2 : {
      $secondName = ucfirstFormat($name[1]);
      if(!isset($_SESSION[$tempName][$secondName]))
        exit($this->sys_errorInfo.'['.$tempName.']['.$secondName.']');
      $result = $_SESSION[$tempName][$secondName];
      break;
    }
    default : break;
    }
    return $result;
  }

  //@fun: set session
  public function set($name, $value = ''){
    if(!is_array($name))
      $name = array($name);
    $number = count($name);
    if(!$number) return false;
    $tempName = ucfirstFormat($name[0]);
    switch($number){
    case 1 : {
      $_SESSION[$tempName] = $value;
      break;
    }
    case 2 : {
      if(!isset($_SESSION[$tempName]))
        exit($this->sys_errorInfo.'['.$tempName.']');
      $_SESSION[$tempName][ucfirstFormat($name[2])] = $value;
      break;
    }
    default : break;
    }
  }

  //@fun: check session id
  private function checkSessionId($sessionId){
    return preg_match($this->s_exp_id, $sessionId);
  }

  //@fun: return session Id
  public function getSessionId(){
    return session_id();
  }

  //@fun: return session name
  public function getSessionName(){
    return session_name();
  }


}

?>
