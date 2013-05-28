<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2008 iljitsch@mail.com cookiepattern.blogspot.com
 *  All rights reserved
 *
 *  This script is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
ini_set('display_errors',1); error_reporting(E_ALL|E_STRICT);
try {
	$sourcefolder = 'locConnect2.8/'; 				// maybe you want to get this via CLI argument ...
	$targetname = 'ilocConnect-v28-en-es.php';
	$zipfilename = md5(time()).'archive.zip'; 		// replace with tempname()

	// create a archive from the submitted folder
	$zipfile = new ZipArchive();
	$zipfile->open($zipfilename,ZipArchive::CREATE);
	addFiles2Zip($zipfile,$sourcefolder,true);
	$zipfile->close();

	// compile the selfextracting php-archive
	$fp_dest =fopen($targetname,'w');
	$fp_cur = fopen(__FILE__, 'r');
	fseek($fp_cur, __COMPILER_HALT_OFFSET__);
	$i=0;
	while($buffer = fgets($fp_cur)) {
		fwrite($fp_dest,$buffer);
	}
	fclose($fp_cur);
	$fp_zip = fopen($zipfilename,'r');
	while($buffer = fread($fp_zip,10240)) {
		fwrite($fp_dest,$buffer);
	}
	fclose($fp_zip);
	fclose($fp_dest);
	unlink($zipfilename);

} catch (Exception $e) {
	printf("Error:<br/>%s<br>%s>",$e->getMessage(),$e->getTraceAsString());
}

function addFiles2Zip(ZipArchive $zip,$path,$removeFirstFolder=false) {
	$d = opendir($path);
	while($file = readdir($d)) {
		if ($file == "." || $file == "..") continue;
		$curfile=($removeFirstFolder)?substr($path.$file,strpos($path,'/')+1):$path.$file;
		if(is_dir($path.$file)) {
			$zip->addEmptyDir($curfile);
			addFiles2Zip($zip,$path.$file.'/',$removeFirstFolder);
		} else {
			$zip->addFile($path.$file,$curfile);
		}
	}
	closedir($d);
}

__HALT_COMPILER();<?php

try {
	$zipfilename = md5(time()).'archive.zip'; //remove with tempname()
	$fp_tmp = fopen($zipfilename,'w');
	$fp_cur = fopen(__FILE__, 'r');
	fseek($fp_cur, __COMPILER_HALT_OFFSET__);
	$i=0;
	while($buffer = fread($fp_cur,10240)) {
		fwrite($fp_tmp,$buffer);
	}
	fclose($fp_cur);
	fclose($fp_tmp);
	$zipfile = new ZipArchive();
	if($zipfile->open($zipfilename)===true) { 
		if(!$zipfile->extractTo('.')) throw new Exception('extraction failed...');
	} else throw new Exception('reading archive failed');
	$zipfile->close();
	unlink($zipfilename);
	print "LocConnect v2.8 successfully installed. Delete ilocConnect-v28-en-es.php file immediately and configure necessary parameters in conf.php.";
	print "<br>Note: You must create a folder in your server to store uploaded files (XLIFF, LMC etc.) and grant Apache User/inet user read/write permission to it.";
	print "<br>Note: Specify the created folder path in the 1st line of the conf.php.  Example: define('BASE_UPLOAD_PATH','c:/uploads/');";
	print "<br>Note: You do not need to configure any databases to install LocConnect. It should work out of the box if the installation requirements are met.<br>";
	print "<br> (c) Asanka Wasala, 2012 ";
	print "<br><br> If you have completed the above steps, you may launch <a href='./index.php' target='_self'>LocConnect v2.8</a> now.";
} catch (Exception $e) {
	printf("Error:<br/>%s<br>%s>",$e->getMessage(),$e->getTraceAsString());
};
__HALT_COMPILER();