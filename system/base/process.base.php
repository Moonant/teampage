<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Load_Error);

/*
 * the main class
 */

class SYS_Process{

  private function __clone(){
  }

  //@fun: init system(system variable)
  public function initSysBaseInfo(){
    $variable = &loadSysClass('variables');
    $variable->initVariables();
  }

  //@fun: integrate user config message
  public function integrateInfo(){
    $integrate = &loadSysClass('integrate');
    $integrate->inteUserConfigInfo();
    $integrate->inteSysBaseInfo();
  }

  //@fun:
  public function initSysCoreInfo(){
    $this->initSession();
  }

  //@fun: init session
  private function initSession(){
    $session = &loadSysClass('session');
    $session->create();
    //$session->set('uid', 0);
  }

  //@fun:
  public function parseUrlInfo(){
    $url = &loadSysClass('url');
    $url->initQueryString();
    $url->parseQueryParam();
    //var_dump($url->getOriginalUrl());
  }

  //@fun:
  public function initExecModule(){
    $module = &loadSysClass('module');
    $module->definePlugin();
    $module->importModule();
    $module->defineFunction();
    $module->setFunctionParams();
    /*var_dump($module->getPlugin());
    var_dump($module->getFunction());
    var_dump($module->getFunctionParams());
    var_dump($module->getModuleDir());
    var_dump($module->getModuleFile());
    */
  }

  //
  public function execute(){
    $execute = &loadSysClass('execute');
    $execute->outputHtml();
  }

}

?>
