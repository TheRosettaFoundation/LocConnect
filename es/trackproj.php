<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
require_once('./conf.php');
/*------------------------------------------------------------------------*
 * © 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
;?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php print BASE_TITLE ;?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	
 	 $("#active").load("active.php");
	 $("#completed").load("completed.php");
	 $("#latest").load("latest.php");
	 
   var refreshId = setInterval(function() {
      $("#active").load("active.php");
	  $("#completed").load("completed.php");
	  $("#latest").load("latest.php");
   }, 9000);
 
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
<h2><?php print  BASE_TP_AP;?></h2>
<div id="active"></div>
<br>
<br>
<h2><?php print  BASE_TP_CP;?></h2>
<div id="completed"></div>
<br />
<br />
</div>
<div id="rightbar">
<h2><?php print  BASE_LATEST_PROJECTS;?></h2>
<div id="latest"></div>
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