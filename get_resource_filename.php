<?php
header ("Content-Type:text/xml; charset=utf-8");
/*------------------------------------------------------------------------*
 * � 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
require_once('./conf.php');
function getResourceFilename($id,$type)
{
  $fileData='';
  try
  {
    //open the database
    $db = new PDO('sqlite:'.BASE_DB_URL.'locTemp.sqlite');
     if(is_null($type)){
            $result = $db->query("SELECT Filename FROM Resources where ResourceID='$id'");
        }else{
            $result = $db->query("SELECT Filename FROM Resources where ResourceID='$id' and Type='$type'");
        }
	
	$result = $result->fetchColumn();
//        echo $result;
	$fileData = $result;
    // close the database connection
    $db = NULL;
  }
  catch(PDOException $e)
  {
    //print 'Exception : '.$e->getMessage();
	$fileData="<error><msg>".$e->getMessage()."</msg></error>";
  }
  return $fileData;
}
$id=$_GET["id"];
$type=null;
if(isset ($_GET["type"])) $type=$_GET["type"];
echo getResourceFilename($id, $type);

;?>