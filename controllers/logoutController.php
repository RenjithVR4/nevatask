<?php
/*********************************************************
   Author: 	Renjith V R
   Version: 	1.0
   Date:	24-Nov-2018
   FileName: 	logoutController.php
   Description:	Logout API for user
**********************************************************/

ini_set("display_errors", 1); 
error_reporting(E_ALL);

require_once("../helpers/helpers.php");

header("Content-Type:application/json");

//First check what is the method
if(!isset($_SERVER["REQUEST_METHOD"]) || !isset($_SERVER["REQUEST_URI"]))
{
    header("HTTP/1.1"."  ". 400 ."  ". "Bad Request");
    print json_encode(array("error"=>"HTTP Method or request URI is not set"));
    exit(0);
}

$method = $_SERVER["REQUEST_METHOD"];
$request = $_SERVER["REQUEST_URI"];

if($method!="GET")
{
    header("HTTP/1.1". "  ". 405 ."  ". "Bad Request");
    print json_encode(array("error"=>"HTTP Method not allowed"));
    exit(0);
}

if(!($userid = sessionValidate(USER_SESSION_ID)))
{
    header("HTTP/1.1". "  ". 401 ."  ". "Bad Request");
    print json_encode(array("error"=>"No valid session exist"));
    exit(0);
}
// echo $userid;exit;
if(empty($userid))
{
    header("HTTP/1.1"."  ". 400 ."  ". "Bad Request");
    print json_encode(array("error"=>"user id is missing"));
    exit(0);
}

if($userid)
{
     //remove the session
     session_destroy();
     error_log("Session destroyed. logged out");
     print json_encode(array("success" => $userid));
}

error_log("Imeds user Logout - ".$userid);
exit(0);
?>