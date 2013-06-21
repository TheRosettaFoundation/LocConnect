<?php
header ("Content-Type:text/xml; charset=utf-8");
/*------------------------------------------------------------------------*
 * � 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
require_once('./conf.php');
function getExtension($id)
{
  $fileData='';
  try
  {
     //open the database
    $DBH = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE.';port='.DB_PORT, DB_USERNAME, DB_PASS, array());
	
    $getID = $DBH->prepare('SELECT filename FROM Project where ID=:idDB');
    $getID->bindParam(":idDB", $id);
    
    
    //$STH = $DBH->query('SELECT filename FROM Project where ID='.$id.'');
    $getID->setFetchMode(PDO::FETCH_ASSOC);
    
    $getID->execute();
    
    $Result = $getID->fetchAll();
    $data = "<content>";
    foreach ($Result as $row)
    {
        
//        $temp = $row['filename'];
//        $ext=(string) substr($temp, strpos($temp,'.')+1, strlen($temp)-1); // Get the extension from the filename;
        $data.=$row['filename'];
        $data.= "<content>";
    }
    //$ext=(string) substr($data, strpos($data,'.'), strlen($data)-1); // Get the extension from the filename;
    $fileData=$data;
        
    $DBH = NULL;
  }
  catch(PDOException $e)
  {
    //print 'Exception : '.$e->getMessage();
	$fileData="<error><msg>".$e->getMessage()."</msg></error>";
        echo "hello, can I come too?";
  }
  //if (trim($fileData)=='<content></content>') $fileData="<error><msg> job:".$id." is not available for this component</msg></error>";
  return $fileData;
}

$id=$_GET["id"];
//$com=$_GET["com"];


echo getExtension($id);


;?>
