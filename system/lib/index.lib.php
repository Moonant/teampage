<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Access);

/*
 * the main class
 */

class FW{

  private function __construct(){
  }

  private function __clone(){
  }

  //@fun: init system(system variable, session)
  public static function initSystem(){
    self::_initSystemVar();
    self::_initSession();
    self::_integrateInfo();
  }

  //@fun: init session
  private static function _initSession(){
    $session = Session::getInstance();
    $session->create();
  }

  //@fun: init system variables
  private static function _initSystemVar(){
    $variable = Variables::getInstance();
    $variable->init();
  }

  //@fun: integrate system information
  private static function _integrateInfo(){
    $integrate = Integrate::getInstance();
    $integrate->inteInfo();
    $integrate->destoryInteInfo();
  }

  //@fun: init plugin
  public static function initPlugin(){
    $plugin = Plugin::getInstance();
    $plugin->definePlugin();
    $plugin->importPlugin();
  }

  //@fun: init function
  public static function initFunc(){
    if(empty($GLOBALS['FW']['Each']['Main']['Function']))
      $_fun = C_Sys_Model_Default;
    else{
      $_plugin = $GLOBALS['FW']['Each']['Main']['Plugin'];
      $_fun = $GLOBALS['FW']['Each']['Main']['Function'];
      $_plugin = ucfirst(strtolower($_plugin));
      $_model = 'Model_'.$_plugin;
      $_modelObj = new $_model;
      if(!method_exists($_modelObj, $_fun))
        $_fun = C_Sys_Model_Default;
    }
    $GLOBALS['FW']['Each']['Main']['Function'] = $_fun;
  }

  //@fun: execute function output html
  public static function execute(){
    $_execute = Execute::getInstance();
    $_execute->initSetting();
    $_execute->checkParam();
    $_execute->outputHtml();
  }
}

?>
