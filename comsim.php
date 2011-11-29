<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<?php
/*------------------------------------------------------------------------*
 * © 2010 University of Limerick. All rights reserved. This material may  *
 * not be reproduced, displayed, modified or distributed without the      *
 * express prior written permission of the copyright holder.              *
 *------------------------------------------------------------------------*/
	require_once('./conf.php');
?>
 
<meta content="text/html; charset=utf-8" http-equiv="content-type"><title>locConnect <?php print BASE_VER;?>  - Component Simulator</title>

</head><body>
<h2>locConnect <?php print BASE_VER;?>  - Component Simulator</h2>
<br>
<form target="_self" enctype="multipart/form-data" method="post" action="simulate.php" name="simul">
<table style="text-align: left; width: 100px;" border="0" cellpadding="2" cellspacing="2">
<tbody>
<tr>
<td></td>
<td>Component</td>
<td>
<select name="com"><option selected="selected">LKR</option><option>WFR</option><option>LMC</option><option>RT</option><option>MT</option></select>
</td>
</tr>
<tr>
<td></td>
<td>Project ID</td>
<td>
<select name="job"><?php $db = new PDO('sqlite:'.BASE_DB_URL.'locTemp.sqlite');
$res = $db->query('Select PName, ID from Project where FinishDate is null Order by CreateDate Desc');
foreach($res as $row)
{
print "<option value='".$row['ID']."'>".$row['ID']." - ".$row['PName']."</option>";
}
$db=NULL;
;?></select>
</td>
</tr>
<tr>
<td><input name="api" value="status" type="radio"></td>
<td>Set Status</td>
<td>
<select name="status"><option>processing</option><option>complete</option><option>pending</option></select>
</td>
</tr>
<tr>
<td><input name="api" value="feedback" type="radio"></td>
<td>Send Feedback</td>
<td><input maxlength="250" size="40" name="feedback"></td>
</tr>
<tr>
<td><input name="api" value="output" type="radio"></td>
<td>Send Output</td>
<td><input name="output" type="file"></td>
</tr>
<tr>
<td><input name="api" value="fetch" type="radio"></td>
<td>Fetch Job</td>
<td></td>
</tr>
<tr><td><input name="api" value="get" type="radio"></td><td>Get Job</td><td></td></tr><tr>
<td></td>
<td></td>
<td><input type="submit"><input type="reset"></td>
</tr>
</tbody>
</table>
<br>
</form>
</body></html>