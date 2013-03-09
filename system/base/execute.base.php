<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Load_Error);

/*
 * execute class
 */

class SYS_Execute{

  private $plugin = '';
  private $function = '';
  private $functionParams = array();

  private function __clone(){}

  public function __construct(){
    $module = &loadSysClass('module');
    $this->plugin = $module->getPlugin();
    $this->function = $module->getFunction();
    $this->functionParams = $module->getFunctionParams();
  }

  public function getExecuteInfo(){
    $result = 'Plugin : '.$this->plugin.' ; Function : '.$this->function.' ; ';
    $tempResult = '';
    if(!empty($this->functionParams))
      foreach($this->functionParams as $key=>$value)
        $tempResult .= '&'.$key.'='.$value;
    return $result.substr($tempResult, 1);
  }
  //@fun: output top
  private function displayFrontPage(){
    $_file = getConfig('dir', 'template').getConfig('file', array('page', 'front'));
    if(is_file($_file))
      require $_file;
    else
      echo "please do not delete or modify top.htm";
  }

  //@fun: output bottom
  private function displayRearPage(){
     $_file = getConfig('dir', 'template').getConfig('file', array('page', 'rear'));
    if(is_file($_file))
      require $_file;
    else
      echo "please do not delete or modify bottom.htm";
  }

  //@fun: output plugin
  private function exectePlugin(){
    $plugin = ucfirst($this->plugin);
    $plugin_view = 'View_'.$plugin;
    $view = new $plugin_view();
    if(!method_exists($view, $this->function))
      exit("Unable to closed to function ".$this->function." in class ".$plugin_view);
    call_user_func_array( array($view, $this->function), $this->functionParams );
  }

  //@fun: output  ajax page
  private function viewAjaxPage(){
    $this->exectePlugin();
  }

  //@fun: output html
  public function outputHtml(){
    if($this->isAjaxRequest() === false)
      $this->viewHtmlPage();
    else
      $this->viewAjaxPage();
  }
  private function isAjaxRequest(){
    $module = &loadSysClass('module');
    $request = $module->getQueryString();
    $requestKey = $module->getQueryStringKey();
    if(!strlen($request[$requestKey[0]]))
      return false;
    else
      return true;
  }
  //@fun: output not ajax page
  private function viewHtmlPage(){
    ob_start();
    $this->exectePlugin();
    $_body = ob_get_contents();
    ob_end_clean();
    ob_start();
    $this->displayFrontPage();
    $_top = ob_get_contents();
    ob_end_clean();
    ob_start();
    $this->displayRearPage();
    $_bottom = ob_get_contents();
    ob_end_clean();
    echo $_top.$_body.$_bottom;
    var_dump($this->getExecuteInfo());
    //var_dump(getAllLoadSysClass());
    //var_dump(getAllLoadSysFile());
    //var_dump($GLOBALS);
  }

}

?>
