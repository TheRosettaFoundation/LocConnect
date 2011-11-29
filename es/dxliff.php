<?php
 /*------------------------------------------------------------------------*
 * © 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
		require_once('./conf.php');
            $id=$_GET["id"];
			$com=$_GET["com"];
			$order=$_GET["order"];
			
             $db = new PDO('sqlite:'.BASE_DB_URL.'locTemp.sqlite');
			 $q='SELECT Output FROM Demo where Job="'.$id.'" and Com="'.$com.'" and WOrder='.$order;
			 //print $q;
             $result = $db->query($q);
			 
			 $c=0;
             foreach($result as $row)
             {
			  $c=$c+1;
			  $out=$row['Output'];
             }
			 
			 if ($c>0)
			 {
			   if ($out!=""   )
			   {
				header("Content-Disposition: attachment; filename=".$id."-".$com.".xlf"); 
				header('Content-Type: text/xml; charset=utf-8');
				print trim($out);
			   }
			 } else
			 {
			 print "project ID not found";
			 }
			$db= null;
;?>			 