<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <?php
	require_once('./conf.php');
	;?>
    <meta http-equiv="Content-Type"
    content="text/html; charset=utf-8" />
    <title><?php print BASE_TITLE ;?></title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link type="text/css"
    href="css/ui-lightness/jquery-ui-1.8.4.custom.css"
    rel="stylesheet" />
    <script type="text/javascript" src="js/jquery.js"></script>
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
		<center>
		<h3> Sign in to configure locConnect  </h3>
		<br/>
		<form action="./admins.php" method="post">
         <table class="trans">

<tr>
<td class="bold">username:</td>
<td ><input name="uname" size='40'></td>

</tr>
<tr>

<td class="bold">password</td>

<td ><input type="password" size="10" name="pwd"></td>

</tr>

</table>
<br/>
<input type="submit" value="Submit">
</form>
           </center>
        </div>
        <div id="bottom">
        <div id="email"><a href="mailto:<?php print BASE_EMAIL;?>"><?php print  BASE_EMAIL;?></a></div>
          <div id="validtext">
            <p>Valid
            <a href="http://validator.w3.org/check?uri=referer">
            XHTML</a>|
            <a href="http://jigsaw.w3.org/css-validator/check/referer">
            CSS</a></p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
