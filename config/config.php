<?php

if(!defined('IS_ACTIVE')) exit(C_Meg_Access);

/*
 * the user basic config file
 */

//define user contants
define('C_Core_Debug', true);  //debug model

//define visitors model
define('C_Each_Visitors_Id', 0);

//define session contans
define('C_Each_Time_Now', time());
define('C_Each_Sess_Save_Time', 3600);

//define common plugins
define('C_Each_Plugin_Homepage', 'homepage');
define('C_Each_Plugin_Login', 'login');

//dir
define('C_Each_Dir_Plugin', C_File_Path_Main.C_Sep.'plugin');
define('C_Sys_Path', C_File_Path_Main.C_Sep.'system');
define('C_Each_Dir_Plugin_Homepage', C_Each_Dir_Plugin.C_Sep.C_Each_Plugin_Homepage);
define('C_Each_Dir_Plugin_Login', C_Each_Dir_Plugin.C_Sep.C_Each_Plugin_Login);
define('C_Each_Dir_Template', C_File_Path_Main.C_Sep.'template');
define('C_Each_Dir_Style_Url', 'teampage/style');
//define('C_Each_Dir_Style', C_File_Path_Main.C_Sep.'style');
define('C_Each_Dir_Style_Css', C_Each_Dir_Style_Url.C_Sep.'css');
define('C_Each_Dir_Style_Js', C_Each_Dir_Style_Url.C_Sep.'js');

//file
define('C_Each_File_Top', C_Each_Dir_Template.C_Sep.'top.htm');
define('C_Each_File_Bottom', C_Each_Dir_Template.C_Sep.'bottom.htm');


//access error message
define('C_Meg_Access', 'The script load error!');
?>
