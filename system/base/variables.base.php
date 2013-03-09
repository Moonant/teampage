<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Load_Error);

/*
 * system variables
 */

class SYS_Variables{

  private $sys_errorSetVar = 'Unable to closed to $GLOBALS[FW]';
  private $aya_errorPushVar = 'Unable to closed to string $GLOBALS[FW]';

  private function __clone(){}

  public function __construct(){}

  //@fun: init variables
  public function initVariables(){
    $_globals = array();

    $_globals['User'] = array('Uid'=>'', 'Username'=>'');
    $_globals['Session'] = array();
    $_globals['Template'] = array('Path'=>'', 'Css'=>array(), 'Js'=>array(), 'Headjs'=>array());

    $GLOBALS['FW'] = $_globals;
  }

  //@fun: get all variables information
  public function getAllVariables(){
    return $GLOBALS['FW'];
  }

  //@fun: get variables
  public function getVariables($arrayName = array()){
    if(!is_array($arrayName))
      $arrayName = array($arrayName);
    if(!count($arrayName))
      return $this->getAllVariables();
    $tempArray = ucfirstFormat($arrayName[0]);
    switch(count($arrayName)){
    case 1 : {
      if(!isset($GLOBALS['FW'][$tempArray]))
        $result = false;
      else
        $result = $GLOBALS['FW'][$tempArray];
      break;
    }
    case 2 :{
      $secondArray = ucfirstFormat($arrayName[1]);
      if(!isset($GLOBALS['FW'][$tempArray][$secondArray]))
        $result = false;
      else
        $result = $GLOBALS['FW'][$tempArray][$secondArray];
      break;
    }
    default : break;
    }
    return $result;
  }

  //@fun: set variables
  public function setVariables($arrayName = array(), $value = ''){
    if(!is_array($arrayName))
      $arrayName = array($arrayName);
    $number = count($arrayName);
    if(!$number) return;
    $tempArray = ucfirstFormat($arrayName[0]);
    switch($number){
    case 1 :{
      if(!isset($GLOBALS['FW'][$tempArray]))
        exit($this->sys_errorSetVar.'['.$tempArray.']');
      $GLOBALS['FW'][$tempArray] = $value;
      break;
    }
    case 2 :{
      $secondArray = ucfirstFormat($arrayName[1]);
      if(!isset($GLOBALS['FW'][$tempArray][$secondArray]))
        exit($this->sys_errorSetVar.'['.$tempArray.']['.$secondArray.']');
      $GLOBALS['FW'][$tempArray][$secondArray] = $value;
      break;
    }
    default : break;
    }
  }

  //@fun:
  public function pushVariables($arrayName = array(), $value = array()){
    if(!is_array($value))
      $value = array($value);
    if(!count($value)) return;

    if(!is_array($arrayName))
      $arrayName = array($arrayName);
    $number = count($arrayName);
    if(!$number) return;

    $tempArray = ucfirstFormat($arrayName[0]);
    switch($number){
    case 1 :{
      if(!isset($GLOBALS['FW'][$tempArray]))
        exit($this->sys_errorSetVar.'['.$tempArray.']');
      if(!is_array($GLOBALS['FW'][$tempArray]))
        exit($this->sys_errorPushVar.'['.$tempArray.']');
      foreach($value as $v_value)
        array_push($GLOBALS['FW'][$tempArray], $v_value);
      break;
    }
    case 2 :{
      $secondArray = ucfirstFormat($arrayName[1]);
      if(!isset($GLOBALS['FW'][$tempArray][$secondArray]))
        exit($this->sys_errorInfo.'['.$tempArray.']['.$secondArray.']');
      if(!is_array($GLOBALS['FW'][$tempArray][$secondArray]))
        exit($this->sys_errorPushVar.'['.$tempArray.']['.$secondArray.']');
      foreach($value as $v_value)
        array_push($GLOBALS['FW'][$tempArray][$secondArray], $v_value);
      break;
    }
    default : break;
    }
  }

}

?>
