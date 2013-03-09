<?php

if(!defined('IS_ACTIVE')) exit(C_Meg_Load_Error);

/*
  user config file information
*/

$config['style'] = array();
$config['style']['javascript'] = array(
  'base.js', 'jQuery.js'
);
$config['style']['css'] = array(
  'base.css'
);

$config['page'] = array();
$config['page']['front'] = 'front.htm';
$config['page']['rear'] = 'rear.htm';
$config['page']['title'] = 'Unique Studio Web';
?>
