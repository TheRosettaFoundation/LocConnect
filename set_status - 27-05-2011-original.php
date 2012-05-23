<?php
header ("Content-Type:text/xml");
/*------------------------------------------------------------------------*
 * © 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
require_once('./conf.php');
function setJobStatus($id, $com, $msg)
{
 $error_occured=0;
 $response='';
  try
  {
    //open the database
    $db = new PDO('sqlite:'.BASE_DB_URL.'locTemp.sqlite');
	$count = $db->exec('Update Demo set Status="'.strtolower($msg).'" where Job="'.$id.'" and Com="'.strtoupper($com).'"');
	$count = $db->exec('Update Demo set UpdatedDate=datetime("now") where Job="'.$id.'" and Com="'.strtoupper($com).'"');
    // close the database connection
    $db = NULL;
  }
  catch(PDOException $e)
  {
    //print 'Exception : '.$e->getMessage();
	$response="<error><msg>".$e->getMessage()."</msg></error>";
  }
  if ($count>0) $response="<response><msg>Status Updated</msg></response>"; 
  else  $response="<error><msg> Status was not updated. Ensure job id:".$id." is correct and component:".$com." has been assigned that job.</msg></error>";
 
  return $response;
}

$id=$_GET["id"];
$com=$_GET["com"];
$msg=$_GET["msg"];
$msg=urldecode($msg);  

//echo "id:".$id."<br/>";
//echo "com:".$com."<br/>";
//echo "msg:".$msg."<br/>";

//$st1=setJobStatus($id,$com,$msg);

$st2="";

if (strtolower($msg)=='complete') 
{
	
	$db = new PDO('sqlite:'.BASE_DB_URL.'locTemp.sqlite');
	$res = $db->query('SELECT CurrentStep FROM Project where ID="'.$id.'"');
	$data=(int) $res->fetchColumn();
	$step=(string)$data;
	
	
	$result = $db->query('SELECT Output FROM Demo where job="'.$id.'" and com="'.strtoupper($com).'" and WOrder='.$step);
	$output_com_1=stripslashes($result->fetchColumn());
	
	$step=(string)$data;
	$data=$data+1;
	$nextStep=(string)$data;
	$output_com_2=$output_com_1;	
	//$output_com_2=str_replace('\'','\'\'',$output_com_2);
	$output_com_2=str_replace('"','""',$output_com_2);
	$pattern = '/<\?xml version.*;?>/i';
	$replacement = '';
	$output_com_2=preg_replace($pattern, $replacement, $output_com_2);


	if (strtoupper($com)=='WFR')
	{
	  if (trim($output_com_1)!="")
		{
			$xml=str_replace('=\'\'','$^$',$output_com_1);
			$xml=str_replace('\'\'','\'',$output_com_1);
			$xml=str_replace('$^$','=\'\'',$output_com_1);
			$xliff = new DOMDocument();
			$xliff->loadXML($xml);	
			$xpath = new DOMXPath($xliff);
			$xpath->registerNamespace('a', "urn:oasis:names:tc:xliff:document:1.2");
			$query = '//a:workflow/a:task';
			$tasks = $xpath->query($query);
			$c=0;
			foreach($tasks as $task)
			{
				
				$tool=$task->getAttribute("tool-id");
				$wforder=(int)$task->getAttribute("order");
				if ($step==1) $wforder=$wforder+1; else	$wforder=$wforder+2;
				$statement="INSERT INTO Demo(Job, Com, Status, WOrder) VALUES ('".$id."', '".$tool."','waiting','".(string)$wforder."')";
				//$st2=$st2."<tool>".$statement."</tool>";
				$count = $db->exec($statement);
				if ($wforder>$c) $c=$wforder;
			}
			
			$count = $db->exec('Update Project set MaxSteps='.(string)$c.' where ID="'.$id.'"');
			$st='SELECT Com FROM Demo where job="'.$id.'" and WOrder='.$nextStep;
			$result = $db->query($st);
			$nextCom=$result->fetchColumn();
			
			if ($nextCom!="") 
			{
			$stmt='Update Demo set FileData="'.$output_com_2.'" where Job="'.$id.'" and Com="'.strtoupper($nextCom).'" and WOrder='.$nextStep;
				//$st2=$st2."<com>".$stmt."</com>";
			$count = $db->exec($stmt);
		    // set status as pending
			$count = $db->exec('Update Demo set Status="pending" where Job="'.$id.'" and Com="'.strtoupper($nextCom).'" and WOrder='.$nextStep);
				$count = $db->exec('Update Project set CurrentStep='.$nextStep.' where ID="'.$id.'"');
			} else
			{
			//$st2="<output>".$output_com_2."</output>";
			$count = $db->exec('Update Project set Output="'.$output_com_2.'" where ID="'.$id.'"');
			$count = $db->exec('Update Project set FinishDate=datetime("now") where ID="'.$id.'"');
			$count = $db->exec('Update Project set CurrentStep=0 where ID="'.$id.'"');
			}
			//set status to complete
			$count = $db->exec('Update Demo set Status="complete" where Job="'.$id.'" and Com="'.strtoupper($com).'" and WOrder='.$step);
	$count = $db->exec('Update Demo set UpdatedDate=datetime("now") where Job="'.$id.'" and Com="'.strtoupper($com).'" and WOrder='.$step);
			$xliff=NULL;
			$st2="<response><msg>Status Updated</msg></response>";
		}
		else
		{
		  
		  $stmt='Update Demo set Status="pending" where Job="'.$id.'" and Com="'.strtoupper($com).'" and WOrder='.$step;
			$count = $db->exec($stmt);
			$st2="<error><msg> Output file has to be sent prior to setting the status to complete</msg></error>";
		}
	}
	else
	{
		//print $nextStep;
		$st='SELECT Com FROM Demo where job="'.$id.'" and WOrder='.$nextStep;
		$result = $db->query($st);
		$nextCom=$result->fetchColumn();
		
		if (trim($nextCom)!="")
		{
		  if (trim($output_com_1!=""))
		  {
		    //transfer file from 1st component to next component
			//print 'Update Demo set FileData="'.$output_com_2.'" where Job="'.$id.'" and Com="'.strtoupper($nextCom).'" and WOrder='.$nextStep;
			$count = $db->exec('Update Demo set FileData="'.$output_com_2.'" where Job="'.$id.'" and Com="'.strtoupper($nextCom).'" and WOrder='.$nextStep);
		    // set status as pending
			$count = $db->exec('Update Demo set Status="pending" where Job="'.$id.'" and Com="'.strtoupper($nextCom).'" and WOrder='.$nextStep);
			//print "<all><com>".$nextCom."</com>";
			//set status to complete
		    $count = $db->exec('Update Project set CurrentStep='.$nextStep.' where ID="'.$id.'"');
			$count = $db->exec('Update Demo set Status="complete" where Job="'.$id.'" and Com="'.strtoupper($com).'" and WOrder='.$step);
	$count = $db->exec('Update Demo set UpdatedDate=datetime("now") where Job="'.$id.'" and Com="'.strtoupper($com).'" and WOrder='.$step);
	$st2="<response><msg>Status Updated</msg></response>";
		  }
		  else
		  {
		    // set the status of first component component 'pending'
		
			$stmt='Update Demo set Status="pending" where Job="'.$id.'" and Com="'.strtoupper($com).'" and WOrder='.$step;
			$count = $db->exec($stmt);
			$st2="<error><msg> Output file has to be sent prior to setting the status to complete</msg></error>";
		  }
		} else
		{
		
		//print "<all><com>project complete</com>";
		
		  if (trim($output_com_1!=""))
		  {
		  //project complete
			//update project db
		
			$count = $db->exec('Update Project set Output="'.$output_com_2.'" where ID="'.$id.'"');
			$count = $db->exec('Update Project set FinishDate=datetime("now") where ID="'.$id.'"');
			$count = $db->exec('Update Project set CurrentStep=0 where ID="'.$id.'"');
			
			//set status to complete
			$count = $db->exec('Update Demo set Status="complete" where Job="'.$id.'" and Com="'.strtoupper($com).'" and WOrder='.$step);
	$count = $db->exec('Update Demo set UpdatedDate=datetime("now") where Job="'.$id.'" and Com="'.strtoupper($com).'" and WOrder='.$step);
	$st2="<response><msg>Status Updated</msg></response>";
		  } else
		  {
		    $st2="<error><msg> Output file has to be sent prior to setting the status to complete</msg></error>";
			$count = $db->exec('Update Demo set Status="pending" where Job="'.$id.'" and Com="'.strtoupper($com).'" and WOrder='.$step);
		  }
		 
		}
		
		//print "<order>".$data."</order></all>";
		
	}

$db=NULL;	
} else
{
$st1=setJobStatus($id,$com,$msg);
}

if ($st2!="") print $st2; else print $st1;	
;?>