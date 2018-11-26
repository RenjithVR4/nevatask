<?php
/*********************************************************
   Author: 	Renjith V R
   Version: 	1.0
   Date:	 24-Nov-2018
   FileName: 	loginController.php
   Description:	Login API for user
**********************************************************/
ini_set("display_errors", 1); 
error_reporting(E_ALL);

require_once("../helpers/helpers.php");

header("Content-Type:application/json");


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
	//Get user Id
	$parts = parse_url($request);
	$path_parts = pathinfo($parts["path"]);
	$id = $path_parts["filename"];

	if(!isset($_POST["password"]) || !isset($_POST["email"]))
	{
        header("HTTP/1.1" ."  ". 400 ."  " .  "Bad Request");
        error_log("Missing Parameters");
        print json_encode(array("error"=>"Missing Parameters"));
		exit(0);
	}

	if(!($result = verifyAccount($_POST["email"],$_POST["password"])))
	{
		error_log($result);
		print json_encode(array("error"=>"Login Failed. Check Username/Password"));
		exit(0);
	}

	//Start session
	session_start();
	//Login is successful
	session_regenerate_id();

	
	$_SESSION[USER_SESSION_ID] = $result["iduser"];
	$_SESSION["SESS_NAME"] = $result["name"];
	$_SESSION["SESS_EMAIL"] = $result["email"];
	$_SESSION["LOGIN_TIME"] = time();
	session_write_close();

	print json_encode($result);

}

/** 
 * Verify user account with given params 
 * 
 * @author    Renjith V R
 * @access    public 
 * @param     string,string
 * @return    json
 */

function verifyAccount($email,$password)
{
	$mysqlcon = DBConnection();

	$email = $mysqlcon->real_escape_string(trim($email));
	$password = $mysqlcon->real_escape_string(trim($password));

	$password = generateHash($password);

	error_log($password);

	$userquery = "SELECT * FROM users WHERE email = '$email'";

	error_log($userquery);

	//Execute query
	if(!($result = $mysqlcon->query($userquery)))
	{
		error_log("user login failed: (" . $mysqlcon->errno . ") " . $mysqlcon->error);
		return false;
    }
    
    error_log("num rows =>" .$result->num_rows);

	if ($result->num_rows == 0)
	{
        error_log("No login match for user with email / password : ". $email);
        return false;
	}
	else
	{
        $row = $result->fetch_assoc();
		$row["type"] = "user";
	}

	$result->close();
	$mysqlcon->close();

	// error_log("row =>".json_encode($row));
	error_log("dbpassword =>".json_encode($row["password"]));
	error_log("givenpassword =>".json_encode($password));

	if($password != $row["password"])
	{
		return false;
	}

    error_log("row =>".json_encode($row));
    unset($row["password"]);
    

	return $row;
}

//First check what is the method
if(!isset($_SERVER["REQUEST_METHOD"]) || !isset($_SERVER["REQUEST_URI"]))
{
	header("HTTP/1.1". " "  . 400 ."  ". "Bad Request");
	print json_encode(array("error" => "HTTP Method or request URI is not set"));
    exit(0);
}

$method = $_SERVER["REQUEST_METHOD"];
$request = $_SERVER["REQUEST_URI"];

if($method != "POST")
{
	header("HTTP/1.1". " "  . 405 ."  ". "Bad Request");
	print json_encode(array("error" => "HTTP Method not allowed"));
    exit(0);
}

rest_post($request);

exit(0);
?>