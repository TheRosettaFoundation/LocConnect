<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

       $("table tr.header").click(function(event){
            $(this).nextAll('tr').each( function() {
           if ($(this).hasClass('header')) { return false; }
           $(this).show(); });
         });
         
    $('table tr.row').click( function() {
    $(this).hide();
    $(this).prevAll('tr').each( function() {
        if ($(this).hasClass('header')) {
            return false;
        }
        $(this).hide();
    });
    $(this).nextAll('tr').each( function() {
        if ($(this).hasClass('header')) {
            return false;
        }
        $(this).hide();
    });
    




});

$(".dblclick").editable("echo.php?jid=<?php print  $_GET['id'];?>", {
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

 $('#metadata').hide();

 $('a#meta').click(function(){ $('#metadata').show('slow'); });

$('a#close').click(function(){ $('#metadata').hide('slow');});

$('a#trans').click(function(){ $('#translate').show('slow'); });

$('a#closet').click(function(){ $('#translate').hide('slow');});

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
          <div class="txt">
            <?php
            $id=$_GET["id"];

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
             }

             if ($c>0)
             {
             print "<center><h2>".BASE_XLFV_EDITOR."</h2>\n";
			 print "<h3>".BASE_XLFV_PEDIT."'".$pname."'</h3></center> <br/>\n";
             } else
             {
              die('<h2>XLIFF Editor - Project Not Found.</h2><br/>');
             }
			 $db=NULL;
            ;?>
          </div>

          <?php
//ini_set('display_errors', 1);
//ini_set('log_errors', 1);
//ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
//error_reporting(E_ALL);

	//$id=$_GET["id"];
	//$com=$_GET["com"];
	//$order=$_GET["order"];

   $id=$_GET["id"];
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
				$out=trim($out);
			   }
			 } else
			 {
			 die("project ID not found");
			 };

	//print $out;

	$doc = new DOMDocument();
	$doc->loadXML($out);
	
    print '<center> <a href="#" id="trans"><h3 style="font-weight:bold; font-size:20px;">'.BASE_XLFV_TRAN.' </h3> </a></center>';
    print '<div id="translate">';
	print '<table class="trans" border="0" cellpadding="3" cellspacing="0" align="center"><tbody>';

	$nodes = $doc->getElementsByTagName ("trans-unit");
	//print '<tr class="header"><td colspan="2" rowspan="1">XLIFF Count Group Metadata</td></tr>';
	foreach ($nodes as $node)
	{


			$name =$node->getAttribute("id");
			if ($node->hasChildNodes())
			  {
				$sourceNode=$node->getElementsByTagName("source");
				if ($sourceNode->length>0) $source=$sourceNode->item(0)->nodeValue ;else $source=BASE_XLFV_SRCERR;
				if (trim($source)=="") $source=BASE_XLFV_SRCERR;
				$targetNode=$node->getElementsByTagName("target");
				//print $node->hasElement("target");
				if ($targetNode->length>0) $target=$targetNode->item(0)->nodeValue; else $target=BASE_XLFV_TGTERR;
				if (trim($target)=="") $target=BASE_XLFV_TGTERR;
				$altTrans=$node->getElementsByTagName("alt-trans");
				print '<tr class="header"><td colspan="4" rowspan="1">'.$name.'</td></tr>';
				print '<tr class="row" id="src"><td>'.BASE_XLFV_SRC.'</td><td colspan="3" rowspan="1">'.htmlentities($source,ENT_QUOTES,'UTF-8').'</td></tr><tr id="tgt"><td>'.BASE_XLFV_TGT.'</td><td colspan="3" rowspan="1" class="dblclick" id="'.$name.'">'.$target.'</td></tr>';



				if ($altTrans->length>0)
				{


					$k=0;
					foreach ($altTrans as $alt)
					{
					$k++;
					$altval=$alt->nodeValue;
					if ($k==1)print '<tr class="row-no-click"><td colspan="1" rowspan="'.(string)$altTrans->length.'">'.BASE_XLFV_ALT.'</td>'; else
					print "<tr class='row-no-click'>";
					if ($altval!="") print '<td class="alt">'.$altval.'</td>';  else print '<td> <em>'.BASE_XLFV_ALTERR.'</em> </td>';
					$temp="";
					$length = $alt->attributes->length;
						for ($i = 0; $i < $length; ++$i)
						{
							$att =$alt->attributes->item($i)->name;
							$val=$alt->attributes->item($i)->value;
							if ($att!="match-quality") $temp=$temp.$att. " : ".$val. "<br/>";
						}
						$mq =$alt->getAttribute("match-quality");
						if ($mq=="" or $mq==NULL) $mq="N/A";
						print '<td class="red" id="altb">'.$mq.'</td><td class="txt" id="altb">'.$temp.'</td></tr>';
					}


				} else
				{
				print '<tr class="row-no-click"><td colspan="4" rowspan="1" class="alt"> <em>'.BASE_XLFV_ALTERR.' </em> </td></tr>';
				}

			  }

	}
	print '</tbody></table>';
    print '<center><p class="txt"><a id="closet" href="#"> <em>'.BASE_XLFV_HIDET.'</em> </a></p></center></div>' ;
	
	  print '<br/><center> <a href="#" id="meta"><h3 style="font-weight:bold; font-size:20px;">'.BASE_XLFV_META.'</h3> </a></center>';
    print '<div id="metadata">';
	print '<table class="meta" border="0" cellpadding="2" cellspacing="0" align="center">';
	

	// project meta data
	$nodes = $doc->getElementsByTagName ("pmui-data");
	print '<tr class="header"><td colspan="2" rowspan="1">'.BASE_T_XMETA.'</td></tr>';
	foreach ($nodes as $node)
	{
		$length = $node->attributes->length;
		for ($i = 0; $i < $length; ++$i)
		{
			$name =$node->attributes->item($i)->name;
			$val =$node->attributes->item($i)->value;
			if ($val!="")print "<tr class='row'><td class='bold'>".$name."</td><td>".$val."</td></tr>";
		}
		print '<tr class="blankrow"><td colspan="2" rowspan="1">&nbsp;</td></tr>';
	}
	// file meta data
	$nodes = $doc->getElementsByTagName ("file");
	print '<tr class="header"><td colspan="2" rowspan="1">'.BASE_T_XFILE.'</td></tr>';
	foreach ($nodes as $node)
	{
		$length = $node->attributes->length;
		for ($i = 0; $i < $length; ++$i)
		{
			$name =$node->attributes->item($i)->name;
			$val =$node->attributes->item($i)->value;
			if ($val!="")print "<tr class='row'><td  class='bold'>".$name."</td><td>".$val."</td></tr>";
		}
		print '<tr class="blankrow"><td colspan="2" rowspan="1">&nbsp;</td></tr>';
	}

	// file meta data
	$nodes = $doc->getElementsByTagName ("task");
	print '<tr class="header"><td colspan="2" rowspan="1">'.BASE_T_XWF.'</td></tr>';
	foreach ($nodes as $node)
	{
		$length = $node->attributes->length;
		for ($i = 0; $i < $length; ++$i)
		{
			$name =$node->attributes->item($i)->name;
			$val =$node->attributes->item($i)->value;
			if ($val!="")print "<tr class='row'><td class='bold'>".$name."</td><td>".$val."</td></tr>";
		}
		//print '<tr class="blankrow"><td colspan="2" rowspan="1">&nbsp;</td></tr>';
	}
	print '<tr class="blankrow"><td colspan="2" rowspan="1">&nbsp;</td></tr>';
	$nodes = $doc->getElementsByTagName ("phase");
	print '<tr class="header"><td colspan="2" rowspan="1">'.BASE_T_XPM.'</td></tr>';
	foreach ($nodes as $node)
	{
		$length = $node->attributes->length;
		for ($i = 0; $i < $length; ++$i)
		{
			$name =$node->attributes->item($i)->name;
			$val =$node->attributes->item($i)->value;
			if ($val!="")print "<tr class='row'><td  class='bold'>".$name."</td><td>".$val."</td></tr>";
		}
		print '<tr class="blankrow"><td colspan="2" rowspan="1">&nbsp;</td></tr>';
	}

	$nodes = $doc->getElementsByTagName ("tool");
	print '<tr class="header"><td colspan="2" rowspan="1">'.BASE_T_XTM.'</td></tr>';
	foreach ($nodes as $node)
	{
		$length = $node->attributes->length;
		for ($i = 0; $i < $length; ++$i)
		{
			$name =$node->attributes->item($i)->name;
			$val =$node->attributes->item($i)->value;
			if ($val!="")print "<tr class='row'><td  class='bold'>".$name."</td><td>".$val."</td></tr>";
		}
		print '<tr class="blankrow"><td colspan="2" rowspan="1">&nbsp;</td></tr>';
	}

	$nodes = $doc->getElementsByTagName ("count-group");
	print '<tr class="header"><td colspan="2" rowspan="1">'.BASE_T_XCGM.'</td></tr>';
	foreach ($nodes as $node)
	{
		$length = $node->attributes->length;
		for ($i = 0; $i < $length; ++$i)
		{
			//$jname =$node->attributes->item($i)->name;
			$name =$node->attributes->item($i)->value;
			if ($node->hasChildNodes())
			  {
				$countNode=$node->getElementsByTagName("count");
				$func=$countNode->item(0)->attributes->item(0)->value;
				$type=$countNode->item(0)->attributes->item(1)->value;
				$val=$countNode->item(0)->nodeValue;
				if ($val!="")print "<tr class='row'><td  class='bold'>".$func." ".$type." count(".$name.")</td><td>".$val."</td></tr>";
				//print $val;
			  }
		}
		//print '<tr class="blankrow"><td colspan="2" rowspan="1">&nbsp;</td></tr>';
	}
	print '<tr class="blankrow"><td colspan="2" rowspan="1">&nbsp;</td></tr>';
	$nodes = $doc->getElementsByTagName ("note");
	print '<tr class="header"><td colspan="2" rowspan="1">'.BASE_T_XNM.'</td></tr>';
	foreach ($nodes as $node)
	{
		$val=$node->nodeValue;
				if ($val!="")
				{
				print '<tr class="header"><td colspan="2" rowspan="1">'.$val.'</td></tr>';
				//print $val;
			    }

		//print '<tr class="blankrow"><td colspan="2" rowspan="1">&nbsp;</td></tr>';
	}

	print '</tbody></table>';
    print '<center><p class="txt"><a id="close" href="#"> <em> hide Metadata </em> </a></p></center></div>' ;
	print "<br/><center><a class='txt' href='http://".$_SERVER['HTTP_HOST'].BASE_URL."/download.php?id=".$id."'>".BASE_T_DXLIFF."</a>&nbsp;|&nbsp;<a class='txt' href='http://".$_SERVER['HTTP_HOST'].BASE_URL."/xconv.php?id=".$id."&method=download'>".BASE_XLFV_DOWNTF."</a>&nbsp;|&nbsp;<a class='txt' href='http://".$_SERVER['HTTP_HOST'].BASE_URL."/xconv.php?id=".$id."&method=view&style=".BASE_PREV_STYLE."'>".BASE_XLFV_PREVF."</a> </center>";

	
;?>


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
