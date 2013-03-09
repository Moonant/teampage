<?php

if(!defined('IS_ACTIVE')) exit(C_Meg_Access);

/*
 * deal with the boot file
 */

class Guider{

  //@fun: execute the fun
  public static function handle($arr, $model){
    if(self::check_model($model) === false) return;
    $_path = C_Sys_Path.C_Sep.$model;
    $_suffix = '.'.$model.'.php';
    foreach($arr['config'] as $_value){
      $_path .= C_Sep.$_value.$_suffix;
      self::detect_load($_path);
    }
  }

  //@fun: check file exists, load the file
  private static function detect_load($path){
    if(file_exists($path))
      include_once($path);
  }

  //@fun: check model
  private static function check_model($model){
    $_arr = explode("$", C_Sys_Dir_Content);
    return in_array($model, $_arr); 
  }

  //@fun: load other boot files
  public static function loadBootFiles(){
    if(!isset($GLOBALS['system']))
      die('Please do not delete or modify system config!');
    foreach($GLOBALS['system'] as $_model=>$_model_arr){
      foreach($_model_arr as $_key=>$_value){
        if($_key == 'boot')
          self::_load($_value, $_model);
        }
      }
  }

  //@fun: load file
  private static function _load($file, $model){
    if(!file_exists($file))
      die('Please do not delete or modify bootstrap file!');
    include_once $file;
    $model = strtolower($model);
    $_class = 'Boot_'.ucfirst($model);
    if(!class_exists($_class))
      die('Please do not delete or modify class '.$_class.'!');
    $_model = new $_class;
    $_content = $_model->_boot();
    $_content = $_content[C_Sys_Boot_Key];
    $_path = C_Sys_Path.C_Sep.$model;
    foreach($_content as $_value){
      $_file = $_path.C_Sep.$_value.'.'.$model.'.php';
      if(file_exists($_file))
        include_once $_file;
    }
  }
}

?>
