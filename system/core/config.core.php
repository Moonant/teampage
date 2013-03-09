<?php

if(!defined('IS_ACTIVE')) exit(C_Meg_Load_Error);

/*
  config function file
*/

//@fun: initialize config information
function configItemInfo($file = ''){
  $file = strtolower(trim($file));
  $_file = C_File_Path_Main.'config'.C_Sep.$file.'.config.php';

  if( !file_exists($_file) )
    exit("Unable to closed to this file : ".$_file);
  if( _isConfig($file) )
    return;

  include_once $_file;
  if(!isset($config))
    exit("Unable to set variables : $config");
  _allConfig($file, $config);
}

//@fun
function _isConfig($file){
  static $_isConfigArr = array();

  if(isset($_isConfigArr[$file]))
    return true;
  else
    $_isConfigArr[$file] = true;
  return false;
}
//@fun: set all config
function &_allConfig($model = '', $config = array()){
  static $_configArr = array();

  $config = is_array($config) ? $config : array();
  if(count($config) != 0)
    $_configArr[trim($model)] = $config;

  return $_configArr;
}

//@fun: set config infomation($model, $key, $value),($model, $value)
function setConfig(){
  if(($config = &_allConfig()) === false)
    return;

  $number = func_num_args();
  if($number < 2) return;
  $argument = func_get_args();
  $model = trim($argument[0]);

  if(!isset($config[$model])) return;
  if($number == 2){
    if(!is_array($argument[1])) return;
    else
      $config[$model] = $argument[1];
  }else{
    if(!is_array($key = $argument[1]))
      $key = array($argument[1]);
    $value = $argument[2];
    $firstKey = trim($key[0]);
    switch(count($key)){
    case 1 :{
      if(!isset($config[$model][$firstKey])) return;
      else
        $config[$model][$firstKey] = (is_array($value))? $value : trim($value);
      break;
    }
    case 2 :{
      $secondKey = trim($key[1]);
      if(!isset($config[$model][$firstKey][$secondKey])) return;
      else
        $config[$model][$key[0]][$secondKey] = (is_array($value)) ? $value : trim($vlaue);
      break;
    }
    default : break;
    }
  }
}

//@fun: get
function getConfig($model, $key = ''){
  if( ($config = _allConfig()) === false) return;
  if(empty($model)) return $config;
  if(!isset($config[$model])) return false;

  $_config = $config[$model];
  if($key == '')
    return $_config;
  if(is_array($key) && ($length = count($key)) != 0){
    if($length == 1)
      return isset($_config[$key[0]]) ? $_config[$key[0]] : false;
    else
      return isset($_config[$key[0]][$key[1]]) ? $_config[$key[0]][$key[1]] : false;
  }else
    return isset($_config[$key]) ? $_config[$key] : false;

}

?>
