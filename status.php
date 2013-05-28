<?php
/*------------------------------------------------------------------------*
 * © 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
require_once('./conf.php');
$id=$_GET["id"];
 
 $db = new PDO('sqlite:'.BASE_DB_URL.'locTemp.sqlite');
 $res = $db->query('select * from Project where  ID="'.$id.'"');
 $c=0;
 foreach($res as $row)
 {
  $c=$c+1;
  $currentstep=(int)$row['CurrentStep'];
  $finishdate=$row['FinishDate'];
 }

if ($c>0)
{
 if ($finishdate!="" or $currentstep==0)
 {
  print "<span class='txt'>".BASE_T_PF.$finishdate.". &nbsp;<a href='http://".$_SERVER['HTTP_HOST'].BASE_URL."/download.php?id=".$id."'>".BASE_T_DXLIFF."</a>".BASE_T_ORCON."<a href='http://".$_SERVER['HTTP_HOST'].BASE_URL."/xlfview.php?id=".$id."'>".BASE_T_POST."</a>".BASE_T_INL."</span>";
 } else
 {
   	$result = $db->query('SELECT Com, Feedback, Status FROM Demo where Job="'.$id.'" and WOrder='.(string)$currentstep.' order by WOrder ASC ');
	
	print "<span class='txt'>".BASE_T_CSTATUS."</span>&nbsp;";
	foreach($result as $r)
	{
	 print "<span class='com'>".$arr[$r['Com']]."</span>&nbsp;-&nbsp";
	 print "<span class='status'>(".$st[strtoupper(substr($r['Status'],0,1)).strtolower(substr($r['Status'],1,strlen($r['Status'])))].")</span> <br/>";
	 if ($r['Feedback']!="") print "<div class='feedback'>".$r['Feedback']."</div>";
	}
 }
 
 
} else
{
 die("Project does not exist.");
}
 $db =NULL;
;?>
