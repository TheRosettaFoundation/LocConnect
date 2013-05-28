<?php
require_once('./conf.php');
header('Content-Type: text/html; charset=utf-8');
/*------------------------------------------------------------------------*
 * © 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
function showFileData($id, $com)
{
  $fileData='';
  try
  {
    //open the database
    $db = new PDO('sqlite:'.BASE_DB_URL.'locTemp.sqlite');
	$result = $db->query('SELECT fileData FROM Demo where job="'.$id.'" and com="'.strtoupper($com).'"');
	$data= stripslashes($result->fetchColumn());
	$fileData="<content>".htmlspecialchars($data, ENT_QUOTES, "UTF-8")."</content>";
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

function showOutput($id, $com)
{
  $fileData='';
  try
  {
    //open the database
    $db = new PDO('sqlite:'.BASE_DB_URL.'locTemp.sqlite');
	$result = $db->query('SELECT Output FROM Demo where job="'.$id.'" and com="'.strtoupper($com).'"');
	$data= stripslashes($result->fetchColumn());
	$fileData="<content>".htmlspecialchars($data, ENT_QUOTES, "UTF-8")."</content>";
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
$type=$_GET["type"];


if ($type=='fd') echo showFileData($id,$com); else if ($type=='output') echo showOutput($id,$com); else echo "Nothing to show";
echo "\n<br>\n<a href='http://".$_SERVER['HTTP_HOST'].BASE_URL."/'> Back<a>";
;?>