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
<h2 class="orange"> Log </h2>
<table class="log"  border="0" cellpadding="0" cellspacing="0">
  <tbody>
  <tr>
      <td width="300px" style="text-decoration:underline; font-weight:bold; color:#000000;"><?php print  BASE_T_COM;?></td>
      <td width="500px" style="text-decoration:underline;  font-weight:bold;color:#000000;"><?php print  BASE_T_FB;?></td>
   </tr>
<?php
$result = $db->query('SELECT Com, Feedback FROM Demo where Job="'.$id.'" and WOrder<'.(string)$currentstep.' order by WOrder ASC ');
	foreach($result as $r)
	{
	 print "<tr>\n";
	 print "<td>".$arr[$r['Com']]."</td>\n";
	 print "<td>".$r['Feedback']."</td>\n";
	 print "</tr>\n";
	}
 } else 
 {
 if ($currentstep!=1)
 {
;?>
<h2 class="orange"> Log </h2>
<table class="log"  border="0" cellpadding="0" cellspacing="0">
  <tbody>
  <tr>
     <td width="300px" style="text-decoration:underline; font-weight:bold; color:#000000;"><?php print  BASE_T_COM;?></td>
      <td width="500px" style="text-decoration:underline;  font-weight:bold;color:#000000;"><?php print  BASE_T_FB;?></td>
    </tr>
<?php 
 $result = $db->query('SELECT Com, Feedback FROM Demo where Job="'.$id.'" order by WOrder ASC ');
	foreach($result as $r)
	{
	 print "<tr>\n";
	 print "<td>".$arr[$r['Com']]."</td>\n";
	 print "<td>".$r['Feedback']."</td>\n";
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

