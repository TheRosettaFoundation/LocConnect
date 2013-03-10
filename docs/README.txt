
                         LocConnect Server 

  What is it?
  -----------

  LocConnect is a web-based software framework developed to facilitate interoperability between different software components used in a localisation workflow.

  LocConnect connects different localisation software components, while managing assets belonging to those components. It has a built-in workflow engine that will 
  automate the operation of individual components.  LocConnect is XLIFF (v1.2) compliant and it comes with a very simple API. 
  LocConnect framework can be easily deployed and the framework itself can be localised.

  LocConnect Provides:

  Component Developers with:
 	• Simple Application Programming Interface (API)
		o Documentation for 5 API functions
		o Example implementations
	• Component Simulator
 

  End Users with:
	• Project Management User Interface (PMUI)
	• Online XLIFF Editor (for Post-editing content)
	• Live User Interface (Live UI - visual feedback of individual component statuses and translation preview)


 The Latest Version
 ------------------

  The latest version is v2.8 last modified on 23/05/2012.

  Version History
  ---------------
  LocConnect 2.8 Added more components and minor changes to conf.php, prompt.php and Spanish version. Changed 	 			 HTTP\Request2.php to HTTP/Request2.php 
		 Added new API call new_project which by passes LocConnect UI and create projects 
		 Improved Component Simulator to remember last component and project ID
		 Added Component Simulator as a component that can be called through a workflow.
		 Added new API function (new_project) to component simulator.
  LocConnect 2.7 Modified workflow display to accommodate more components, simplified the component registration process (see section 'Adding New Components').
		 Modifed component simulator to use component registration information found in conf.php, Fixed issues associated with deleting projects.
		 Note: this version does not support SSL (i.e. HTTPS)
  LocConnect 2.6 Added ability to import XLIFF and fixed minor UI issues in the XLIFF Editor
  LocConnect 2.5 Created LocConnect self extracting installer
  LocConnect 2.4 Added an Admin Panel to configure LocConnect and to facilitate the localisation process.
  LocConnect 2.3 Added conf.php which contains all configuration options and localisation strings
  LocConnect 2.2 Added Translation Preview Panel(with 'glue' and 'replace' styles) and fixed minor issues with XLIFF Editor
  LocConnect 2.1 Introduced XLIFF Editor and XLIFF Viewer, added default values in PMUI 
  LocConnect 2.0 Major Release that includes Workflow Engine, Asset Management Component, Live UI and fixed minor issues  associated with API
  LocConnect 1.0 API Implementation, released as a test-bed for component developers

  Documentation
  -------------

  The documentation of API functions available as of the date of the above release is
  included in PDF format in the docs/ directory. 

  Installation Requirements
  --------------------------
	*A web server running PHP (5.2.13 or higher) with PEAR, PDO and PDO SQLITE extensions ENABLED*
	Apache 2.2 or higher is recommended for the web server.
	PHP installation instructions available at: www.php.org
	PEAR installation instructions available at :http://pear.php.net/manual/en/installation.php
	
	Recommended PHP Settings
	------------------------
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

	Recommended Apache Settings
	------------------------
	EnableMMAP off
	EnableSendfile off
	Win32DisableAcceptEx 
	
	Folder/File Permissions
	-----------------------
	Inet user / Apache user should have full control over  (i.e. including write permission) following files and folders.
	files: conf.php and conf-back.php
	folders:1. LocConnect installation folder
		2. LocConnect upload folder (See 'Installation' section)
	
 Installation
  --------------
  Step 1: Creat a folder to hold uploaded files in the server. This folder is known as 'upload' folder in this document. Grant 'read/write' permissions to this folder.
  Step 2: Copy/Move the iLocConnect-<version>-<language>.php into the desired folder within the web root.
  Step 3: Execute iLocConnect-<version>-<language>.php through the browser. (e.g. iLocConnect-v27-en.php)
  Step 4: Delete iLocConnect-<version>-<language>.php script from the web server.
  Step 5: Configure LocConnect by editing necessary parameters in the conf.php (see Configuration section).
	  This can also be carried out by log-in onto the Admin panel (request Admin password from author).
	  	* Edit the BASE_UPLOAD_PATH to include the correct path to the folder created in step one. Usually the BASE_UPLOAD_PATH is the 
		first line of the conf.php.
  Step 6: Launch LocConnect by visiting index.php.
  
  Configuration
  ---------------
  
  Step 1: Open conf.php in a text editor.
  Step 2: Configure LocConnect Database path.
  e.g. define('BASE_DB_URL', './');
  e.g. define('BASE_DB_URL', 'http://www.yourdomain.com/db/en/');
  Step 3: Configure components (See Adding New Components section).
  Step 4: Set-up language packs and respective directories to store them. Modify $languages array to include installed language packs (see section on Lannguage Pack Installation).
  Step 5: Make sure the SQLite file is executable. Also, the directory that the SQLite file is in must be executable.
  
  $languages = array(
		"en" => ".",
		"es" => "./es");
  
  The two letter language code and the directory of language pack has to be specified in the above manner.
  
  Adding New Components 
  ----------------------
  Step 1: Open conf.php in a text editor.
  Step 2: Enter component short and long names in the $arr variable as given below.
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
  
  Adding New Language Packs
  --------------------------
  Step 1: Create a folder with two letter language code
  Step 2: Install relevant LocConnect language pack into the created folder (e.g. es) - see LocConnect     installation instructions
  Step 3: Configure conf.php (especially $language parameter).
  
  Security
  ---------
  Restrict access to sqlite database through .htaccess, by adding following lines:
  Do this for all language packs.
	<files dbTemp.sqlite>
	order allow,deny
	deny from all
	</files>
  
  Licensing
  ---------

  Pending decision on this.

  
  Contacts
  --------

     o If you want to be informed about LocConnect updates, contact Asanka Wasala, the developer by sending an email to Asanka.Wasala<at>ul.ie.

     o Information regarding LocConnect can also be received by contacting the Localisation Research Centre, CSIS Dept, University of Limerick, Ireland. email: lrc<at>ul.ie

  Research & Development
  ----------------------

  Asanka Wasala, Localisation Research Centre, CSIS Dept, University of Limerick, Ireland.
  
  Acknowledgement
  ---------------
  The original idea for the LocConnect system came from Reinhard Schäler, and the developer would like to thank   him for this, and for his help and guidance.
  Our thanks and acknowledgements for advice and support go to: Dr. Eoin Ó Conchúir, Dr. Ian.O'Keeffe and Dr.   Lamine Aouad. We would especially like to thank Mr. Aram Morera-Mesa for translating LocConnect into Spanish and   helping with the interoperability testing.
