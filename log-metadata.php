<?php
/*------------------------------------------------------------------------*
 * © 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
require_once('./conf.php');
require_once('./lib/IParser.class.php');
function showData($id,$com, $order)
{
		 $db = new PDO('sqlite:'.BASE_DB_URL.'locTemp.sqlite');
	$q='SELECT Output FROM Demo where Job="'.$id.'" and Com="'.$com.'" and WOrder='.$order;

    $result = $db->query($q);

	$c=0;
    foreach($result as $row)
    {
	$c=$c+1;
	$out=$row['Output'];
    }

	if ($c>0)
	{
	   if ($out!="") $out=trim($out);
	} else die("project ID not found");

	//print $out;

    $parser = IParser::getParser($out);
    $parser->printMetaData();
    
	$db=NULL;
	return "";
}
 
 
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
 if ($currentstep>1 )
 {
 
$result = $db->query('SELECT Com, PickDate, UpdatedDate, WOrder FROM Demo where Job="'.$id.'" and WOrder<'.(string)$currentstep.' order by WOrder ASC ');
	foreach($result as $r)
	{
	print '<center> <a href="#" id="meta"><h2>'.$arr[$r['Com']].'</h2> </a></center>';
	 //print "<br>".$id."&com=".$r['Com']."&order=".$r['WOrder'];
	 showData($id, $r['Com'],$r['WOrder']);
	}
 } else 
 {
 if ($currentstep!=1)
 {
 $result = $db->query('SELECT Com, PickDate, UpdatedDate, WOrder FROM Demo where Job="'.$id.'" order by WOrder ASC ');
	
	foreach($result as $r)
	{
	 //print "<br>".$id."&com=".$r['Com']."&order=".$r['WOrder'];
	 print '<center> <a href="#" id="meta"><h2>'.$arr[$r['Com']].'</h2> </a></center>';
	 showData($id, $r['Com'],$r['WOrder']);
	}
}
 }
} else die("Project Not Found.");
  $db=NULL;
;?> 
  </tbody>
</table>

