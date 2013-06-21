<?php
header ("Content-Type:text/xml; charset=utf-8");
/*------------------------------------------------------------------------*
 * � 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
require_once('./conf.php');
function getFilename($id, $com)
{
  $fileData='';
  try
  {
    //open the database
    $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE.';port='.DB_PORT, DB_USERNAME, DB_PASS, array());
	
	$res = $db->query('SELECT CurrentStep FROM Project where ID="'.$id.'"');
	$data=(int) $res->fetchColumn();
	$step=(string)$data;
	
	//$result = $db->query('SELECT * FROM Demo where job="'.$id.'" and com="'.strtoupper($com).'" and WOrder='.$step);
        $result = $db->query('SELECT * FROM Demo limit 1');
	$data= $result->fetch();
        print_r($data);
	$fileData="<content>".$data[0]."</content>";
        echo "hello world";
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


echo getFilename($id,$com);


;?>
