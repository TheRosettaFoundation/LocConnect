<?php
/*------------------------------------------------------------------------*
 * © 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
require_once('./conf.php');
			 $id=$_GET["id"];
			 $method=$_GET["method"];
			 $style=strtolower($_GET["style"]);
             $db = new PDO('sqlite:'.BASE_DB_URL.'locTemp.sqlite');
             $res = $db->query('select * from Project where  ID="'.$id.'"');
			 $c=0;
             foreach($res as $row)
             {
              $c=$c+1;
              $currentstep=(int)$row['CurrentStep'];
              $finishdate=$row['FinishDate'];
              $pname=$row['PName'];
              $pdesc=$row['Desc'];
			  $out=$row['Output'];
             }
			 
			 if ($c>0)
			 {
			   if ($out!=""   )
			   {
			   	$xliff = new DOMDocument();
				$xliff->loadXML( $out);	
				$conv = $xliff->getElementsByTagName( 'converted-file' );
				$content=trim($conv->item(0)->nodeValue);
				$tu = $xliff->getElementsByTagName( 'trans-unit' );	
				$constr="";
				foreach ($tu as $tui){
					$source=trim($tui->getElementsByTagName('source')->item(0)->nodeValue);
					$target=trim($tui->getElementsByTagName('target')->item(0)->nodeValue);
					$content=str_replace($source,$target,$content);
					$constr=$constr.$tui->getElementsByTagName('target')->item(0)->nodeValue;
				//print $target;
				}
				$content=trim($content);
				
			    if ($method=='download')
				{
				header('Content-Type: text/plain; charset=utf-8');
				header('Content-Disposition: attachment; filename="'.$id.'.txt"');
				if ($style=="glue") print $constr; else print $content;
				} else 
				{
?>				
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type"
    content="text/html; charset=utf-8" />
	<title><?php print BASE_TITLE ;?></title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
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
		<h2> <?php print  BASE_XCONV_PREVIEW;?> - <?php print $pname;?></h2>
<pre>
<?php if ($style=="glue") print $constr; else print $content;?>
</pre>
<br/>
<input type=button onClick="location.href='./xlfview.php?id=<?php print $id;?>'" value='<?php print  BASE_XCONV_BACK;?>'>
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
<?php			
				}
			   }
			 } else
			 {
			 die('project ID not found');
			 }
 

?>