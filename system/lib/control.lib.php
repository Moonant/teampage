<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Load_Error);

/*
  control class
*/

class Control{

  public function getReTemplatePath($template){
    $module = &loadSysClass('module');
    $plugin = $module->getPlugin();
    return C_Dir_Current.'plugin'.C_Sep.$plugin.C_Sep.'template'.C_Sep.$template.C_Sep;
  }

  public function getJsStylePath(){
    $config = explode(C_Sep,rtrim(getConfig('dir', 'style'), C_Sep));
    return C_Dir_Current.$config[count($config) - 1].C_Sep;
  }
}

?>