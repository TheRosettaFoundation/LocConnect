<?php
 header ("Content-Type:text/xml");
/*------------------------------------------------------------------------*
 * © 2012 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
require_once('./conf.php');
require_once 'HTTP/Request2.php';
	function createNewProject($com, $project_name, $project_desc, $data)
	{
	global $arr;
	if ($com=="") return "<error><msg>Component name is mandatory for direct project creation requests.</msg></error>";
	if ($data=="") return "<error><msg> No data received. Project can not be created without data.</msg></error>";
	if (!array_key_exists($com, $arr)) return "<error><msg>Component not registed with LocConnect. Project creation request ignored due to security concerns.</msg></error>";
	//preprocess/clean parameters
			
	$content=$data; 
    $content=str_replace('\'','\'\'',$content);
    $content=str_replace('\"','\"\"',$content);
    $pattern = '/<\?xml version.*;?>/i';
    $replacement = '';
    $content=preg_replace($pattern, $replacement, $content);

	//print $content;
		
	$desc=$project_desc;
	$desc=str_replace('\'','',$desc);
	$desc=str_replace('"','',$desc);
		
	$pname=$project_name;
	$pname=str_replace('\'','\'\'',$pname);
	$pname=str_replace('"','""',$pname);
		 

	
		 
	//generate project id;
	$project_ID="";
	$id="";
		
    $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE.';port='.DB_PORT, DB_USERNAME, DB_PASS, array());
	while (($project_ID==$id) || ($project_ID==""))
	{		
	$project_ID= substr(md5(uniqid()), 0,10);	 
	$result = $db->query("SELECT Job FROM Demo where job='".$project_ID."'");
	$id=$result->fetchColumn();
	};
	$db=null;	

		 
	$statement="INSERT INTO Demo(Job, FileData, Com, Status, WOrder) VALUES ('".$project_ID."', '".trim($content)."','WFR','pending',1)";
	$statement3="INSERT INTO Project(ID, `Desc`, CreateDate, MaxSteps, CurrentStep, PName) VALUES ('".$project_ID."', '".$desc."',now(),100,1,'".$pname."')";
	
	$resp="<response><msg>".$project_ID."</msg></response>";
	try
	{
        $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE.';port='.DB_PORT, DB_USERNAME, DB_PASS, array());
		 $count = $db->exec($statement);
		 $count = $db->exec($statement3);
		 $db= null;
	}  catch(PDOException $e)
	{
			$resp="<error><msg>".$e->getMessage()."</msg></error>";
	}
	
	return $resp;
 }
	
	$com_param="";
	$pname_param="";
	$pdesc_param="";
	$data_param="";
 
	if (isset($_POST["com"])) $com_param=trim($_POST["com"]); 
	if (isset($_POST['pname']))	$pname_param=trim($_POST['pname']); else $pname_param="Demo XLIFF Project - ".date("F j, Y @ g:i a");
	if (isset($_POST['pdesc']))	$pdesc_param=trim($_POST['pdesc']); else $pdesc_param="[XLIFF submission via DIRECT API CALL] Project created by ".$com_param." on ".date("F j, Y @ g:i a");
	if (isset($_POST["data"]))	$data_param=trim($_POST["data"]);
	$data=stripslashes(trim($data_param));
 
	echo createNewProject($com_param,$pname_param,$pdesc_param,$data_param);
;?>
