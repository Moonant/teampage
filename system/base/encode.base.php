<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Access);

/*
 * code class
 */

class SYS_Encode{

  //@fun: encode url
  public function encodeUrl($url){
    return urlencode($url);
  }

  //@fun: decode url
  public function decodeUrl($url){
    return urldecode($url);
  }

}

?>
