<?php

if(!defined('IS_ACTIVE')) exit(C_Meg_Access);

/*
 * define the system contants
 */
/*[C_File_Head] => index
  [C_File_Format] => .php
  [C_Sep] => /
  [C_File_Path_Main] => /var/www/teampage
  [C_Sys_Path] => /var/www/teampage/system
  [C_Meg_Access] => The script load error!
  [C_Base_Config_Fun] => base_config
 */

$_TempVar = array();


//define the file suffix
define('C_Sys_Boot_Suffix', '.boot.php');
define('C_Sys_Config_Suffix', '.config.php');
define('C_Sys_Core_Suffix', '.core.php');
define('C_Sys_Base_Suffix', '.base.php');
define('C_Sys_Lib_Suffix', '.lib.php');

//boot file
define('C_Sys_Boot_Key', 'config');

define('C_Sys_Model_Default', '_default');


$_TempVar['dir_file'] = 'dir';
$_TempVar['dir_dir'] = C_Sys_Path.C_Sep.'config'.C_Sep.$_TempVar['dir_file'].C_Sys_Config_Suffix;
if(file_exists($_TempVar['dir_dir']))
  include_once $_TempVar['dir_dir'];
else
  die('please do not modify or delete the file dir.comfig.php');

unset($_TempVar);
?>
