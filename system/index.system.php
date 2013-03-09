<?php

//if(!defined('IS_ACTIVE')) die(C_Meg_Access);

/*
 * the entrance to the core program
 */

/* load file error message */
define('C_Meg_Load_Error', 'load file error!');
/* system folder */
define('C_Sys_Path', C_File_Path_Main.'system'.C_Sep);

//load file
/* load core function */
include_once C_Sys_Path.'core'.C_Sep.'load.core.php';

/*
  load style.core.php
*/
loadSysFile('style', 'core');

/*
  load system constants
*/
loadSysFile('constants', 'config');

loadSysFile('variables', 'core');
loadSysFile('config', 'core');
/*
  load dir config
   the system folder contants the directory
*/
loadSysFile('dir', 'config');
/*
  load file config
  the main document and the special file
*/
//loadSysFile('file', 'config');

/*
  load process file
*/
$process = &loadSysClass('process');
$process->initSysBaseInfo();
$process->initSysCoreInfo();
$process->integrateInfo();
$process->parseUrlInfo();
$process->initExecModule();
$process->execute();

//var_dump($GLOBALS);
?>
