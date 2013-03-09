<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Load_Error);

/*
 * style load file
 */

function displayCssFile($file, $suffix = ''){
  if($file == '')
    return;
  if(!is_array($file))
    $file = array($file);
  foreach($file as $value){
    echo '<link rel="stylesheet" style="text/css" href="'.$value.$suffix.'" />';
  }
}

function displayJsFile($file, $suffix = ''){
  if($file == '')
    return;
  if(!is_array($file))
    $file = array($file);
  foreach($file as $value)
    echo '<script type="text/javascript" src="'.$value.$suffix.'"></script>';
}



?>
