<?php
header ("Content-Type:text/xml; charset=utf-8");
/*------------------------------------------------------------------------*
 * © 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
require_once('./conf.php');
function getJob($id, $com)
{
  $fileData='';
  try
  {
    //open the database
    $db = new PDO('sqlite:'.BASE_DB_URL.'locTemp.sqlite');
	
	$res = $db->query('SELECT CurrentStep FROM Project where ID="'.$id.'"');
	$data=(int) $res->fetchColumn();
	$step=(string)$data;
	
	$result = $db->query('SELECT fileData FROM Demo where job="'.$id.'" and com="'.strtoupper($com).'" and WOrder='.$step);
	$count = $db->exec('Update Demo set PickDate=datetime("now") where Job="'.$id.'" and Com="'.strtoupper($com).'" and WOrder='.$step);
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
  if (trim($fileData)=='<content></content>') $fileData="<error><msg>Either component:".$com." not found or job:".$id." is not available for this component</msg></error>";
  return $fileData;
}

$id=$_GET["id"];
$com=$_GET["com"];


echo getJob($id,$com);


;?>