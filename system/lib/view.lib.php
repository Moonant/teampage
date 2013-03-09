<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Load_Error);

/*
 * view extends class
 */

class View{

  public $api = null;
  private $execDir = '';
  private $dirError = 'Please set executive environment!';

  private function __clone(){}

  public function __construct(){
    $module = &loadSysClass('module');
    $plugin = $module->getPlugin();
    $control = 'Control_'.ucfirst(strtolower($plugin));
    $this->api = new $control();
  }

  //@fun: link htm
  public function loadHtml($html){
    $_html = $GLOBALS['FW']['Template']['Path'].trim($html).'.htm';
    if(is_file(C_File_Path_Main.$_html))
      require $_html;
    else
      exit("Unable to closed to the file : ".C_File_Path_Main.$_html);
  }

  //@fun: set execute environment
  public function setSpace($dir){
    $_dir = $this->api->getReTemplatePath(trim($dir));
    if(!is_dir(C_File_Path_Main.$_dir))
      exit("Unable to closed to dir : ".C_File_Path_Main.$_dir);
    $variables = &loadSysClass('variables');
    $variables->setVariables(array('template', 'path'), $_dir);
  }


  //@fun: set css
  public function setCss($css = array()){
    if(!is_array($css))
      $css = array($css);
    if(!count($css)) return;

    $variables = &loadSysClass('variables');
    $cssArr = array();
    $path = $variables->getVariables(array('template', 'path'));

    foreach($css as $value){
      $_file = $path.trim($value).'.css';
      if(!file_exists(C_File_Path_Main.substr($_file, 2)))
        exit("Unable to closed to the file : ".C_File_Path_Main.substr($_file, 2));
      array_push($cssArr, $_file);
    }
    $variables->pushVariables(array('template', 'css'), $cssArr);
  }

  //@fun: set JS
  public function setJs($js = array()){
    if(!is_array($js))
      $js = array($js);
    if(!count($js)) return;

    $variables = &loadSysClass('variables');
    $jsArr = array();
    $path = $variables->getVariables(array('template', 'path'));

    foreach($js as $value){
      $_file = $path.trim($value).'.js';
      if(!file_exists(C_File_Path_Main.substr($_file, 2)))
        exit("Unable to closed to the file : ".C_File_Path_Main.substr($_file, 2));
       array_push($jsArr, $_file);
    }
    $variables->pushVariables(array('template', 'js'), $jsArr);
  }

  //@fun: set head Js
  public function setHeadJs($js = array()){
    if(!is_array($js))
      $js = array($js);
    if(!count($js)) return;

    $result = array();
    $path = $this->api->getJsStylePath();

    foreach($js as $value){
      $_file = $path.$value.'.js';
      if(is_file(C_File_Path_Main.substr($_file, 2)))
        exit("Unable to closed to the file : ".C_File_Path_Main.substr($_file, 2));
      array_push($result, $_file);
    }
    $variables = &loadSysClass('variables');
    $variables->setVariables(array('template', 'headjs'), $result);
  }

}

?>
