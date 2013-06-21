<?php
/*------------------------------------------------------------------------*
 * © 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
require_once('./conf.php');
$new_value=$_POST['value'];
$trans_unit_id=$_POST['id'];
$job_id=$_GET['jid'];

//$new_value='bunney';
//$trans_unit_id='124';//$_POST['id'];
//$job_id=$_GET['jid'];


            $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE.';port='.DB_PORT, DB_USERNAME, DB_PASS, array());
             $res = $db->query('select * from Project where  ID="'.$job_id.'"');
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

$xliff = new DOMDocument();
$xliff->loadXML($out);	
$xpath = new DOMXPath($xliff);
$xpath->registerNamespace('a', "urn:oasis:names:tc:xliff:document:1.2");
$query = '//a:trans-unit[@id="'.$trans_unit_id.'"]/a:target';
$tunits = $xpath->query($query);
$target=0;
foreach($tunits as $tu)
{
	$target=1;
	   $te=$new_value;
	   $te=str_replace("<span class=\"red\">", "", $te);
	   $te=str_replace("<span class='red'>", "", $te);
	   $te=str_replace("</span>", "", $te);
	   
		$tu->nodeValue=$te;//setAttribute("company-name",$new_value);
}

if (!$target && $new_value!="")
{
	$xpath1 = new DOMXPath($xliff);
	$xpath1->registerNamespace('a', "urn:oasis:names:tc:xliff:document:1.2");
	$query1 = '//a:trans-unit[@id="'.$trans_unit_id.'"]';
	$tunits = $xpath1->query($query1);
	foreach($tunits as $tu)
	{
	
		$te=$new_value;
	   $te=str_replace("<span class=\"red\">", "", $te);
	   $te=str_replace("<span class='red'>", "",$te);
	   $te=str_replace("</span>", "", $te);
	
		$frag = $xliff->createElement("target");  
		$fragA = $xliff->createTextNode($te);
		$frag->appendChild($fragA);
		$tu->appendChild($frag);
	}
}

$output=$xliff->saveXML();
 $content=$output;
  $content=str_replace('\'','\'\'',$content);
  $content=str_replace('\"','\"\"',$content);
  $pattern = '/<\?xml version.*;?>/i';
  $replacement = '';
  $content=preg_replace($pattern, $replacement, $content);

    //open the database
try
{
	$count = $db->exec("Update Project set Output='".$content."' where ID='".$job_id."'");
    // close the database connection
	$count = $db->exec('Update Project set FinishDate=now() where ID="'.$job_id.'"');
    $db = NULL;
 } 
  catch(PDOException $e)
  {
    print 'error occoured while updating target';
  }
echo '<span class="red">'.$new_value.'</span>';
;?>
