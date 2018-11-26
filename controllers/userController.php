<?php
/*********************************************************
   Author:      Renjith VR
   Version:     1.0
   Date:        24-Nov-2018
   FileName:    userController.php
   Description : user API for users
**********************************************************/
header("Content-Type:application/json");
error_reporting(E_ALL);

require_once("../helpers/helpers.php");
require_once("../models/userModel.php");


/** 
 * function Rest PUT method 
 * 
 * @author   Renjith V R
 * @access    public 
 * @param     array
 * @return    json
 */
function rest_put($request)
{
	header("HTTP/1.1" ."  ". 405 ."  " .  "Bad Request");
    print json_encode(array("error" => "This method is not allowed"));
    exit(0);
}


/** 
 * function Rest POST method 
 * 
 * @author   Renjith V R
 * @access    public 
 * @param     array
 * @return    json
 */
function rest_post($request)
{
	$parts = parse_url($request);
	$path_parts = pathinfo($parts["path"]);
	$id = $path_parts["filename"];

	error_log(json_encode($_POST));

	if(empty($_POST["email"]) && empty($_POST["password"]))
	{
        header("HTTP/1.1" ."  ". 400 ."  " .  "Bad Request");
        print json_encode(array("error" => "Missing Parameters"));
        exit(0);
	}

	if(isset($_POST['email']) && (!checkValidEmail($_POST["email"])) )
	{
		header("HTTP/1.1" ."  ". 401 ."  " .  "Bad Request");
        print json_encode(array("error" => "Invalid Input, enter valid email address"));
        exit(0);
	}

	$result = createUser($_POST);

	if(isset($result["error"]) && $result["error"] === "Empty")
	{
		error_log("Error:".json_encode($result));
		return false;
	}

	print json_encode($result);
}

/** 
 * function Rest GET method 
 * 
 * @author   Renjith V R
 * @access    public 
 * @param     array
 * @return    json
 */
function rest_get($request)
{
	if(!($userid = sessionValidate(USER_SESSION_ID)))
	{
		header("HTTP/1.1" ."  ". 401 ."  " .  "Bad Request");
        print json_encode(array("error" => "No Valid Admin Session"));
        exit(0);
	}

	$parts = parse_url($request);
	$path_parts = pathinfo($parts["path"]);
	$id = $path_parts["filename"];

	error_log(json_encode($path_parts));

	error_log(json_encode($_GET));
	error_log("id =>".$id);


	
	if($id === "listing")
	{
		$result = getUsers();
		error_log("users => ". json_encode($result));

		$userdata = $result['data'];
		
		foreach($userdata as $key => $data)
		{
			if($data['name'] == $_SESSION["SESS_NAME"])
			{
				unset($result['data'][$key]);
			}
		}

		$result['userdata']['name'] = $_SESSION["SESS_NAME"];
	}
	else
	{
		if(!is_numeric($id))
		{
			header("HTTP/1.1" ."  ". 401 ."  " .  "Bad Request");
			print json_encode(array("error" => "Invalid Input"));
			exit(0);
		}

		$result = getUserById($id);
	}

	if(isset($result["error"]) && $result["error"] === "Empty")
	{
		error_log("Error:".json_encode($result));
		print json_encode(array("error" => "Empty"));
		exit(0);
	}

	print json_encode($result);
}

/** 
 * function Rest DELETE method 
 * 
 * @author   Renjith V R
 * @access    public 
 * @param     array
 * @return    json
 */

function rest_delete($request)
{
	header("HTTP/1.1" ."  ". 405 ."  " .  "Bad Request");
    print json_encode(array("error" => "This method is not allowed"));
    exit(0);
}


/** 
 * function Rest HEAD method 
 * 
 * @author   Renjith V R
 * @access    public 
 * @param     array
 * @return    json
 */
function rest_head($request)
{
	header("HTTP/1.1" ."  ". 405 ."  " .  "Bad Request");
    print json_encode(array("error" => "This method is not allowed"));
    exit(0);
}


/** 
 * function Rest OPTIONS method 
 * 
 * @author   Renjith V R
 * @access    public 
 * @param     array
 * @return    json
 */
function rest_options($request)
{
	header("HTTP/1.1" ."  ". 405 ."  " .  "Bad Request");
    print json_encode(array("error" => "This method is not allowed"));
    exit(0);
}

/** 
 * function Rest ERROR method 
 * 
 * @author   Renjith V R
 * @access    public 
 * @param     array
 * @return    json
 */
function rest_error($request)
{
	header("HTTP/1.1" ."  ". 405 ."  " .  "Bad Request");
    print json_encode(array("error" => "This method is not allowed"));
    exit(0);
}

//First check what is the method
if(!isset($_SERVER["REQUEST_METHOD"]) || !isset($_SERVER["REQUEST_URI"]))
{
    header("HTTP/1.1" ."  ". 400 ."  " .  "Bad Request");
    print json_encode(array("error" => "HTTP Method or request URI is not set"));
    exit(0);
}

$method = $_SERVER["REQUEST_METHOD"];
$request = $_SERVER["REQUEST_URI"];

switch($method)
{
	case "POST":
	rest_post($request);
	break;

	case "GET":
	rest_get($request);
	break;

	case "PUT":
	rest_put($request);
	break;

	case "DELETE":
	rest_delete($request);
	break;

	case "HEAD":
	rest_head($request);
	break;

	case "OPTIONS":
	rest_options($request);
	break;

	default:
	rest_error($request);
	break;
}

exit(0);

?>