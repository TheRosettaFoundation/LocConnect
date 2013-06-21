<p>
<?php
/*------------------------------------------------------------------------*
 * © 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
require_once('./conf.php');
 $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE.';port='.DB_PORT, DB_USERNAME, DB_PASS, array());
 $res = $db->query('Select * from Project where  FinishDate is null Order by CreateDate Desc');
 $c=0;
 foreach($res as $row)
 {
  print "<span class='orangetext'><a href='http://".$_SERVER['HTTP_HOST'].BASE_URL."/track.php?id=".$row['ID']."'>".$row['PName']."</a></span><br/>";
  $msg=$row['Desc'];
  if (strlen($msg)>60) $msg=substr($msg,0,60).'..';
  print $msg."<br/>";
  $c=$c+1;
  if ($c>2) break;
 }
 
 $db=NULL;
;?>
</p>
