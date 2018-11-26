<?php
/*********************************************************
   Author:      Renjith VR
   Version:     1.0
   Date:        24-Nov-2018
   FileName:    messageModel.php
   Description : database/utilities for message
**********************************************************/

function listMessages($userid, $page=1)
{  
    $mysqlcon = DBConnection();
    
    $get_messages_query = "SELECT M.idmessage, U.iduser, U.name, M.createddate FROM messages M LEFT JOIN users U ON M.sentby = U.iduser WHERE M.receivedby = ". $userid;

    $get_messages_query .= " ORDER BY M.createddate ASC";
        
    error_log("page =>". $page);
    $limit = $page-1;

    $get_messages_query.= " LIMIT ". ($limit*10) . ",10";

    error_log($get_messages_query);

    if(!$result = $mysqlcon->query($get_messages_query))
    {
        error_log("List messages error: ".$mysqlcon->errno. ": ".$mysqlcon->error);
        $mysqlcon->close();
        return array('error'=> 'List messages query error');
    }

    $count = $result->num_rows;

    if($result->num_rows == 0)
    {
        $mysqlcon->close();
        return array('error'=> 'Empty');
    }
    
    $messages = array();

    while($row = $result->fetch_assoc()) 
    {
        $messages['data'][] = $row;
    }
    
    $result->close();
    $mysqlcon->close();

    return $messages;
}


function insertMessage($params)
{   
    $mysqlcon = DBConnection();
    
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d H:i:s');

    $values = array();
    $keys = array();

    foreach($params as $key=>$value)
    {
        $keys[] = mysql_fix_string($key,$mysqlcon);
        $values[] = mysql_fix_string($value,$mysqlcon);
    }
    
    $query = "INSERT INTO messages (".implode(",",$keys).",createddate) VALUES ('".implode("','",$values)."', '$date')";
    unset($keys);
    unset($values);

    error_log($query);

  
    if(!$result = $mysqlcon->query($query))
    {
        error_log("Insert page error: ".$mysqlcon->errno. ": ".$mysqlcon->error);
        $mysqlcon->close();
        return array('error'=> 'Insert message query error');
    }
   
    
    $mysqlcon->close();

    return array("success" => "message send successfully");
    
}


