<?php
header('Content-Type: text/xml; charset=utf-8');
/*------------------------------------------------------------------------*
 * � 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
require_once('./conf.php');
function fetchJob($com)
{
  $fileData='';
  try
  {
    //open the database
    $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE.';port='.DB_PORT, DB_USERNAME, DB_PASS, array());
	$result = $db->query('SELECT Job FROM Demo where com="'.$com.'" and Status="pending"');
	foreach($result as $row)
    {
	$fileData=$fileData.'<job>'.$row['Job'].'</job>';
	}
	
	$fileData="<jobs>".$fileData."</jobs>";
    // close the database connection
    $db = NULL;
  }
  catch(PDOException $e)
  {
    //print 'Exception : '.$e->getMessage();
	$fileData="<error><msg>".$e->getMessage()."</msg></error>";
  }
  if (trim($fileData)=='<jobs></jobs>') $fileData="<error><msg>Component:".$com." does not have any pending jobs</msg></error>";
  return $fileData;
}

$com=$_REQUEST["com"];
echo fetchJob($com);
;?>
