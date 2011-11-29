<?php
header ("Content-Type:text/xml; charset=utf-8");
/*------------------------------------------------------------------------*
 * © 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
require_once('./conf.php');
function getResource($id)
{
  $fileData='';
  try
  {
    //open the database
    $db = new PDO('sqlite:'.BASE_DB_URL.'locTemp.sqlite');
	$result = $db->query('SELECT File FROM Resources where ResourceID="'.$id.'"');
	$data= stripslashes($result->fetchColumn());
	$fileData="<content>".$data."</content>";
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
echo getResource($id);
;?>