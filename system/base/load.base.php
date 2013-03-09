<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Access);

/*
 * load class
 */

class Load{

  private static $Classes = array();
  private static $ClassExp = '{^[a-zA-Z_]{1,}$}';
  private static $ClassErr = ' class not exists!';

  private function __construct(){
    
  }

  private function __clone(){
    
  }

  //@fun: get class
  public static function getClass($class){
    if(!self::_is_class($class))
      die($class.self::$ClassErr);
    $class = ucfirst(strtolower($class));
    if(!self::_is_load($class))
      self::_insert_classes($class);
    return $class;
  }

  //@fun: is class
  private static function _is_class($class){
    if(preg_match(self::$ClassExp, $class))
      if(class_exists($class))
        return true;
    return false;
  }

  //@fun: is load
  private static function _is_load($class){
    return in_array($class, self::$Classes);
  }

  //@fun: insert class
  private static function _insert_classes($class){
    array_push(self::$Classes, $class);
  }

  //@fun: return $Classes
  public static function getClassAll(){
    return self::$Classes;
  }
}

?>
