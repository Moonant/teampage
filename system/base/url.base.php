<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Load_Error);

/*
 * parse url class
 */

class SYS_Url{

  private $originalUrl = '';
  private $scriptName = '';
  private $finalUrl = '';
  private $queryString = array();
  private $queryStringKey = array();

  public function __construct(){
    configItemInfo('url');
    $this->setScriptName();
    $this->setOriginalUrl();
  }
  private function __clone(){}

  /* query string key */
  public function getQueryStringKey(){
    return $this->queryStringKey;
  }

  private function setQueryStringKey(){
    array_push($this->queryStringKey, getConfig('url', 'ajax'), getConfig('url', 'plugin'), getConfig('url', 'function'), getConfig('url', 'request'));
  }

  /* query string */
  public function getQueryString(){
    return $this->queryString;
  }

  private function setQueryString($query){
    $result = array();
    if(count($query) == 4 && $query[0] != $this->queryStringKey[0]){
      $query[2] = $query[2].$query[3];
      array_pop($query);
    }
    switch(count($query)){
    case 4:
      foreach($this->queryStringKey as $key=>$value)
        $this->queryString[$value] = $query[$key];
      break;
    case 3:
      if($query[0] == $this->queryStringKey[0])
        foreach($this->queryStringKey as $key=>$value)
          $this->queryString[$value] = ($key == 3) ? '' : $query[$key];
      else
        foreach($this->queryStringKey as $key=>$value)
          $this->queryString[$value] = ($key == 0) ? '' : $query[$key - 1];
      break;
    case 2:
      if($query[0] == $this->queryStringKey[0])
        foreach($this->queryStringKey as $key=>$value)
          $this->queryString[$value] = ($key <= 1) ? $query[$key] : '';
      else
        foreach($this->queryStringKey as $key=>$value)
          $this->queryString[$value] = ($key == 0) ? '' : ( ($key == 3) ? '' : $query[$key-1]);
      break;
    case 1:
      if($query[0] == $this->queryStringKey[0])
        foreach($this->queryStringKey as $key=>$value)
          $this->queryString[$value] = ($key == 0) ? $query[0] : '';
      else
        foreach($this->queryStringKey as $key=>$value)
          $this->queryString[$value] = ($key == 0) ? '' : ( ($key == 1) ? $query[0] : '');
      break;
    case 0:
      foreach($this->queryStringKey as $key=>$value)
        $this->queryString[$value] = '';
      break;
    default:
      break;
    }
  }

  /*  finale url */
  public function getUrlParseResult(){
    return $this->finalUrl;
  }

  /* script name */
  private function setScriptName(){
    $this->scriptName = "http://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'].'?';
  }

  /* original url */
  public function getOriginalUrl(){
    $encode = &loadSysClass('encode');
    return $encode->decodeUrl($this->originalUrl);
  }
  //@fun: get original URL of this page
  private function setOriginalUrl(){
    $_tempUrl = '';
    $encode = &loadSysClass('encode');
    if(!empty($_POST))
      foreach($_POST as $key=>$value)
        $_tempUrl .= '&'.$key.'='.$value;
    if(!empty($_GET))
      foreach($_GET as $key=>$value)
        $_tempUrl .= '&'.$key.'='.$value;
    $this->originalUrl = $this->scriptName.$encode->encodeUrl(substr($_tempUrl, 1));
  }

  public function initQueryString(){
    $encode = &loadSysClass('encode');
    $_query = explode('?', $this->originalUrl, 2);
    $_query = trim($encode->decodeUrl($_query[1]), '/');
    $_query = trim($_query, '=');
    $_queryArr = explode('/', $_query, 4);
    foreach($_queryArr as $_key=>$_value)
      $_queryArr[$_key] = trim($_value);
    $_length = count($_queryArr);
    $this->setQueryStringKey();
    $this->setQueryString($_queryArr);
    $this->setFinalUrl();
    //    var_dump($this->urlParseResult);
  }

  /* final url */
  private function setFinalUrl(){
    $result = '';

    foreach($this->queryStringKey as $key=>$value){
      if($key == 0)
        $result .= $value.'='.$this->queryString[$value];
      elseif($key != 3)
        $result .= '&'.$value.'='.$this->queryString[$value];
      else
        $result .= '&'.$this->queryString[$value];
    }
    $this->finalUrl = $this->scriptName.$result;
  }

  //@fun:
  public function parseQueryParam(){
    $param = $this->queryString[$this->queryStringKey[3]];
    $result = array();
    if( $param == '' )
      return;
    foreach(explode('&', $param) as $value){
      $temp = explode('=', $value, 2);
      $result[trim($temp[0])] = trim($temp[1]);
    }
    $this->queryString[$this->queryStringKey[3]] = $result;
  }
}

?>
