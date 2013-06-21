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
 }
 
if ($c>0)
{
 if ($currentstep>1 )
 {
 
;?>
<h2 class="orange"> <?php print  BASE_T_STO;?> </h2>
<table class="log"  border="0" cellpadding="0" cellspacing="0">
  <tbody>
  <tr>
  <td width="300px" style="text-decoration:underline; font-weight:bold; color:#000000;"><?php print  BASE_T_COM;?> </td>
  <td width="200px" style="text-decoration:underline;  font-weight:bold;color:#000000;"><?php print  BASE_T_PICKED;?></td>
  <td width="200px" style="text-decoration:underline; font-weight:bold;color:#000000;"><?php print  BASE_T_OUTON;?></td>
  <td width="150px" style="text-decoration:underline; font-weight:bold;color:#000000;"><?php print  BASE_T_OUTPUT;?></td>
    </tr>
<?php
$result = $db->query('SELECT Com, PickDate, UpdatedDate, WOrder FROM Demo where Job="'.$id.'" and WOrder<'.(string)$currentstep.' order by WOrder ASC ');
	
	foreach($result as $r)
	{
	 print "<tr>\n";
	 print "<td>".$arr[$r['Com']]."</td>\n";
	 print "<td>".$r['PickDate']."</td>\n";
	 print "<td>".$r['UpdatedDate']."</td>\n";
	 print "<td> <a href='http://".$_SERVER['HTTP_HOST'].BASE_URL."/dxliff.php?id=".$id."&com=".$r['Com']."&order=".$r['WOrder']."'>".BASE_TP_DOWNLOAD."</a> &nbsp; <a target='_blank' href='http://".$_SERVER['HTTP_HOST'].BASE_URL."/xview.php?id=".$id."&com=".$r['Com']."&order=".$r['WOrder']."'>".BASE_T_VIEW."</a</td>\n";
	 print "</tr>\n";
	}
 } else 
 {
 if ($currentstep!=1)
 {
;?>
<h2 class="orange"> Status & Outputs </h2>
<table class="log"  border="0" cellpadding="0" cellspacing="0">
  <tbody>
  <tr>
     <td width="300px" style="text-decoration:underline; font-weight:bold; color:#000000;"><?php print  BASE_T_COM;?> </td>
  <td width="200px" style="text-decoration:underline;  font-weight:bold;color:#000000;"><?php print  BASE_T_PICKED;?></td>
  <td width="200px" style="text-decoration:underline; font-weight:bold;color:#000000;"><?php print  BASE_T_OUTON;?></td>
  <td width="150px" style="text-decoration:underline; font-weight:bold;color:#000000;"><?php print  BASE_T_OUTPUT;?></td>
    </tr>
<?php 
 $result = $db->query('SELECT Com, PickDate, UpdatedDate, WOrder FROM Demo where Job="'.$id.'" order by WOrder ASC ');
	foreach($result as $r)
	{
	 print "<tr>\n";
	 print "<td>".$arr[$r['Com']]."</td>\n";
	 print "<td>".$r['PickDate']."</td>\n";
	 print "<td>".$r['UpdatedDate']."</td>\n";
	 print "<td> <a href='http://".$_SERVER['HTTP_HOST'].BASE_URL."/dxliff.php?id=".$id."&com=".$r['Com']."&order=".$r['WOrder']."'>".BASE_TP_DOWNLOAD."</a> &nbsp; <a target='_blank' href='http://".$_SERVER['HTTP_HOST'].BASE_URL."/xview.php?id=".$id."&com=".$r['Com']."&order=".$r['WOrder']."'>".BASE_T_VIEW."</a</td>\n";
	 print "</tr>\n";
	}
}

;?>

<?php 
 }
} else die("Project Not Found.");
  $db=NULL;
;?> 
  </tbody>
</table>

