<?php
header ("Content-Type:text/xml; charset=utf-8");
/*------------------------------------------------------------------------*
 * � 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
require_once('./conf.php');
function getResource($id, $type)
{
  $fileData='';
  try
  {
    //open the database
      $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE.';port='.DB_PORT, DB_USERNAME, DB_PASS, array());
        if(is_null($type)){
            $result = $db->query("SELECT File FROM Resources where ResourceID='$id'");
        }else{
            $result = $db->query("SELECT File FROM Resources where ResourceID='$id' and Type='$type'");
        }
            
	$data= stripslashes($result->fetchColumn());
	$fileData="<content>".base64_decode($data)."</content>";
    // close the database connection
    $db = NULL;
  }
  catch(PDOException $e)
  {
    //print 'Exception : '.$e->getMessage();
	$fileData="<error><msg>".$e->getMessage()."</msg></error>";
  }
  if (trim($fileData)=='<content></content>') $fileData="<error><msg>There is no resource corresponding to Resource ID:".$id."</msg></error>";
  return $fileData;
}
$id=$_GET["id"];
$type=null;
if(isset ($_GET["type"])) $type=$_GET["type"];
echo getResource($id,$type);
;?>
