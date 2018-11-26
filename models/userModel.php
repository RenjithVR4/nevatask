<?php
/*********************************************************
   Author:      Renjith VR
   Version:     1.0
   Date:        24-Nov-2018
   FileName:    userModel.php
   Description: Database utilities for user
**********************************************************/

function getUsers()
{  
    $mysqlcon = DBConnection();
    
    $get_users_query = "SELECT iduser, name FROM users";

   
    $get_users_query .= " ORDER BY createddate DESC";
    

    error_log($get_users_query);

    if(!$result = $mysqlcon->query($get_users_query))
    {
        error_log("List users error: ".$mysqlcon->errno. ": ".$mysqlcon->error);
        $mysqlcon->close();
        return array('error'=> 'List users query error');
    }

    $count = $result->num_rows;

    if($result->num_rows == 0)
    {
        $mysqlcon->close();
        return array('error'=> 'Empty');
    }
    
    $users = array();

    while($row = $result->fetch_assoc()) 
    {
        $users['data'][] = $row;
    }
    
    $result->close();
    $mysqlcon->close();

    return $users;
}

function createUser($params)
{   
    $mysqlcon = DBConnection();
    
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d H:i:s');

    $params['password'] = generateHash(mysql_fix_string($params['password'],$mysqlcon));
    
    $values = array();
    $keys = array();

    foreach($params as $key=>$value)
    {
        $keys[] = mysql_fix_string($key,$mysqlcon);
        $values[] = mysql_fix_string($value,$mysqlcon);
    }
    
    $query = "INSERT INTO users (".implode(",",$keys).",createddate) VALUES ('".implode("','",$values)."', '$date')";
    unset($keys);
    unset($values);

    error_log($query);

   $get_user_by_email = getUserByEmail(mysql_fix_string($params['email'], $mysqlcon));
    
   error_log("get user email => " . json_encode($get_user_by_email));

   if(isset($get_user_by_email['error']) && $get_user_by_email['error'] == 'Empty')
   {
        if(!$result = $mysqlcon->query($query))
        {
            error_log("Insert user data error: ".$mysqlcon->errno. ": ".$mysqlcon->error);
            
            if($mysqlcon->errno == 1062)
            {
                return array('error'=> 'The given name already exists');
            }
            else
            {
                return array('error'=> 'Insert user data query error');
            }
            $mysqlcon->close();
        }
   }
   else
   {
        error_log("Duplicate email entry");
        $mysqlcon->close();
        return array("error" => "Duplicate email entry");
   }
    
    $mysqlcon->close();

    return array("success" => "Created user successfully");
    
}


function getUserById($userid)
{
    $mysqlcon = DBConnection();

    $get_userby_id_query = sprintf("SELECT iduser, name, email FROM users WHERE iduser = '%s'", mysql_fix_string($userid, $mysqlcon));

    error_log($get_userby_id_query);

    if(!$result = $mysqlcon->query($get_userby_id_query))
    {
        error_log("Error get user detail by id:". $mysqlcon->errno. ":". $mysqlcon->error);
        $mysqlcon->close();
        return array('error'=> 'Get user query error');
    }

    if($result->num_rows == 0)
    {
        $mysqlcon->close();
        return array('error'=> 'Empty');
    }

    $row['data'][] = $result->fetch_assoc();

    $result->close();
    $mysqlcon->close();

    return $row;
}


function getUserByEmail($email)
{
    $mysqlcon = DBConnection();
    error_log("Email to check => ". $email);

    $get_email_query = "SELECT * FROM users WHERE ".sprintf(" email = '%s'", mysql_fix_string($email, $mysqlcon));

    $get_email_query .= " ORDER BY email DESC";

    error_log($get_email_query);

    if(!$result = $mysqlcon->query($get_email_query))
    {
        error_log("Get email by email query error: ".$mysqlcon->errno. ": ".$mysqlcon->error);
        $mysqlcon->close();
        return array('error'=> 'Get email by email query error');
    }

    if($result->num_rows == 0)
    {
        error_log("Get email by email is Empty");
        return array("error" => "Empty");
    }

    $email = array();

    $email = $result->fetch_assoc();

    
    $result->close();
    $mysqlcon->close();

    return $email;

}


