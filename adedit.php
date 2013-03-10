<?php
/*------------------------------------------------------------------------*
 * © 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
require_once('./conf.php');
$new_value=$_POST['value'];
$p=explode("-",$_POST['id']);
$key=trim($p[1]);
$lineno=(int)$p[0]; //;
$line_of_text=array();
$file_handle = fopen("conf.php", "rb");
$i=0;
while (!feof($file_handle) ) {
$i++;
$line_of_text[$i] = fgets($file_handle);
}

$file1 = fopen("conf-back.php","w");
for($c=1;$c<=$i;$c++)
{
	fputs($file1,$line_of_text[$c]);
}
fclose($file1);


$line_of_text[$lineno]="define('".$key."', '".$new_value."');\n";	
$file = fopen("conf.php","w");
for($c=1;$c<=$i;$c++)
{
	fputs($file,$line_of_text[$c]);
}
fclose($file);
 
echo '<span class="red">'.$new_value.'</span>';
?>