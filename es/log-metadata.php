<?php
/*------------------------------------------------------------------------*
 * © 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
require_once('./conf.php');
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

    
    print '<div id="metadata">';
	print '<table class="meta" border="0" cellpadding="2" cellspacing="0" align="center">';
	$doc = new DOMDocument();
	$doc->loadXML($out);

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
    //print '<center><p class="txt"><a id="close" href="#"> <em> hide Metadata </em> </a></p></center></div>' ;
	print '</div><br>';
    /*
	print '<center> <a href="#" id="trans"><h2> Transalations </h2> </a></center>';
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
				if ($sourceNode->length>0) $source=$sourceNode->item(0)->nodeValue ;else $source="(source string not found)";
				if (trim($source)=="") $source="(source string not found)";
				$targetNode=$node->getElementsByTagName("target");
				//print $node->hasElement("target");
				if ($targetNode->length>0) $target=$targetNode->item(0)->nodeValue; else $target="(target string not found)";
				if (trim($target)=="") $target="(target string not found)";
				$altTrans=$node->getElementsByTagName("alt-trans");
				print '<tr class="header"><td colspan="4" rowspan="1">'.$name.'</td></tr>';
				print '<tr class="row" id="src"><td>source</td><td colspan="3" rowspan="1">'.htmlentities($source,ENT_QUOTES,'UTF-8').'</td></tr><tr id="tgt"><td>target</td><td colspan="3" rowspan="1">'.htmlentities($target,ENT_QUOTES,'UTF-8').'</td></tr>';
				//print "<br>".$name."<br>".$source."<br>".$target;



				if ($altTrans->length>0)
				{


					$k=0;
					foreach ($altTrans as $alt)
					{
					$k++;
					$altval=$alt->nodeValue;
					if ($k==1)print '<tr class="row"><td colspan="1" rowspan="'.(string)$altTrans->length.'">alternative translations</td>'; else
					print "<tr class='row'>";
					if ($altval!="") print '<td class="alt">'.$altval.'</td>';  else print '<td> <em> no alternative translations found </em> </td>';
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
						print '<td class="red">'.$mq.'</td><td class="txt">'.$temp.'</td></tr>';
					}


				} else
				{
				print '<tr class="row"><td colspan="4" rowspan="1" class="alt"> <em> no alternative translations found </em> </td></tr>';
				}

			  }

	}
	print '</tbody></table>';
    print '<center><p class="txt"><a id="closet" href="#"> <em> hide Translations </em> </a></p></center></div>' ;
    */
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

;?>

<?php 
 }
} else die("Project Not Found.");
  $db=NULL;
;?> 
  </tbody>
</table>

