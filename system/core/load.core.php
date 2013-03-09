<?php

if(!defined('IS_ACTIVE')) die('C_Meg_Load_Error');

/*
  load function file
*/

//@fun: load class or registry class
function &loadSysClass($class = '', $directory = 'base', $prefix = 'SYS_'){
  static $_classArr = array();
  if(!func_num_args()) return $_classArr;

  $arguments = func_get_args();
  $class = strtolower( trim( (string)$arguments[0] ) );
  if(count($arguments) > 1)
    $directory = strtolower( trim( (string)$arguments[1] ) );
  else
    $directory = C_Class_BaseFolder;

  if(!strlen($class))
    exit("Unable to define the loading class name!");
  if(isset($_classArr[$class]))
    return $_classArr[$class];

  $_classMain = C_Class_Prefix.ucfirst($class);
  $_file = C_Sys_Path.$directory.C_Sep.$class._fileSuffix($directory);

  if(file_exists($_file))
    include_once $_file;
  else
    exit('Unable to locate the soecified class: '.$_file);
  $_classArr[$class] = new $_classMain();
  return $_classArr[$class];
}

function getAllLoadSysClass(){
  $class = loadSysClass();
  $result = array();

  foreach(array_keys($class) as $value)
    array_push($result, C_Class_Prefix.ucfirst($value) );
  return $result;
}
//@fun:
function _fileSuffix($directory){
  return '.'.$directory.C_File_EXT;
}

//@fun: load file
function loadSysFile($file, $directory = 'base'){
  $file = strtolower(trim($file));
  $directory = strtolower(trim($directory));
  $_file = C_Sys_Path.$directory.C_Sep.$file._fileSuffix($directory);
  _isLoadFile($_file);
}

//@fun: to determined whether the file is loaded
function _isLoadFile(){
  static $_fileArr = array();

  if(func_num_args() == 0)
    return $_fileArr;

  $file = func_get_args();
  $file = $file[0];

  if($file  == '')
    return $_fileArr;
  if(!file_exists($file))
    exit("Unable closed to file : ".$file);
  if(!in_array($file, $_fileArr)){
    array_push($_fileArr, $file);
    include_once $file;
  }
}

function getAllLoadSysFile(){
  return _isLoadFile();
}
/*
//@fun: load user file
function loadUserFile($file, $directory = 'config'){
  $file = strtolower(trim($file));
  $directory = strtolower(trim($directory));

  $_file = C_File_Path_Main.$directory.C_Sep.$file._fileSuffix($directory);
  //  echo $_file;
  _isLoadFile($_file);
}
*/

?>
