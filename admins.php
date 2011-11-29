<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <?php
  /*------------------------------------------------------------------------*
 * © 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
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
    <script charset="utf-8" type="text/javascript" src="js/jquery.jeditable.js"></script>
    <script type="text/javascript">

  $(document).ready(function(){

     
$(".dblclick").editable("adedit.php", {
 indicator : "<img src='./images/indicator.gif'>",
 tooltip : "Double click to edit...",
 event : "dblclick",
 style : "inherit",
 data: function(value, settings) {
      /* Convert <br> to newline. */
      var retval = value.replace(/\<span class\=\"red\"\>/gi, '');
	   retval = retval.replace(/<\/span>/gi, '');
      return retval;
    }

 });


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
         

<?php
$uname=$_POST["uname"];
$pwd=$_POST["pwd"];

if (($uname=="asanka") && ($pwd=="lrcasanka"))
{
print '<INPUT type="button" value="Sign out" onClick="location.href=\'./admin.php\'">';
print '<table class="trans">';
$file_handle = fopen("conf.php", "rb");
$i=0;
while (!feof($file_handle) ) {

$i++;
$line_of_text = fgets($file_handle);

preg_match_all("/define\(\'(.*?)\' *?, *?\'(.*?)'\)\;/im", $line_of_text,$matches);
preg_match_all("/\/\/define\(\'(.*?)\' *?, *?\'(.*?)'\)\;/im", $line_of_text,$cmatches);
$param=$matches[1][0];
$val=$matches[2][0];
$lineno=(string) $i;
if ($param!="") print "<tr><td>".$lineno."</td><td class='bold'>".$param."</td><td id='".$lineno."-".$param."'class='dblclick'>".$val."<td><td>".($cmatches[1][0]!=""? "COMMENT":"")."</td></tr>\n";

//var_dump($matches);
}

fclose($file_handle);
print '</table>';
}
else
{

print "<center><p class='red'> You don't have permission to configure locConnect. <a href='./admin.php'> Retry sign in. </a> </p></center>";
}

?>


           
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
