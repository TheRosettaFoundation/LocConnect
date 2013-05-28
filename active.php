<table class="txt" style="text-align: left;" border="0"
 cellpadding="0" cellspacing="5">
  <tbody>
<?php
/*------------------------------------------------------------------------*
 * © 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
 require_once('./conf.php');
 $db = new PDO('sqlite:'.BASE_DB_URL.'locTemp.sqlite');
 $res = $db->query('Select * from Project where  FinishDate is null Order by CreateDate Desc');
 $c=0;
 foreach($res as $row)
 {
  print "<tr><td style='color:#000000; border-right:1px solid #dddddd; padding-right:10px;'>".strtoupper($row['PName']). "</td>";
  $msg=$row['Desc'];
  if (strlen($msg)>15) $msg=substr($msg,0,15).'..';
  print "<td><em>".$msg."</em></td>";
  print "<td><a href='http://".$_SERVER['HTTP_HOST'].BASE_URL."/track.php?id=".$row['ID']."'>".BASE_TP_TRACK."</a> </td>";
  print "<td><a class='class2' onclick=\"return confirm('".BASE_TP_CONFIRM."')\" href='http://".$_SERVER['HTTP_HOST'].BASE_URL."/delete.php?id=".$row['ID']."'>".BASE_TP_DELETE."</a> </td></tr>";
  $c=$c+1;
  if ($c>10) break;
 }
 
 $db=NULL;
;?>
</tbody>
</table>
