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
<li> <a href="./pmui.php"><?php print BASE_NEW_PROJECT;?></a> </li>
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
<form target="_self" enctype="multipart/form-data" method="post" action="./create_project.php" name="pmui">
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
<td><?php print  BASE_PMUI_PDOMA;?></td>
<td><input value="<?php if (BASE_DEF_VAL=='ON') print 'General';?>" maxlength="40" size="40" name="domain" /></td>
</tr>
<tr>
<td><?php print  BASE_PMUI_PSRCL;?></td>
<td>
<select name="source_lang"><option value="af">Afrikaans</option><option value="sq">Albanian</option><option value="ar">Arabic</option><option value="hy">Armenian </option><option value="az">Azerbaijani </option><option value="eu">Basque </option><option value="be">Belarusian</option><option value="bg">Bulgarian</option><option value="ca">Catalan</option><option value="zh-CN">Chinese (Simplified)</option><option value="zh-TW">Chinese (Traditional)</option><option value="hr">Croatian</option><option value="cs">Czech</option><option value="da">Danish</option><option value="nl">Dutch</option><option selected="selected" value="en">English</option><option value="et">Estonian</option><option value="tl">Filipino</option><option value="fi">Finnish</option><option value="fr">French</option><option value="gl">Galician</option><option value="ka">Georgian </option><option value="de">German</option><option value="el">Greek</option><option value="ht">Haitian Creole </option><option value="iw">Hebrew</option><option value="hi">Hindi</option><option value="hu">Hungarian</option><option value="is">Icelandic</option><option value="id">Indonesian</option><option value="ga">Irish</option><option value="it">Italian</option><option value="ja">Japanese</option><option value="ko">Korean</option><option value="lv">Latvian</option><option value="lt">Lithuanian</option><option value="mk">Macedonian</option><option value="ms">Malay</option><option value="mt">Maltese</option><option value="no">Norwegian</option><option value="fa">Persian</option><option value="pl">Polish</option><option value="pt">Portuguese</option><option value="ro">Romanian</option><option value="ru">Russian</option><option value="sr">Serbian</option><option value="si">Sinhala</option><option value="sk">Slovak</option><option value="sl">Slovenian</option><option value="es">Spanish</option><option value="sw">Swahili</option><option value="sv">Swedish</option><option value="th">Thai</option><option value="tr">Turkish</option><option value="uk">Ukrainian</option><option value="ur">Urdu </option><option value="vi">Vietnamese</option><option value="cy">Welsh</option><option value="yi">Yiddish</option></select>
</td>
</tr>
<tr>
<td><?php print  BASE_PMUI_PTGTL;?></td>
<td>
<select name="target_lang"><option value="af">Afrikaans</option><option value="sq">Albanian</option><option value="ar">Arabic</option><option value="hy">Armenian </option><option value="az">Azerbaijani </option><option value="eu">Basque </option><option value="be">Belarusian</option><option value="bg">Bulgarian</option><option value="ca">Catalan</option><option value="zh-CN">Chinese (Simplified)</option><option value="zh-TW">Chinese (Traditional)</option><option value="hr">Croatian</option><option value="cs">Czech</option><option value="da">Danish</option><option value="nl">Dutch</option><option value="en">English</option><option value="et">Estonian</option><option value="tl">Filipino</option><option value="fi">Finnish</option><option value="fr">French</option><option value="gl">Galician</option><option value="ka">Georgian </option><option value="de">German</option><option value="el">Greek</option><option value="ht">Haitian Creole </option><option value="iw">Hebrew</option><option value="hi">Hindi</option><option value="hu">Hungarian</option><option value="is">Icelandic</option><option value="id">Indonesian</option><option value="ga">Irish</option><option value="it">Italian</option><option value="ja">Japanese</option><option value="ko">Korean</option><option value="lv">Latvian</option><option value="lt">Lithuanian</option><option value="mk">Macedonian</option><option value="ms">Malay</option><option value="mt">Maltese</option><option value="no">Norwegian</option><option value="fa">Persian</option><option value="pl">Polish</option><option value="pt">Portuguese</option><option value="ro">Romanian</option><option value="ru">Russian</option><option value="sr">Serbian</option><option value="si">Sinhala</option><option value="sk">Slovak</option><option value="sl">Slovenian</option><option selected="selected" value="es">Spanish</option><option value="sw">Swahili</option><option value="sv">Swedish</option><option value="th">Thai</option><option value="tr">Turkish</option><option value="uk">Ukrainian</option><option value="ur">Urdu </option><option value="vi">Vietnamese</option><option value="cy">Welsh</option><option value="yi">Yiddish</option></select>
</td>
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
<div class="demo"><input name="deadline" id="datepicker1" type="text" value="<?php $today = date('d/m/Y');$tomorrow = strtotime('+10 day', strtotime($today)); if (BASE_DEF_VAL=='ON') print date('d/m/Y', $tomorrow);?>" /></div>
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
<td style="width: 202px;"><?php print  BASE_PMUI_PMT;?></td>
<td style="width: 315px;"><input name="MT" value="Yes" type="radio" checked />Yes <input name="MT" value="No" type="radio" />No</td>
</tr>
<tr>
<td style="width: 202px;"><?php print  BASE_PMUI_PRT;?></td>
<td style="width: 202px;"><input name="Ratings" value="Yes" type="radio" checked />Yes<input name="Ratings" value="No" type="radio" /> No</td>
</tr>
<tr>
<td style="width: 202px;"></td>
<td style="width: 315px;"></td>
</tr>
<tr>
<td style="width: 202px;"><?php print  BASE_PMUI_PCNAME;?></td>
<td style="width: 315px;"><input value="<?php if (BASE_DEF_VAL=='ON') print 'Localisation Research Centre';?>" maxlength="80" size="40" name="company_name" /></td>
</tr>
<tr>
<td style="width: 202px;"><?php print  BASE_PMUI_PCTNAME;?></td>
<td style="width: 315px;"><input value="<?php if (BASE_DEF_VAL=='ON') print 'LRC';?>" maxlength="80" size="40" name="contact_name" /></td>
</tr>
<tr>
<td style="width: 202px;"><?php print  BASE_PMUI_PCTEMAIL;?></td>
<td style="width: 315px;"><input value="<?php if (BASE_DEF_VAL=='ON') print 'lrc@localisation.ie';?>" maxlength="40" size="40" name="contact_email" /></td>
</tr>
<tr>
<td></td>
<td></td>
</tr>
<tr>
<td><?php print  BASE_PMUI_PLMC;?></td>
<td><input name="lmc_file" type="file" /></td>
</tr>
<tr>
<td><?php print  BASE_PMUI_PSRCF;?></td>
<td><input name="source_text_file" type="file" /></td>
</tr>
<tr>
<td><?php print  BASE_PMUI_PSRCT;?></td>
<td><textarea cols="40" rows="7" name="raw_text"></textarea></td>
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