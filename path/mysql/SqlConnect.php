<?php
/*
 * connecting to database
 */

 $host = "localhost";
   $username = "root";
   $password = "";
   $database = "enri";
   
   mysql_connect($host, $username, $password);
   mysql_select_db($database);
function connect(){
   $host = "localhost";
   $username = "root";
   $password = "";
   $database = "enri";

   $connection =  mysqli_connect($host, $username, $password,  $database);
    if($connection)
        return $connection;
    else
        die(mysqli_connect_error());
}
 
function SQLExc($sql)
{
   $connection = connect();
    $result = mysqli_query($connection, $sql);
    if(!$result)
        echo " There was an error".  mysqli_error($connection);
    else
        return $result; 
}

function convertResultToArray($sql)
{
   
    $connection = connect();
    $result = mysqli_query($connection, $sql);
    $i = 0;
    while($row = mysqli_fetch_array($result))
    {
       $country[$i] = $row;
       $i++;
    }
    
    return $country;
}
function getNumberOfRows($sql)
{
 $connection = connect();
    $stmt = mysqli_prepare( $connection, $sql);
    
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        
        $Rows = mysqli_stmt_num_rows($stmt);
    
    return $Rows;
    }
 function SQLInsertUpdateDelete($sql)
{
    $connectionn = connect();
    
      $result = mysqli_query($connectionn, $sql);
      
      if($result)
          return true;
      else
          return false;
    
}
?>