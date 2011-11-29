<?php
require_once('./conf.php');

$values = $_POST['selectlmc'];
$lmcdesc = $_POST['lmcdesc'];
$prevlmc=$_POST['prevlmc'];
$ldesc=$lmcdesc;
//var_dump($values);

function fixXLIFF($string)
{
	$pattern = '/\< *(.*?) *\>/ims';
	$replacement = '<xliff:$1>';
	$text= preg_replace($pattern, $replacement, $string);
	$text = str_replace("xliff:/", "/xliff:", $text);
	return $text;
}

function genLMC($string,$count)
{
	$no=(string)$count;
	$now=date('c');
	$line="";
	$line.='<?xml version="1.0" encoding="UTF-8"?>';
	$line.='<lmc:lmc xmlns:lmc="http://www.localisation.ie/lmc" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"'; 
	$line.='xsi:schemaLocation="http://www.localisation.ie/lmc/lmc.xsd">';
	$line.='<lmc:header author="LOCConnect" started="'.$now.'"  last-mod="'.$now.'" total-files="'.$no.'"/>';
	$line.='<lmc:body  xmlns:xliff="urn:oasis:names:tc:xliff:document:1.2">';
	$line.=$string;
	$line.='</lmc:body>';
	$line.='</lmc:lmc>';
	return $line;
}
//open the database

function getLMC()
{
	global $prevlmc,$values,$lmcdesc,$ldesc;
	
	$output="";
	if ($prevlmc=="0")
	{
		$db = new PDO('sqlite:'.BASE_DB_URL.'locTemp.sqlite');
		$xliffstack="";
		$count=0;
		foreach ($values as $a){
			$res = $db->query('SELECT Output FROM Project where ID="'.$a.'"');
			 $xliff=$res->fetchColumn();
			 $xliffstack.=$xliff;
			 $count++;
		}
		$output=genLMC(fixXLIFF($xliffstack),$count); 
		$db = NULL;
	} else
	{
		try
		{
		//open the database
			$db = new PDO('sqlite:'.BASE_DB_URL.'locTemp.sqlite');
			$res = $db->query('SELECT File,Description FROM Resources where ResourceID="'.$prevlmc.'"');
			foreach($res as $row)
			{
			 $lmc=$row["File"];
			 $ldesc=$row["Description"];
			}

			$output=$lmc;
		}
		catch(PDOException $e)
		{
			//print 'Exception : '.$e->getMessage();
		}
		$db = NULL;
	}
	
	return $output;
}

function getLMCDesc()
{
 global $ldesc;
 return $ldesc;
}

print getLMC()."**************".getLMCDesc();
?>