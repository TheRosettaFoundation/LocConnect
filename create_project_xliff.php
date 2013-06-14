<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <?php
 /*------------------------------------------------------------------------*
 * � 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
	require_once('./conf.php');
  ;?>
  <meta http-equiv="Content-Type"
 content="text/html; charset=utf-8" />
  <title><?php print BASE_TITLE ;?></title>
  <link href="css/style.css" rel="stylesheet"
 type="text/css" />
  <link type="text/css"
 href="css/ui-lightness/jquery-ui-1.8.4.custom.css"
 rel="stylesheet" />
  <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
  <script type="text/javascript"
 src="js/jquery-ui-1.8.4.custom.min.js"></script>
  <script type="text/javascript">
$(function() {
$("#datepicker").datepicker();
});
$(function() {
$("#datepicker1").datepicker();
});
  </script>
</head>
<body>
<div id="wrapper">
<div id="content">
<div id="header"> <h4 class="lang"><?php $i=0; foreach($languages as $code => $svrpath) {    $i++;    print '<a href="'.$svrpath.'/'.curPageName().'" >'.$code.'</a>';
	if ($i<count($languages)) print " | "; }; ?> </h4>
<div id="logo">
 <h1><?php print BASE_LOCCONNECT;?></h1>
 <h4><?php print BASE_MOTO;?></h4>
</div>
<div id="links">
<ul>
 <li> <a href="./index.php"><?php print BASE_HOME;?></a> </li>
			<li> <a href="./prompt.php"><?php print BASE_NEW_PROJECT;?></a> </li>
			<li> <a href="./trackproj.php"><?php print BASE_TRACK_PROJECTS;?></a></li>
			<li> <a href="./about.php"><?php print  BASE_ABOUT;?></a> </li>
</ul>
</div>
</div>
<div id="mainimg">
	 <h3><?php print  BASE_H1;?></h3>
		<h4><?php print  BASE_H2;?></h4>
</div>
<div id="contentarea" class="normaltext">


<?php
require_once 'HTTP/Request2.php';
function sendResource($id, $type, $metdata, $desc, $content)
{
    $res="";
	$request = new HTTP_Request2("http://".$_SERVER['HTTP_HOST'].BASE_URL."/send_resource.php");
	$data = $content;
	$request->setMethod(HTTP_Request2::METHOD_POST)
		->addPostParameter('id', $id)
		->addPostParameter('type', $type)
		->addPostParameter('data', $content)
		->addPostParameter('metadata', $metdata)
		->addPostParameter('desc', $desc);
			
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
	
	return $res;
}

        $allowed_filetypes = array('.xlf'); // These will be the types of file that will pass the validation.	  
	$allowed_filetypes1 = array('.lmc',''); // These will be the types of file that will pass the validation.	  
        $max_filesize = 524288; // Maximum filesize in BYTES (currently 0.5MB).
        $upload_path = BASE_UPLOAD_PATH; // The place the files will be uploaded to
        $filename = $_FILES["source_xliff_file"]["name"]; // Get the name of the file (including file extension).
	$filename1 = $_FILES["lmc_file"]["name"]; // Get the name of the file (including file extension).
        
	$ext = substr($filename, strrpos($filename,'.'), strlen($filename)-1); // Get the extension from the filename.
	$ext1 = substr($filename1, strrpos($filename1,'.'), strlen($filename1)-1); // Get the extension from the filename.
	
	
	$project_name=$_POST['project_name'];
	$project_desc=$_POST['project_description'];
        if(isset ($_POST['domain']))$domain=$_POST['domain'];
	$start_date=$_POST['start_date'];
	$deadline=$_POST['deadline'];
	$budget=$_POST['budget'];
	$quality=strtoupper($_POST['Quality']);
	$client=strtoupper($_POST['client']);
	
	$mt=strtoupper($_POST['MT']);
	$sourceValidation=strtoupper($_POST['SourceValidation']);
    $useTA = strtoupper($_POST['useTA']);
    $useTP = strtoupper($_POST['useTP']);
	

   // Check if the filetype is allowed, if not DIE and inform the user.
   
   if ($ext!="") 
   {
   
   if(!in_array($ext,$allowed_filetypes))
      die(BASE_CP_SOURCEERR);
 
   // Now check the filesize, if it is too large then DIE and inform the user.
   if(filesize($_FILES['source_xliff_file']['tmp_name']) > $max_filesize)
      die(BASE_CP_SOURCEERR_LARGE);
	  
   if(!in_array($ext1,$allowed_filetypes1))
      die(BASE_CP_RESERR);
 
   // Now check the filesize, if it is too large then DIE and inform the user.
   if(filesize($_FILES['lmc_file']['tmp_name']) > $max_filesize)
      die(BASE_CP_RESERR_LARGE);
 
   // Check if we can upload to the specified path, if not DIE and inform the user.
   if(!is_writable($upload_path))
      die(BASE_CP_UPLOADERR);


   // Upload the file to your specified path.

    $tmpName=$_FILES['source_xliff_file']['tmp_name'];
    $fp      = fopen($tmpName, 'r');
    $content = fread($fp, filesize($tmpName));
    fclose($fp);


    $tmpName1=$_FILES['lmc_file']['tmp_name'];
    if ($tmpName1)
    {
        $fp      = fopen($tmpName1, 'r');
        $content1 = fread($fp, filesize($tmpName1));
        $content1=str_replace('\'','\'\'',$content1);
        $content1=str_replace('\"','\"\"',$content1);
        fclose($fp);
        $pattern = '/<\?xml version.*;?>/i';
        $replacement = '';
        $content1=preg_replace($pattern, $replacement, $content1);
    }

    /* first XLIFF part goes here */

    //XLIFF Processing Goes here
    $xliff = new DOMDocument();
    $xliff->loadXML( $content);	
    
    $xliffNode = $xliff->getElementsByTagName("xliff")->item(0);
    $xliffVersion = $xliffNode->getAttribute("version");

    $is_resource_attached=0;
    //generate project id;
    $project_ID="";
    $id="";
		
    $db = new PDO('sqlite:'.BASE_DB_URL.'locTemp.sqlite');
    while (($project_ID==$id) || ($project_ID==""))
    {		
        $project_ID= substr(md5(uniqid()), 0,10);	 
        $result = $db->query("SELECT Job FROM Demo where job='".$project_ID."'");
        $id=$result->fetchColumn();
    };
    $db=null;	

    if ($xliffVersion == "2.0") {
        $mda = $xliffNode->getAttribute('xmlns:mda');
        if ($mda == '') {
            $xliffNode->setAttribute('xmlns:mda', "urn:oasis:names:tc:xliff:metadata:2.0");
        }
    }
		
    //upload resource
    $lmc="NO";
    if ($tmpName1)
    {
        if(move_uploaded_file($tmpName1,$upload_path . $filename1)){
            $resID=sendResource($project_ID, 'lmc', 'domain:test', 'Test file', $content1);
            $is_resource_attached=1;
            $resID=str_replace('<resource><msg>','',$resID);
            $resID=str_replace('</msg></resource>','',$resID);
            $resID=trim($resID);
            $lmc="YES";

            if ($xliffVersion == "2.0") {
                $files = $xliff->getElementsByTagName('file');
                foreach ($files as $file) {
                    if ($file->getElementsByTagName("pmui-data")->length > 0) {
                        $pmuiData = $file->getElementsByTagName("pmui-data")->item(0);
                    } else {
                        $pmuiData = $file->createElement('pmui-data');
                    }
                    $ref=$xliff->createElement('reference');
                    $ref1=$xliff->createElement('external-file');
                    $ref1->setAttribute("href","http://".$_SERVER['SERVER_ADDR'].BASE_URL."/get_resource.php?id=".$resID);
                    $ref->appendChild($ref1);
                    $pmuiData->appendChild($ref);
                    $file->appendChild($pmuiData);
                }
            } else {
                $headers = $xliff->getElementsByTagName( 'header' );
//            if($headers->lenght==0){// creat a header element if it dose not exist
//               $fileElement = $xliff->getElementsByTagName( 'file' )->item(0);
//               $header=$xliff->createElement('header');
//               $fileElement->appendChild($header);
//               $headers = $xliff->getElementsByTagName( 'header' );
//            }
                foreach( $headers as $header )
                {
                    $ref=$xliff->createElement('reference');
                    $ref1=$xliff->createElement('external-file');
                    $ref1->setAttribute("href","http://".$_SERVER['SERVER_ADDR'].BASE_URL."/get_resource.php?id=".$resID);
                    $ref->appendChild($ref1);
                    $header->appendChild($ref);
                }
            }
        } else {
            echo BASE_CP_UPLOADERR_RES; // It failed :(.
        }
    }	

   
    if(move_uploaded_file($tmpName,$upload_path . $filename)){ 
     /* XML processing goes here */

        if ($xliffVersion == "2.0") {
            $files = $xliff->getElementsByTagName('file');
            foreach ($files as $file) {
                $metadata = $file->getElementsByTagName('mda:metadata');
                if ($metadata->length < 1) {
                    $metadata = $file->getElementsByTagName('metadata');
                }

                if ($metadata->length > 0) {
                    $metadata = $metadata->item(0);
                } else {
                    $metadata = $xliff->createElement('mda:metadata');
                    $unit = $file->getElementsByTagName('unit')->item(0);
                    $file->insertBefore($metadata, $unit);
                }

                $xpath = new DOMXPath($xliff);
                $pmuiData = $xpath->query("//*[local-name() = 'metagroup'][@category='pmui-data']");

                if ($pmuiData->length > 0) {
                    $pmuiData = $pmuiData->item(0);
                } else {
                    $pmuiData = $xliff->createElement('mda:metagroup');
                    $pmuiData->setAttribute('category', 'pmui-data');
                    $metadata->appendChild($pmuiData);
                }
                $element = $xliff->createElement('mda:meta', $project_name);
                $element->setAttribute('type', 'pname');
                $pmuiData->appendChild($element);
                $element = $xliff->createElement('mda:meta', $project_desc);
                $element->setAttribute('type', 'pdescription');
                $pmuiData->appendChild($element);
                $element = $xliff->createElement('mda:meta', $start_date);
                $element->setAttribute('type', 'startdate');
                $pmuiData->appendChild($element);
                $element = $xliff->createElement('mda:meta', $deadline);
                $element->setAttribute('type', 'deadline');
                $pmuiData->appendChild($element);
                $element = $xliff->createElement('mda:meta', $budget);
                $element->setAttribute('type', 'budget');
                $pmuiData->appendChild($element);
                $element = $xliff->createElement('mda:meta', $quality);
                $element->setAttribute('type', 'qrequirement');
                $pmuiData->appendChild($element);
                $element = $xliff->createElement('mda:meta', $mt);
                $element->setAttribute('type', 'use-mt');
                $pmuiData->appendChild($element);
                $element = $xliff->createElement('mda:meta', $client);
                $element->setAttribute('type', 'client');
                $pmuiData->appendChild($element);
                $element = $xliff->createElement('mda:meta', $sourceValidation);
                $element->setAttribute('type', 'lkr');
                $pmuiData->appendChild($element);
                $element = $xliff->createElement('mda:meta', $useTA);
                $element->setAttribute('type', 'ta');
                $pmuiData->appendChild($element);
                $element = $xliff->createElement('mda:meta', $useTP);
                $element->setAttribute('type', 'tp');
                $pmuiData->appendChild($element);
                $element = $xliff->createElement('mda:meta', $lmc);
                $element->setAttribute('type', 'lmc');
                $pmuiData->appendChild($element);
            }
        } else {
            $headers = $xliff->getElementsByTagName( 'header' );
        
            if($headers==null||$headers->length == 0){// creat a header element if it dose not exist
                $fileElement = $xliff->getElementsByTagName( 'file' )->item(0);
                $header=$xliff->createElement('header');
                $fileElement->appendChild($header);
                $headers = $xliff->getElementsByTagName( 'header' );
            }

            foreach( $headers as $header )
            {
                $ref=$xliff->createElement('reference');
                $ref1=$xliff->createElement('internal-file');
                $ref2=$xliff->createElement('pmui-data');
                $ref2->setAttribute("pname", $project_name);
                $ref2->setAttribute("pdescription", $project_desc);
                $ref2->setAttribute("startdate", $start_date);
                $ref2->setAttribute("deadline", $deadline);
                $ref2->setAttribute("budget", $budget);
                $ref2->setAttribute("qrequirement", $quality);
                $ref2->setAttribute("use-mt", $mt);
                $ref2->setAttribute("client", $client);
                $ref2->setAttribute("lkr", $sourceValidation);
                $ref2->setAttribute("lmc", $lmc);
                $ref2->setAttribute("ta", $useTA);
                $ref2->setAttribute("tp", $useTP);
                $ref1->appendChild($ref2);
                $ref->appendChild($ref1);
                $header->appendChild($ref);
            }
        }

        $content=html_entity_decode($xliff->saveXML(),  ENT_QUOTES, 'UTF-8');
        $content=str_replace('\'','\'\'',$content);
        $content=str_replace('\"','\"\"',$content);
        $pattern = '/<\?xml version.*;?>/i';
        $replacement = '';
        $content=preg_replace($pattern, $replacement, $content);
        //$content=mysql_real_escape_string($content);
        //print $content;

        $desc=$project_desc;
        $desc=str_replace('\'','',$desc);
        $desc=str_replace('"','',$desc);

        $pname=$project_name;
        $pname=str_replace('\'','\'\'',$pname);
        $pname=str_replace('"','""',$pname);

         /* XML processing end */
        
         $statement1="INSERT INTO Demo(Job, FileData, Com, Status, WOrder) VALUES ('".$project_ID."', '".trim($content)."','WFR','pending',1)";
         $statement3="INSERT INTO Project(ID, Desc, CreateDate, MaxSteps, CurrentStep, PName, filename) VALUES ('".$project_ID."', '".$desc."',datetime('now'),100,1,'".$pname."', '".$filename."')";
         

         try
         {
             $db = new PDO('sqlite:'.BASE_DB_URL.'locTemp.sqlite');
             $count = $db->exec($statement1);
             if($count==FALSE) die("<p>SQL query: <p>".$statement1."  ... failed");
             $count = $db->exec($statement3);
             if($count==FALSE) die("<p>SQL query: <p>".$statement3."  ... failed");
             $db= null;
         }catch(PDOException $e)
         {
            print 'Exception : '.$e->getMessage();
         }
         print "<h2>".BASE_CP_SUCCESS."</h2>";
         print BASE_CP_SUCCESS_M1; 
         print BASE_CP_SUCCESS_M2."<strong>".$project_ID."</strong><br/>";
         print BASE_CP_SUCCESS_M3."<a href='http://".$_SERVER['HTTP_HOST'].BASE_URL."/track.php?id=".$project_ID."'>".BASE_CP_SUCCESS_M4."</a><br>";
         //echo $content;
         if ($is_resource_attached) {
            print BASE_CP_SUCCESS_M5.$resID; 
            print "<br>"; }
         }// It worked.
        else print BASE_CP_UPLOADERR_SRC; // It failed :(.
  } else
  
  {
      die(BASE_CP_UPLOADERR_SRC);
  }
;?>

</div>
<div id="bottom">
<div id="email"><a href="mailto:<?php print BASE_EMAIL;?>"><?php print  BASE_EMAIL;?></a></div>
<div id="validtext">
<p>Valid <a href="http://validator.w3.org/check?uri=referer">XHTML</a>
| <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a></p>
</div>
</div>
</div>
</div>
</body>
</html>
