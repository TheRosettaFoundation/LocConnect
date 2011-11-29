<?php
 require_once('./conf.php');
 /*------------------------------------------------------------------------*
 * © 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
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

 
 $wf="";
 if ($c>0)
 {
  if ($currentstep==0)
  {
    //print "finised job";
	$result = $db->query('SELECT Com FROM Demo where Job="'.$id.'" order by WOrder ASC ');
	$wf="<span class='grey'>";
	foreach($result as $r)
	{
	 $wf=$wf.$r['Com'];
	 $wf=$wf."&nbsp;->&nbsp;";
	}
	$wf=trim(rtrim($wf,"&nbsp;->&nbsp;"))."</span>";
  } else
  {
   //on going job
    $result = $db->query('SELECT Com FROM Demo where Job="'.$id.'" and WOrder<'.(string)$currentstep.' order by WOrder ASC ');
	$wf1="";
	foreach($result as $r)
	{
	 $wf1=$wf1.$r['Com'];
	 $wf1=$wf1."&nbsp;->&nbsp;";
	}
	if ($wf1!="")	$wf1="<span class='green'>".$wf1."</span>";
	
	
	$wf3="";
	$result = $db->query('SELECT Com FROM Demo where Job="'.$id.'" and WOrder>'.(string)$currentstep.' order by WOrder ASC ');
	
	foreach($result as $r)
	{
	 $wf3=$wf3.$r['Com'];
	 $wf3=$wf3."&nbsp;->&nbsp;";
	}
	if ($wf3!="")	$wf3="<span class='grey'>".trim(rtrim($wf3,"&nbsp;->&nbsp;"))."</span>";
    
	$wf2="";
	$result = $db->query('SELECT Com FROM Demo where Job="'.$id.'" and WOrder='.(string)$currentstep.' order by WOrder ASC ');
	foreach($result as $r)
	{
	 $wf2=$wf2.$r['Com'];
	}
	if ($wf2!="" and $wf3!="")	$wf2="<span class='red'>".$wf2."&nbsp;->&nbsp;</span>";
	if ($wf2!="" and $wf3=="")	$wf2="<span class='red'>".$wf2."</span>";
    
	
	
	$wf=$wf1.$wf2.$wf3;
  }
  
  
 } else
 {
	$wf="project does not exist";
 }

 //print $wf;
 
 /* added on 04-10-2010*/
 //print htmlentities($wf);
 $str=$wf;

$rep1 ='<td><img style="width: 100px; height: 101px;" alt="LKR" src="images/';
$rep2='.png"></td>';


$re1 ='<td><img style="width: 48px; height: 48px;" alt="LKR" src="images/';
$re2='.png"></td>';


$pattern="/\<span class\=\'green\'\>(.*?)\<\/span\>/";
if (preg_match($pattern, $str, $matches)) 
   {
    $temp1=$matches[0];
	//$components = preg_split("/&nbsp\;\-\&gt\;\&nbsp\;/", $temp);
	$temp1=preg_replace("/LKR/", $rep1."LKR-green".$rep2, $temp1);
	$temp1=preg_replace("/WFR/", $rep1."WFR-green".$rep2, $temp1);
	$temp1=preg_replace("/RT/", $rep1."RT-green".$rep2, $temp1);
	$temp1=preg_replace("/MT/", $rep1."MT-green".$rep2, $temp1);
	$temp1=preg_replace("/LMC/", $rep1."LMC-green".$rep2, $temp1);
	$temp1=preg_replace("/&nbsp;\->&nbsp;/", $re1."next".$re2, $temp1);
  }
  
  
$pattern="/\<span class\=\'grey\'\>(.*?)\<\/span\>/";
if (preg_match($pattern, $str, $matches)) 
   {
    $temp2=$matches[0];
	//$components = preg_split("/&nbsp\;\-\&gt\;\&nbsp\;/", $temp);
	$temp2=preg_replace("/LKR/", $rep1."LKR-grey".$rep2, $temp2);
	$temp2=preg_replace("/LMC/", $rep1."LMC-grey".$rep2, $temp2);
	$temp2=preg_replace("/WFR/", $rep1."WFR-grey".$rep2, $temp2);
	$temp2=preg_replace("/RT/", $rep1."RT-grey".$rep2, $temp2);
	$temp2=preg_replace("/MT/", $rep1."MT-grey".$rep2, $temp2);
	$temp2=preg_replace("/&nbsp;\->&nbsp;/", $re1."next-grey".$re2, $temp2);
  }

$pattern="/\<span class\=\'red\'\>(.*?)\<\/span\>/";
if (preg_match($pattern, $str, $matches)) 
   {
    $temp3=$matches[0];
	//$components = preg_split("/&nbsp\;\-\&gt\;\&nbsp\;/", $temp);
	$temp3=preg_replace("/LKR/", $rep1."LKR-red".$rep2, $temp3);
	$temp3=preg_replace("/WFR/", $rep1."WFR-red".$rep2, $temp3);
	$temp3=preg_replace("/RT/", $rep1."RT-red".$rep2, $temp3);
	$temp3=preg_replace("/MT/", $rep1."MT-red".$rep2, $temp3);
	$temp3=preg_replace("/LMC/", $rep1."LMC-red".$rep2, $temp3);
	$temp3=preg_replace("/&nbsp;\->&nbsp;/", $re1."next-red".$re2, $temp3);
  }
  
  print "<table><tr>".$temp1.$temp3.$temp2."</tr></table>";
 
 
 $db=NULL;
;?>