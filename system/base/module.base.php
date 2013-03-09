<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Load_Error);

/*
  model class
*/

class SYS_Module{

  private $plugin = ''; /* plugin */
  private $function = ''; /* plugin function */
  private $functionParams = array();
  private $queryString = array();
  private $queryStringKey = array();
  private $basicModuleArr = array();  /* base module array*/
  private $moduleFile = array();
  private $moduleFileKey = array();
  private $moduleDir = ''; /* module directory */

  const defaultFunction = '_default';

  public function __construct(){
    configItemInfo('module');
    configItemInfo('mode');
    $this->setBasicModuleArr();
    $this->setModuleFileKey();
  }

  private function __clone(){}

  /* query string */
  public function getQueryString(){
    return $this->queryString;
  }

  /* query striing keys */
  public function getQueryStringKey(){
    return $this->queryStringKey;
  }

  /* plugin */
  public function getPlugin(){
    return $this->plugin;
  }

  /* module file key */
  public function getModuleFileKey(){
    return $this->moduleFileKey;
  }

  private function setModuleFileKey(){
    $mode = getConfig('mode');
    if($mode === false)
      exit("Please do not delete file : mode.config.php");
    $this->moduleFileKey = $mode;
  }

  /* basic module */
  private function setBasicModuleArr(){
    $module = getConfig('module');
    if($module === false)
      exit("Please do not delete file : module.config.php");
    $this->basicModuleArr = $module;
  }

  public function getBasicModuleArr(){
    return $this->basicModuleArr;
  }
  /* end of basic module */

  //@fun: define plugin
  public function definePlugin(){
    $plugin = &loadSysClass('plugin');
    $url = &loadSysClass('url');
    $plugin->definePlugin();
    $this->queryString = $plugin->getQueryString();
    $this->queryStringKey = $url->getQueryStringKey();
    $this->plugin = strtolower(trim($plugin->getPlugin()));
  }

  //@fun: import module
  public function importModule(){
    $this->importDependFile();
    $this->importCoreFile();
  }
  private function importDependFile(){ //import class
    foreach($this->moduleFileKey as $key=>$value){
      if($key == 'template') continue;
      $file = C_Sys_Dir_Lib.$value.'.lib'.C_File_EXT;
      if(!is_file($file))
        exit("Unable to be closed to the file : ".$file);
      include_once($file);
    }
  }
  private function importCoreFile(){
    $this->setModuleDir();

    foreach($this->moduleFileKey as $key=>$value){
      if($key == 'template') continue;
      $_file = $this->moduleDir.$this->plugin.'.'.$value.C_File_EXT;
      if(!is_file($_file))
        exit("Unable to closed to the file :" .$_file);
      include_once($_file);
      $this->moduleFile[$key] = $_file;
    }
    $_dir = $this->moduleDir.$this->moduleFileKey['template'].C_Sep;
    if(!is_dir($_dir))
      exit("Unable to closed to the dir : ". $_dir);
    $this->moduleFile['template'] = $_dir;
  }

  /* module file */
  public function getModuleFile(){
    return $this->moduleFile;
  }

  /* plugin diretory */
  public function getModuleDir(){
    return $this->moduleDir;
  }

  private function setModuleDir(){
    $_dir = getConfig('dir', 'plugin').$this->plugin.C_Sep;
    if(!is_dir($_dir))
      exit("Unable to closed to the dir: ".$_dir);
    $this->moduleDir = $_dir;
  }

  //@fun:
  public function defineFunction(){
    $plugin = 'Model_'.ucfirst($this->plugin);
    $plugin_model = new $plugin();

    $this->function = $this->queryString[$this->queryStringKey[2]];
    if($this->function == '' || !method_exists($plugin_model, $this->function)){
      $this->function = self::defaultFunction;
      if(!method_exists($plugin_model, $this->function))
        exit("Unable to find the function :_default in ".$this->pluginDir.$this->plugin.'.model'.C_File_EXT);
    }

    $this->queryString[$this->queryStringKey[2]] = $this->function;
    if($this->function == self::defaultFunction)
      $this->queryString[$this->queryStringKey[3]] = '';
  }

  /* function */
  public function getFunction(){
    return $this->function;
  }

  /* function params */
  public function getFunctionParams(){
    return $this->functionParams;
  }

  public function setFunctionParams(){
    $pluginModel = 'Model_'.ucfirst($this->plugin);
    $plugin = new $pluginModel();
    $result = call_user_func(array($plugin, $this->function), array());
    $result = $result['param'];
    $final = array();

    $request = $this->queryString[$this->queryStringKey[3]];
    foreach($result as $key=>$value){
      if(isset($request[$key]))
        $temp = $request[$key];
      else
        $temp = $value;
      $final[$key] = $temp;
    }
    $this->functionParams = $final;
  }

}

?>