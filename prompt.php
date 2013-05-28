<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<?php
/*------------------------------------------------------------------------*
 * © 2010 University of Limerick. All rights reserved. This material may  *
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
<form target="_self" enctype="multipart/form-data" method="post" action="./selector.php" name="pmui">
<table class="normaltext" style="text-align: left; width: 537px;" border="0" cellpadding="2" cellspacing="2">
<tbody>
<tr>
<td style="width: 202px;"><?php print  BASE_PMUI_INPUT_SOURCE;?></td>
<td style="width: 315px;"><input name="format" value="TEXT" type="radio"  /> <?php print  BASE_PMUI_TEXT_INPUT;?> <br/><input name="format" value="XLIFF" type="radio" checked/>  XLIFF file</td>
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