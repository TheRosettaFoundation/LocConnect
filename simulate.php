<?php
/*------------------------------------------------------------------------*
 * © 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
require_once('./conf.php');
require_once 'HTTP/Request2.php';
 $com=$_POST['com'];
 $id=$_POST['job'];
 $func=$_POST['api'];
 


if ($func!='directjob' )
{
 print "<span style=\"color:red\">SIMULATING ".$com." and Project ID: ".$id." (Right click and view page source to see the LocConnect's response.)</span>\n\n\n";
} else
{
	print "<span style=\"color:red\">PROJECT CREATION BY DIRECT SUBMISSION:(Right click and view page source to see the LocConnect's response.)</span>\n\n\n";;
}
 
if ($func=='status' )
{
 $status=$_POST['status'];
  $res="";
  $request = new HTTP_Request2("http://".$_SERVER['HTTP_HOST'].BASE_URL."/set_status.php");
  $request->setHeader('Accept-Charset', 'utf-8'); 
	$url = $request->getUrl();
	$url->setQueryVariable('com', $com);    
	$url->setQueryVariable('id', $id);      
	$url->setQueryVariable('msg', $status); 
		
	try {
		$response = $request->send();
		if (200 == $response->getStatus()) {
			$res=$response->getBody();
		} else {
			$res='Unexpected HTTP status: ' . $response->getStatus() . ' ' .
				 $response->getReasonPhrase();
		}
	} catch (HTTP_Request2_Exception $e) {
		$res='Error: ' . $e->getMessage();
	}
   
   print $res;	
 
}

if ($func=='feedback' )
{
 $feedback=$_POST['feedback'];
 //print $feedback."<br>"; 
 $res="";
  $request = new HTTP_Request2("http://".$_SERVER['HTTP_HOST'].BASE_URL."/send_feedback.php");
  $request->setHeader('Accept-Charset', 'utf-8'); 
	$url = $request->getUrl();
	$url->setQueryVariable('com', $com);    
	$url->setQueryVariable('id', $id);      
	$url->setQueryVariable('msg', $feedback); 
		
	try {
		$response = $request->send();
		if (200 == $response->getStatus()) {
			$res=$response->getBody();
		} else {
			$res='Unexpected HTTP status: ' . $response->getStatus() . ' ' .
				 $response->getReasonPhrase();
		}
	} catch (HTTP_Request2_Exception $e) {
		$res='Error: ' . $e->getMessage();
	}
   
   print $res;	
 
}

if ($func=='output' )
{
  $filename = $_FILES["output"]["name"];
  $tmpName=$_FILES['output']['tmp_name'];
  $fp      = fopen($tmpName, 'r');
  $data = trim(fread($fp, filesize($tmpName)));
  fclose($fp);
 
  
 $request = new HTTP_Request2("http://".$_SERVER['HTTP_HOST'].BASE_URL."/send_output.php");
 $request->setHeader('Accept-Charset', 'utf-8'); 
 $request->setMethod(HTTP_Request2::METHOD_POST)
    ->addPostParameter('id', $id)
    ->addPostParameter('com', $com)
	->addPostParameter('data', $data);

	try {
		$response = $request->send();
		if (200 == $response->getStatus()) {
			$res=$response->getBody();
		} else {
			$res='Unexpected HTTP status: ' . $response->getStatus() . ' ' .
				 $response->getReasonPhrase();
		}
	} catch (HTTP_Request2_Exception $e) {
		$res='Error: ' . $e->getMessage();
	} 
   
   print $res;	
}


if ($func=='fetch' )
{
 $res="";
  $request = new HTTP_Request2("http://".$_SERVER['HTTP_HOST'].BASE_URL."/fetch_job.php");
  $request->setHeader('Accept-Charset', 'utf-8'); 
	$url = $request->getUrl();
	$url->setQueryVariable('com', $com);    
		
	try {
		$response = $request->send();
		if (200 == $response->getStatus()) {
			$res=$response->getBody();
		} else {
			$res='Unexpected HTTP status: ' . $response->getStatus() . ' ' .
				 $response->getReasonPhrase();
		}
	} catch (HTTP_Request2_Exception $e) {
		$res='Error: ' . $e->getMessage();
	}
   
   print $res;	
}

if ($func=='get' )
{
 $res="";
  $request = new HTTP_Request2("http://".$_SERVER['HTTP_HOST'].BASE_URL."/get_job.php");
  $request->setHeader('Accept-Charset', 'utf-8'); 
	$url = $request->getUrl();
	$url->setQueryVariable('com', $com);    
	$url->setQueryVariable('id', $id);    
		
	try {
		$response = $request->send();
		if (200 == $response->getStatus()) {
			$res=$response->getBody();
		} else {
			$res='Unexpected HTTP status: ' . $response->getStatus() . ' ' .
				 $response->getReasonPhrase();
		}
	} catch (HTTP_Request2_Exception $e) {
		$res='Error: ' . $e->getMessage();
	}
   
   print $res;	
}

if ($func=='directjob' )
{
  $filename = $_FILES["datafile"]["name"];
  $tmpName=$_FILES['datafile']['tmp_name'];
  $fp      = fopen($tmpName, 'r');
  $data = trim(fread($fp, filesize($tmpName)));
  fclose($fp);
 
  
 $request = new HTTP_Request2("http://".$_SERVER['HTTP_HOST'].BASE_URL."/new_project.php");
 $request->setHeader('Accept-Charset', 'utf-8'); 
 $request->setMethod(HTTP_Request2::METHOD_POST)
    ->addPostParameter('com', "COMSIM")
	->addPostParameter('data', $data);

	try {
		$response = $request->send();
		if (200 == $response->getStatus()) {
			$res=$response->getBody();
		} else {
			$res='Unexpected HTTP status: ' . $response->getStatus() . ' ' .
				 $response->getReasonPhrase();
		}
	} catch (HTTP_Request2_Exception $e) {
		$res='Error: ' . $e->getMessage();
	} 
   
   print $res;	
}

print "\n\n";
;?>
<br/><br/>
<a href="./comsim.php?<?php print "lastcom=".$com."&lastid=".$id; ?>" target="_self"> Back to simulator </a>