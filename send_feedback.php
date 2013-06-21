<?php
header("Content-Type:text/xml;  charset=utf-8");
/*------------------------------------------------------------------------*
 * � 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
require_once('./conf.php');
function sendFeedback($id, $com, $msg)
{
 $error_occured=0;
 $response='';
  try
  {
    //open the database
    $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE.';port='.DB_PORT, DB_USERNAME, DB_PASS, array());
	
	$res = $db->query('SELECT CurrentStep FROM Project where ID="'.$id.'"');
	$data=(int) $res->fetchColumn();
	$step=(string)$data;

	
	$count = $db->exec("Update Demo set Feedback='".$msg."' where Job='".$id."' and Com='".strtoupper($com)."' and WOrder=".$step);
	$db->exec('Update Demo set UpdatedDate=now() where Job="'.$id.'" and Com="'.strtoupper($com).'" and WOrder='.$step);
    // close the database connection
    $db = NULL;
  }
  catch(PDOException $e)
  {
    //print 'Exception : '.$e->getMessage();
	$response="<error><msg>".$e->getMessage()."</msg></error>";
  }
  if ($count>0) $response="<response><msg>Feedback Updated</msg></response>"; 
  else  $response="<error><msg> Feedback was not updated. Ensure job id:".$id." is correct and component:".$com." has been assigned that job.</msg></error>";
   
  return $response;
}

$id=$_REQUEST["id"];
$com=$_REQUEST["com"];
$msg=$_REQUEST["msg"];
$msg=urldecode($msg);  
if (strlen($msg)>250) $msg=substr($msg,0,250).'..';
$msg=stripslashes($msg);

  $content=$msg; 
  $content=str_replace('\'','\'\'',$content);
  $content=str_replace('\"','\"\"',$content);
  $pattern = '/<\?xml version.*;?>/i';
  $replacement = '';
  $content=preg_replace($pattern, $replacement, $content);


//echo "id:".$id."<br/>";
//echo "com:".$com."<br/>";
//echo "msg:".$msg."<br/>";
echo sendFeedback($id,$com,$content);
