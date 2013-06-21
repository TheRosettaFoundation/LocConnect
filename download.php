<?php
 /*------------------------------------------------------------------------*
 * © 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
	require_once('./conf.php');
 
            $id=$_GET["id"];
             $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE.';port='.DB_PORT, DB_USERNAME, DB_PASS, array());
             $res = $db->query('select * from Project where  ID="'.$id.'"');
			 $c=0;
             foreach($res as $row)
             {
              $c=$c+1;
              $currentstep=(int)$row['CurrentStep'];
              $finishdate=$row['FinishDate'];
              $pname=$row['PName'];
              $pdesc=$row['Desc'];
			  $out=$row['Output'];
             }
			 
			 if ($c>0)
			 {
			   if ($out!=""   )
			   {
				header("Content-Disposition: attachment; filename=".$id."-final.xlf"); 
				header('Content-Type: text/xml; charset=utf-8');
				print trim($out);
			   }
			 } else
			 {
			 print "project ID not found";
			 }
;?>			 
