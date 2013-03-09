<?php

/*
 * @author: firewood
 * @time: 2012-01-13
 * @description: Team Website
 */

/*
 * @description: This file is the entrance of the entire porgram
 * Include the basic config of the website
 * Import the basic class and function
 * Guide into the system master file
 */

header("Expires:  Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Param: no-cache");

//the certificate to enter all file
define('IS_ACTIVE',true);

//the file format
define('C_File_EXT', '.php');

//system separator
define('C_Sep', DIRECTORY_SEPARATOR);

//main dir
define('C_Dir_Current', '.'.C_Sep);

//define execture environment
define('ENVIRONMENT', true);

//error reporting
if(defined('ENVIRONMENT') && ENVIRONMENT == true){
  ini_set("display_errors", 1);
  error_reporting(E_ALL);
  ini_set('error_log', C_Dir_Current.'log.txt');
}
else
  ini_set("display_errors", 0);


//the entrance file of the program
define('C_File_SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

//the system dir
chdir(dirname(__FILE__));
define('C_File_Path_Main', dirname(__FILE__). C_Sep);
//define('C_File_Path_Sys', realpath('system').C_Sep);

//user define const
//require C_File_Path_Main.C_Sep.'config'.C_Sep.'config'.C_File_Format;

//load core program
require C_File_Path_Main.'system'.C_Sep.'index.system.php';

?>
