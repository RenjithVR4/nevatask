<?php
error_reporting(E_ALL);

define('USER_SESSION_ID', '');


function DBConnection()
{
	$mysqlcon = new mysqli('localhost', 'root', 'root','friends');

	if ($mysqlcon->connect_errno)
	{
		error_log("Failed to connect to MySQL: (" . $mysqlcon->connect_errno . ") " . $mysqlcon->connect_error);
		return false;
	}

	$mysqlcon->query("SET GLOBAL sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'");

	$mysqlcon->query("SET SESSION sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'");

	return $mysqlcon;
}


function generateHash($password)
{
	if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH)
	{
		$salt = '$2y$11$' . substr(md5('A~B!C@D#E$F%'), 0, 22);
		$passwordhash =  crypt($password, $salt);
		// $passwordhash = str_replace("\/", '', $passwordhash);
		$passwordhash = str_replace('/', '', $passwordhash);
		error_log("passwordhash => ". $passwordhash);
		return $passwordhash;
	}
}

function sessionValidate($roleid,$id=NULL)
{
	session_start();

	if(!isset($_SESSION[$roleid]))
	{
		return false;
	}

	if(!empty($id) && $_SESSION[$roleid] !== $id)
	{
		return false;
	}

	$id = $_SESSION[$roleid];

	if((time() - $_SESSION['LOGIN_TIME']) >= 7200)
	{
		error_log('Session Expired: '.$id.' from '.$_SERVER['REMOTE_ADDR']);
		session_destroy();
		return false;
	}


	return $id;
}




function mysql_fix_string($string,$mysqlcon)
{
	if (get_magic_quotes_gpc()) $string = stripslashes($string);
	return $mysqlcon->real_escape_string(trim($string));
}


function getDBConnectorPhrase($query)
{
  	if(!stristr($query,'WHERE'))
	{
		return " WHERE ";
	}
	else
	{
		return " AND ";
	}
}

function getDBORConnectorPhrase($query)
{
  	if(!stristr($query,'WHERE'))
	{
		return " WHERE ";
	}
	else
	{
		return " OR ";
	}
}

function uploadFilePOST($dest,$filename)
{

	// print_r($_FILES);
	error_log(json_encode($_FILES));
	if (!move_uploaded_file($_FILES[$filename]['tmp_name'], $dest))
	{
		error_log('Could not upload '.$filename);
		return false;
	}

	return true;

}

function uploadFilePUT($dest)
{

	/* PUT data comes in on the stdin stream */
	if(!($putdata = fopen("php://input", "r")))
	{
		error_log('Could not read Input data');
	}

	/* Open a file for writing */
	if(!($fp = fopen($dest, "w")))
	{
		error_log('Could not open output file: '.$dest);
	}

	/* Read the data 1 KB at a time  and write to the file */
	while ($data = fread($putdata, 1024))
  		fwrite($fp, $data);

	/* Close the streams */
	fclose($fp);
	fclose($putdata);

	return true;
}

function checkValidEmail($email)
{
	if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
	     return true;
	} else {
	     return false;
	}
}




 ?>
