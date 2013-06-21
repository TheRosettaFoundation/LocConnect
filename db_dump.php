<?php
  header('Content-Type: text/html; charset=utf-8'); 
  /*------------------------------------------------------------------------*
 * © 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CNLF Server Stats</title>
<style type="text/css">
table.sample {
	border-width: 0px;
	border-spacing: 3px;
	border-style: outset;
	border-color: gray;
	border-collapse: collapse;
	background-color: rgb(255, 255, 240);
}
table.sample th {
	border-width: 1px;
	padding: 4px;
	border-style: inset;
	border-color: gray;
	background-color: rgb(255, 255, 240);
	-moz-border-radius: 3px 3px 3px 3px;
}
table.sample td {
	border-width: 1px;
	padding: 4px;
	border-style: inset;
	border-color: gray;
	background-color: rgb(255, 255, 240);
	-moz-border-radius: 3px 3px 3px 3px;
}
</style>
</head>
<body>
 <?php  
 require_once('./conf.php');
  try
  {
    //open the database
    $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE.';port='.DB_PORT, DB_USERNAME, DB_PASS, array());

   
    //now output the data to a simple html table...
    print "<table class='sample'>";
    print "\n<tr>\n\t<td>Job</td>\n\t<td>Com</td>\n\t<td>File Content</td>\n\t<td> Status </td>\n\t<td>Feedback</td>\n\t<td>Output</td></tr>\n";
    $result = $db->query('SELECT * FROM Demo order by Job');
    foreach($result as $row)
    {
	
	 $job=$row['Job'];
	 $com=$row['Com'];
      print "\n<tr>\n\t<td>".$job."</td>\n";
      print "\t<td>".$com."</td>\n";
      print "\t<td><a href='http://".$_SERVER['HTTP_HOST'].BASE_URL."/show_job.php?type=fd&id=".$job."&com=".$com."'>".htmlspecialchars(substr($row['FileData'],0,30), ENT_QUOTES, "UTF-8")."..</a></td>\n";
      print "\t<td>".$row['Status']."</td>\n";
	  print "\t<td>".$row['Feedback']."</td>\n";
	  print "\t<td><a href='http://".$_SERVER['HTTP_HOST'].BASE_URL."/show_job.php?type=output&id=".$job."&com=".$com."'>".htmlspecialchars(substr($row['Output'],0,30), ENT_QUOTES, "UTF-8")."..</a></td>\n</tr>\n";
    }
    print "</table>\n";

    // close the database connection
    $db = NULL;
  }
  catch(PDOException $e)
  {
    print 'Exception : '.$e->getMessage();
  }
;?>
</body>
</html>
