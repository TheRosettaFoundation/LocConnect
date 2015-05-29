# LocConnect
LocConnect is a SOA based research platform interconnects various localisation components by providing access to a XLIFF-based data layer through an Application Programming Interface (API). By using this common data layer, LocConnect allow for the traversal of XLIFF-based data between different distributed localisation components.

**Coded by:**
* [Asanka Wasala](https://github.com/Wasala)
* [David O'Carroll](https://github.com/spaceindaver)

## License notice
This software is licensed under the terms of the GNU LESSER GENERAL PUBLIC LICENSE Version 3, 29 June 2007 For full terms see License.txt or http://www.gnu.org/licenses/lgpl-3.0.txt

## Live demo 
* http://demo.solas.uni.me/locConnect/

## References
* http://www.localisation.ie/sites/default/files/publications/Vol10_1WasalaOkeeffeSchaler.pdf 
* http://link.springer.com/chapter/10.1007%2F978-3-642-24106-2_48#page-1

## Installation Requirements
* A web server running PHP (5.2.13 or higher) with PEAR, PDO and PDO SQLITE extensions ENABLED
* Apache 2.2 or higher is recommended for the web server.
* PHP installation instructions available at: www.php.org
*	PEAR installation instructions available at :http://pear.php.net/manual/en/installation.php
	
###	Recommended PHP Settings
```	
	max_execution_time = 240     
	max_input_time = 60	
	memory_limit = 256M     
	display_errors = Off
	post_max_size = 20M
	magic_quotes_gpc = Off
	magic_quotes_runtime = Off
	magic_quotes_sybase = Off
	default_mimetype = "text/html"
	default_charset = "utf-8"
	file_uploads = On
	upload_max_filesize = 20M
	extension=php_pdo.dll
	extension=php_pdo_sqlite.dll
	extension=php_sqlite.dll
	extension=php_xmlrpc.dll
	extension=php_xsl.dll
	extension=php_zip.dll
```
### Recommended Apache Settings
```
	EnableMMAP off
	EnableSendfile off
	Win32DisableAcceptEx 
```
	
### Folder/File Permissions
* Inet user / www-data/Apache user should have full control over  (i.e. including write permission) following files and folders.
* files: conf.php and conf-back.php
* folders:1. LocConnect installation folder	2. LocConnect upload folder (See 'Installation' section)
	
### Installation
*  Step 1: Creat a folder to hold uploaded files in the server. This folder is known as 'upload' folder in this document. Grant 'read/write' permissions to this folder.
*  Step 2: Copy/Move the iLocConnect-<version>-<language>.php into the desired folder within the web root.
*  Step 3: Execute iLocConnect-<version>-<language>.php through the browser. (e.g. iLocConnect-v27-en.php)
*  Step 4: Delete iLocConnect-<version>-<language>.php script from the web server.
*  Step 5: Configure LocConnect by editing necessary parameters in the conf.php (see Configuration section).
*	This can also be carried out by log-in onto the Admin panel (request Admin password from author).
* Edit the BASE_UPLOAD_PATH to include the correct path to the folder created in step one. Usually the BASE_UPLOAD_PATH is the first line of the conf.php.
* Step 6: Launch LocConnect by visiting index.php.
  
###  Configuration
*  Step 1: Open conf.php in a text editor.
*  Step 2: Configure LocConnect Database path.
*  e.g. define('BASE_DB_URL', './');
*  e.g. define('BASE_DB_URL', 'http://www.yourdomain.com/db/en/');
*  Step 3: Configure components (See Adding New Components section).
*  Step 4: Set-up language packs and respective directories to store them. Modify $languages array to include installed  language packs (see section on Lannguage Pack Installation).
*  Step 5: Make sure the SQLite file is executable. Also, the directory that the SQLite file is in must be executable.
```  
  $languages = array(
		"en" => ".",
		"es" => "./es");
```
*  The two letter language code and the directory of language pack has to be specified in the above manner.
  
###  Adding New Components 
* Step 1: Open conf.php in a text editor.
* Step 2: Enter component short and long names in the $arr variable as given below.
```  
e.g.
  $arr = array(
  "LKR" => "Localisation Knowledge Repository",
  "WFR" => "Workflow Recommender", 
  "LMC" => "Localisation Memory Container", 
  "RT" => "Translation Rating", 
  "MT" => "Machine Translation" );
  Step 3: Include three 100x101 (px) png images and name them in the following convention:

  <component-short-name>-red.png
  <component-short-name>-grey.png
  <component-short-name>-green.png
  
  e.g.
  WFR-red.png
  WFR-grey.png
  WFR-green.png
```
###  Adding New Language Packs
  
* Step 1: Create a folder with two letter language code
* Step 2: Install relevant LocConnect language pack into the created folder (e.g. es) - see LocConnect installation instructions
* Step 3: Configure conf.php (especially $language parameter).
  
### Security
* Restrict access to sqlite database through .htaccess, by adding following lines:
* Do this for all language packs.
```
	<files dbTemp.sqlite>
	order allow,deny
	deny from all
	</files>
```
###  More information
* Please check the comprehensive [documentation] (https://github.com/TheRosettaFoundation/LocConnect/tree/master/docs)

## Acknowledgement
This research is supported by the Science Foundation Ireland (Grant 12/CE/I2267) as part of Centre for Next Generation Localisation (CNGL) www.cngl.ie at the Localisation Research Centre, Department of Computer Science and Information Systems, University of Limerick, Limerick, Ireland. It was also supported, in part, by "FP7-ICT-2011-7 - Language technologies" Project "MultilingualWeb-LT (LT-Web) - Language Technology in the Web" (287815 - CSA).
