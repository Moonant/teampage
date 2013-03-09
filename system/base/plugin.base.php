<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Load_Error);

/*
 * plugin class
 */

class SYS_Plugin{

  private $pluginArr = array(); /* plugin module */
  private $plugin = ''; /* current plugin */
  private $queryString = array(); /* string query */
  private $queryStringKey = array(); /* string query keys */
  private $exp_plugin = '{^[a-zA-Z_]+$}';

  public function __construct(){
    $this->setRequest();
    $this->setPluginArr();
    $this->plugin = $this->queryString[$this->queryStringKey[1]];
  }

  private function __clone(){}

  /* plugin */
  public function getPlugin(){
    return $this->plugin;
  }

  /* query string */
  public function getQueryString(){
    return $this->queryString;
  }

  /* request */
  private function setRequest(){
    $url = &loadSysClass('url');
    $this->queryString= $url->getQueryString();
    $this->queryStringKey = $url->getQueryStringKey();
  }

  /* plugin array */
  public function getPluginArr(){
    return $this->pluginArr;
  }

  private function setPluginArr(){
    $pluginDir = getConfig('dir', 'plugin');
    if($pluginDir === false)
      exit('Unable to closed to $config[dir][plugin]');
    if(!is_dir($pluginDir))
      die('Please do not delete or modify the plugin dir!');

    $_handle = dir($pluginDir);
    if($_handle){
      while($_file = $_handle->read()){
        if($_file != '.' && $_file != '..')
          if($this->isPlugin($_file))
            array_push($this->pluginArr, $_file);
      }
    }
  }

  //@fun: check is exist
  private function isPlugin($plugin){
    return preg_match($this->exp_plugin, $plugin);
  }

  public function inAllPlugin($plugin){
    return in_array($plugin, $this->pluginArr);
  }


  //@fun: determine current access plugin
  public function definePlugin(){
    $user = &loadSysClass('user');
    $uid = $user->isLoginIn();
    $isRegister = $user->isRegister();
    $register = getConfig('module', 'register');
    $homepage = getConfig('module', 'homepage');

    if($uid === false) //no login
      $this->plugin = getConfig('module', 'login');
    elseif($isRegister === false)
        $this->plugin = $register;
    if( ! $this->inAllPlugin($this->plugin) ){
      if($isRegister === false)
        exit("Please do not delete plugin: ".$this->plugin);
      else
        $this->plugin = $homepage;
    }else{
      if($isRegister === true && $this->plugin == $register){
        $this->plugin = $homepage;
        foreach($this->queryStringKey as $key=>$value)
          $this->queryString[$value] = ( $key == 1) ? $homepage : ($key == 0 ? $this->queryString[$value] : '');
      }
    }
    $this->queryString[$this->queryStringKey[1]] = $this->plugin;
  }
}

?>
