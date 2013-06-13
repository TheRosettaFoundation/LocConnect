<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<?php
/*------------------------------------------------------------------------*
 * � 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
require_once('./conf.php');
;?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php print BASE_TITLE ;?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.4.custom.min.js"></script>
<script type="text/javascript">
$(function() {
$("#datepicker").datepicker();
});
$(function() {
$("#datepicker1").datepicker();
});
</script>
</head>
<body>
<div id="wrapper">
<div id="content">
<div id="header"> <h4 class="lang"><?php $i=0; foreach($languages as $code => $svrpath) {    $i++;    print '<a href="'.$svrpath.'/'.curPageName().'" >'.$code.'</a>';
	if ($i<count($languages)) print " | "; }; ?> </h4>
<div id="logo">
<h1><?php print BASE_LOCCONNECT;?></h1>
<h4><?php print BASE_MOTO;?></h4>
</div>
<div id="links">
<ul>
<li> <a href="./index.php"><?php print BASE_HOME;?></a> </li>
<li> <a href="./prompt.php"><?php print BASE_NEW_PROJECT;?></a> </li>
<li> <a href="./trackproj.php"><?php print BASE_TRACK_PROJECTS;?></a></li>
<li> <a href="./about.php"><?php print  BASE_ABOUT;?></a> </li>
</ul>
</div>
</div>
<div id="mainimg">
<h3><?php print  BASE_H1;?></h3>
<h4><?php print  BASE_H2;?></h4>
</div>
<div id="contentarea">
<div id="leftbar">
<h2><?php print  BASE_PMUI_CREATE_PROJECT;?></h2>
<form target="_self" enctype="multipart/form-data" method="post" action="./create_project_xliff.php" name="pmui">
<table class="normaltext" style="text-align: left; width: 537px; height: 370px;" border="0" cellpadding="2" cellspacing="2">
<tbody>
<tr>
<td style="width: 202px;"><?php print  BASE_PMUI_PNAME;?></td>
<td style="width: 315px;"><input value="<?php if (BASE_DEF_VAL=='ON') print  "Test Project - ".date('l \\t\h\e jS');?>" maxlength="80" size="40" name="project_name" /></td>
</tr>
<tr>
<td style="width: 202px;"><?php print  BASE_PMUI_PDESC;?></td>
<td style="width: 315px;"><textarea cols="40" rows="3" name="project_description"><?php if (BASE_DEF_VAL=='ON') print date(DATE_RFC822); ?></textarea></td>
</tr>
<tr>
<td style="width: 202px;"><?php print  BASE_PMUI_PSTDT;?></td>
<td style="width: 315px;">
<div class="demo"><input name="start_date" id="datepicker" type="text" value="<?php if (BASE_DEF_VAL=='ON') print  date("d/m/Y");?>"/></div>
</td>
</tr>
<tr>
<td style="width: 202px;"><?php print  BASE_PMUI_PDEAD;?></td>
<td style="width: 315px;">
<div class="demo"><input name="deadline" id="datepicker1" type="text" value="<?php $tomorrow = strtotime('+10 day'); if (BASE_DEF_VAL=='ON') print date('d/m/Y', $tomorrow);?>" /></div>
</td>
</tr>
<tr>
<td style="width: 202px;"><?php print  BASE_PMUI_PBUDG;?></td>
<td style="width: 315px;"><input value="<?php if (BASE_DEF_VAL=='ON') print '1000';?>" maxlength="40" size="40" name="budget" /></td>
</tr>
<tr>
<td style="width: 202px;"><?php print  BASE_PMUI_PQAUL;?></td>
<td style="width: 315px;">
<select name="Quality"><option selected="selected" value="High">High</option><option>Medium</option><option>Low</option></select>
</td>
</tr>

<tr>
<td style="width: 202px;"><?php print  BASE_PMUI_CLIENT;?></td>
<td style="width: 315px;">
<select name="client"><option selected="selected" value="Symantec">Symantec</option><option>Other</option></select>
</td>
</tr>

<tr>
<td style="width: 202px;"><?php print  BASE_PMUI_PMT;?></td>
<td style="width: 315px;"><input name="MT" value="Yes" type="radio" checked />Yes <input name="MT" value="No" type="radio" />No</td>
</tr>
<tr>
<td style="width: 202px;"><?php print  BASE_PMUI_PRT;?></td>
<td style="width: 202px;"><input name="SourceValidation" value="Yes" type="radio" checked />Yes<input name="SourceValidation" value="No" type="radio" /> No</td>
</tr>
<tr>
<td style="width: 202px;">Use TA</td>
<td style="width: 202px;">
    <input name="useTA" value="Yes" type="radio" checked />Yes
    <input name="useTA" value="No" type="radio" />No
</td>
</tr>
<tr>
<td style="width: 202px;">Use TP</td>
<td style="width: 202px;">
    <input name="useTP" value="Yes" type="radio" checked />Yes
    <input name="useTP" value="No" type="radio" />No
</td>
</tr>
<tr>
<td><?php print  BASE_PMUI_PLMC;?></td>
<td><input name="lmc_file" type="file" /></td>
</tr>
<tr>
<td><?php print  BASE_PMUI_PSRCXLIFF;?></td>
<td><input name="source_xliff_file" type="file" /></td>
</tr>
<tr>
<td colspan="2" rowspan="1" style="width: 202px; text-align: center;"><input type="submit" /><input type="reset" /><br />
</td>
</tr>
</tbody>
</table>
</form>
<br />
<br />
</div>
<div id="rightbar">
<h2><?php print  BASE_LATEST_PROJECTS;?></h2>
<p>
<?php 
$db = new PDO('sqlite:'.BASE_DB_URL.'locTemp.sqlite');
$res = $db->query('Select * from Project where FinishDate is null Order by CreateDate Desc');
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
;?></p>
</div>
</div>
<div id="bottom">
<div id="email"><a href="mailto:<?php print BASE_EMAIL;?>"><?php print  BASE_EMAIL;?></a></div>
<div id="validtext">
<p>Valid <a href="http://validator.w3.org/check?uri=referer">XHTML</a>
| <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a></p>
</div>
</div>
</div>
</div>
</body></html>
