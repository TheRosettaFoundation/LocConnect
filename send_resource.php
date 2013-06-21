<?php
header ("Content-Type:text/xml");
require_once('./conf.php');
/*------------------------------------------------------------------------*
 * � 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
function prepDB($data)
{
	//this function prepare string data to be appended to sqlite database.
	$tmpdata=stripslashes($data);
	$tmpdata=str_replace('\'','\'\'',$tmpdata);
	$tmpdata=str_replace('\"','\"\"',$tmpdata);
	$pattern = '/<\?xml version.*;?>/i';
	$replacement = '';
	$tmpdata=preg_replace($pattern, $replacement, $tmpdata);
	return $tmpdata;
}

function genID()
{
	// this function generates an resource ID that is not found in the Resources Database
	$newID=substr(md5(uniqid()), 0,10);
    $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE.';port='.DB_PORT, DB_USERNAME, DB_PASS, array());
	while (($newID==$id) || ($newID==""))
	{		
		$newID= substr(md5(uniqid()), 0,10);	 
		$result = $db->query("SELECT ResourceID FROM Resources where ResourceID='".$newID."'");
		$id=$result->fetchColumn();
	};
	$db=null;
	return $newID;		
}

function sendResource($nid, $type, $desc, $data, $metadata, $filename)
{
 $error_occured=0;
 $response='';
  try
  {
 
	$id=$nid;
	if ($id=="NOTSET") $id=genID(); // if Resource ID is not given, generate an ID for the resource;
	
    $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE.';port='.DB_PORT, DB_USERNAME, DB_PASS, array());
	
	$result = $db->query('SELECT ResourceID FROM Resources where ResourceID="'.$id.'"'); 
	// see whether a resource with the given ID already exists in the database
	
	$dbid= trim($result->fetchColumn());
	
	if ($dbid=='')  // there is no resource found in the database with given id. so we need to insert data.
	{
		$statement="INSERT INTO Resources(ResourceID, Type, Description, File, Filename) VALUES ('".$id."', '".strtoupper($type)."','".$desc."','".$data."','".$filename."')";
		
		$count = $db->exec($statement);
		//print $statement."<br/>";
		
		//process metadata sent with the request.
		//$metadata  = "attribute1:value1-attribut1:value2-attribut3:value3";
		$metaelements = explode("-", $metadata);
		foreach($metaelements as $item)
		{
			$s = explode(":", $item);
			$attrib=prepDB(trim($s[0]));
			$value=prepDB(trim($s[1]));
			$statement="INSERT INTO ResourceMetadata(ResourceID, Attribute, Value) VALUES ('".$id."', '".strtolower($attrib)."','".strtolower($value)."')";
			$count = $db->exec($statement);
			//print $statement."<br/>";
		}
	
	} else  // The resource corresponding to the given ID is already there. Therefore we need to update that resource.
	{
	   $count1 = $db->exec("Update Resources set File='".$data."' where ResourceID='".$id."'");
	   $count2 = $db->exec("Update Resources set Type='".strtoupper($type)."' where ResourceID='".$id."'");
	   $count3 = $db->exec("Update Resources set Description='".$desc."' where ResourceID='".$id."'");
	   
	   // Delete all the metadata related with given ResourceID
	   $count = $db->exec("Delete FROM ResourceMetadata where ResourceID='".$id."'");
	    
		//process metadata
	    //$metadata  = "attribute1:value1-attribut1:value2-attribut3:value3";
		$metaelements = explode("-", $metadata);
		foreach($metaelements as $item)
		{
			$s = explode(":", $item);
			$attrib=prepDB(trim($s[0]));
			$value=prepDB(trim($s[1]));
			$statement="INSERT INTO ResourceMetadata(ResourceID, Attribute, Value) VALUES ('".$id."', '".strtolower($attrib)."','".strtolower($value)."')";
			$count = $db->exec($statement);
			//print $statement."<br/>";
		}
	};
	
    // close the database connection
    $db = NULL;
  }
  catch(PDOException $e)
  {
    //print 'Exception : '.$e->getMessage();
	$response="<error><msg>".$e->getMessage()."</msg></error>";
  }
  
  //if ($count>0) $response="<response><msg>Output Accepted</msg></response>"; 
  //else  $response="<error><msg> Output was not updated. Ensure job id:".$id." is correct and component:".$com." has been assigned that job.</msg></error>";
  $response="<resource><msg>".$id."</msg></resource>";
  return $response;
}

$id=$_POST["id"];
$type=$_POST["type"];
$desc=$_POST["desc"];
$metadata=$_POST["metadata"];
$content=$_POST["data"]; 
$filename=$_POST["filename"];

$data=prepDB($content);

//print $data;

if($id=="") $id="NOTSET";  //resource id was not found in the request
if($desc=="") $desc="";    

//validate post request
if ($data=="") 
{
print "<error><msg>data not found in the request</msg></error>";
} else
{
	if ($metadata=="")
	{
	 print "<error><msg>metadata not found in the request</msg></error>";
	} else 
	{
	 if ($type=="")
	 {
	  print "<error><msg>resource type not found in the request</msg></error>";
	 } else echo sendResource($id, $type, $desc, $data, $metadata, $filename);
	}
}
//print $data;
;?>
