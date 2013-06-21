<?php
header ("Content-Type:text/xml");
/*------------------------------------------------------------------------*
 * � 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
require_once('./conf.php');
function sendOutput($id, $com, $data)
{
 $error_occured=0;
 $response='';
  try
  {
      
  $content=$data; 
  $content=str_replace('\'','\'\'',$content);
  $content=str_replace('\"','\"\"',$content);
  $pattern = '/<\?xml version.*;?>/i';
  $replacement = '';
  $content=preg_replace($pattern, $replacement, $content);
  $content=trim($content);
//  if(strpos($content, "<content>")==0){
//      $doc = new DOMDocument();
//      $doc->loadXML($content);
//      $xliffRoot = $doc->getElementsByTagName("xliff")->item(0);
//      $content=$doc->saveXML($xliffRoot);
//  }

    //open the database
    $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE.';port='.DB_PORT, DB_USERNAME, DB_PASS, array());
	
	$res = $db->query('SELECT CurrentStep FROM Project where ID="'.$id.'"');
	$data=(int) $res->fetchColumn();
	$step=(string)$data;
	
	$ret = $db->query("Update Demo set Output='".$content."' where Job='".$id."' and Com='".strtoupper($com)."' and WOrder=".$step);
    // close the database connection
	$db->exec('Update Demo set OutputDate=now() where Job="'.$id.'" and Com="'.strtoupper($com).'" and WOrder='.$step);
    $db = NULL;
  }
  catch(PDOException $e)
  {
    //print 'Exception : '.$e->getMessage();
	$response="<error><msg>".$e->getMessage()."</msg></error>";
  }
  if ($ret !== false) $response="<response><msg>Output Accepted</msg></response>"; 
  else  $response="<error><msg> Output was not updated. Ensure job id:".$id." is correct and component:".$com." has been assigned that job.</msg></error>";
  
   
  return $response;
}

$id=$_REQUEST["id"];
$com=$_REQUEST["com"];
$data=$_REQUEST["data"];
//echo "data before $data";

//$data=addcslashes($_POST["data"], "UTF-8");
//$data=addslashes($_POST["data"]);
//
//echo "data after $data";
////$data= sqlite_escape_string($data);

//print $data;
echo sendOutput($id,$com,$data);
;?>
