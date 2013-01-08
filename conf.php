<?php
define('BASE_UPLOAD_PATH',dirname($_SERVER["SCRIPT_FILENAME"]).'/uploads/');			//UPLOAD FOLDER PATH
date_default_timezone_set('Europe/Dublin');
//ini_set('display_errors',1); error_reporting(E_ALL|E_STRICT); //Set php error display
define('BASE_PATH',realpath('.')); 						
define('BASE_URL', dirname($_SERVER["SCRIPT_NAME"]));	    //folder path where locConnect is installed
//define('BASE_DB_URL', '../locConnect2.0/');	
define('BASE_DB_URL', './');								// locConnect database location
define('BASE_DEF_VAL', 'ON');
define('BASE_VER', 'v2.8');									//locConnect version
define('BASE_UPDATE', '23rd May, 2012');				//last updated date
define('BASE_EMAIL', 'Asanka.Wasala@ul.ie');			//locConnect email
define('BASE_PREV_STYLE','none');                    //translation preview style none or glue


/*Localisation Strings*/

//header
define('BASE_LOCCONNECT', 'locConnect');
define('BASE_MOTO', 'conducting your components');


define('BASE_TITLE', 'locConnect '.BASE_VER.' - Localisation Project Manager');
define('BASE_H1', 'SOLAS');
define('BASE_H2', 'Service-oriented localisation architecture solution');

//common
define('BASE_LATEST_PROJECTS', 'latest projects');
define('BASE_TP_DOWNLOAD', 'Download');
define('BASE_T_VIEW', 'View');
define('BASE_T_DXLIFF', ' Download XLIFF file ');

//Top Navigation
define('BASE_HOME', 'Home');
define('BASE_NEW_PROJECT', 'New Project');
define('BASE_TRACK_PROJECTS', 'Track Projects');
define('BASE_ABOUT', 'About us');

//About page
define('BASE_ABOUT_LOCCONNECT', 'About locConnect..');
define('BASE_ABOUT_CURRENT_VERSION', 'Current Version:');
define('BASE_ABOUT_LAST_MODIFIED', 'Last Modified:');
define('BASE_ABOUT_DESC', 'The work was supported by Centre for Next Generation Localisation and administered through the Localisation Research Centre,University of Limerick, Ireland.');

//index page (home)
define('BASE_INDEX_WHAT_IS', 'What is locConnect?');
define('BASE_INDEX_DESC',
'Localisation is a complex process. Localisation involves many steps 
(Project Management,Translation, Review, Quality Assurance etc) , many languages and
&nbsp;many challenges (e.g. Right to left languages, simships,
&nbsp;large volume etc). Different components (i.e. software tools)
have been developed to&nbsp; address different needs and issues of
the localisation process. In order to define an optimized and automated
localisation workflow, these tools have to be integrated together in an
effective manner.&nbsp; <span style="font-style: italic;">Interoperability</span>
is the key to successful integration.&nbsp; However, interoperability
is one of the most&nbsp;challenging problems in the localisation field
today.</p><p style="text-align: left;"><br /></p><p style="text-align: left;">LocConnect
was developed to seamlessly integrate different localisation components
together. It has a built-in workflow engine that will automate the
operation of individual components.&nbsp; LocConnect is fully XLIFF
compliant and it comes with a very simple API.&nbsp;<br /><br /><img style="border: 1px solid ; width: 336px; height: 205px;" alt="a digram illustrating how locConnect operates" src="images/locDiag.jpg" /> </p>
<p><br />LocConnect connects different components together while
managing assets belonging to those components. It will automate the
localisation tasks as much as possible. &nbsp;LocConnect is ideal for
SMEs who cannot afford high cost associated with the&nbsp;localisation
process.');


//PMUI
define('BASE_PMUI_CREATE_PROJECT', 'Create a New Project');
define('BASE_PMUI_PNAME', 'Project Name');
define('BASE_PMUI_PDESC', 'Project Description');
define('BASE_PMUI_PDOMA', 'Project Domain');
define('BASE_PMUI_PSRCL', 'Source Language');
define('BASE_PMUI_PTGTL', 'Target Language');
define('BASE_PMUI_PSTDT', 'Start Date');
define('BASE_PMUI_PDEAD', 'Deadline');
define('BASE_PMUI_PBUDG', 'Budget(€)');
define('BASE_PMUI_PQAUL', 'Quality Requirements');
define('BASE_PMUI_PMT', 'Use MT');
define('BASE_PMUI_ITS', 'ITS Validation');
define('BASE_PMUI_PRT', 'Use Source Validation');
define('BASE_PMUI_PCNAME', 'Company Name');
define('BASE_PMUI_PCTNAME', 'Contact Name');
define('BASE_PMUI_PCTEMAIL', 'Contact email');
define('BASE_PMUI_PLMC', 'LMC file');
define('BASE_PMUI_PSRCF', 'Source text file');
define('BASE_PMUI_PSRCT', 'Source text <br/> (if file is not selected)');
define('BASE_PMUI_CLIENT', 'Client');

//track project
define('BASE_TP_AP', 'Active Projects');
define('BASE_TP_CP', 'Completed Projects');
define('BASE_TP_TRACK', 'Track');
define('BASE_TP_DELETE', 'Delete');
define('BASE_TP_CONFIRM', 'Are you sure you want to delete this project?');
define('BASE_TP_EDIT', 'View|Edit');


// track page

define('BASE_T_STATUS', 'Status');
define('BASE_T_WORKFLOW', 'Workflow');
define('BASE_T_LOADING', 'Loading');
$arr = array(
 "DDC" => "Data Domain Classifier",
 "ITS" => "ITS Validator",
 "EXT" => "Extractor",
 "MGR" => "Merger",
 "LKR" => "Localisation Knowledge Repository",
 "WFR" => "Workflow Recommender", 
 "LMC" => "XLIFF Phoenix", 
 "DST" => "Domain-specific Translator",
 "RT" => "Translation Rating", 
 "CMG" => "CMS-L10N Generator", 
 "CMP" => "CMS-L10N Processor", 
 "COMSIM" => "LocConnect Component Simulator", 
 "MT" => "Mapper" );
$st = array(
 "Processing" => "Processing",
 "Pending" => "Pending", 
 "Complete" => "Complete" );
define('BASE_T_CSTATUS', 'Current Status:');
define('BASE_T_PF', ' Project finished on ');
define('BASE_T_ORCON', ' or continue ');
define('BASE_T_POST', ' post editing ');
define('BASE_T_INL', ' in locConnect.');
define('BASE_T_STO', 'Status & Outputs');
define('BASE_T_COM', 'Component');
define('BASE_T_PICKED', 'Picked On');
define('BASE_T_OUTON', 'Output On');
define('BASE_T_OUTPUT', 'Output');
define('BASE_T_FB', 'Feedback');

define('BASE_T_XMETA', 'Project Metadata');
define('BASE_T_XFILE', 'XLIFF File Metadata');
define('BASE_T_XWF', 'XLIFF Workflow Metadata');
define('BASE_T_XPM', 'XLIFF Phase Metadata');
define('BASE_T_XTM', 'XLIFF Tool Metadata');
define('BASE_T_XCGM', 'XLIFF Count Group Metadata');
define('BASE_T_XNM', 'XLIFF Note Metadata');

//XLIFF Editor
define('BASE_XLFV_EDITOR', ' XLIFF Editor ');
define('BASE_XLFV_PEDIT', ' Post Editing ');
define('BASE_XLFV_SRC', 'source');
define('BASE_XLFV_TGT', 'target');
define('BASE_XLFV_ALT', 'alternative translations');
define('BASE_XLFV_TRAN', 'Translations');
define('BASE_XLFV_META', 'Metadata');
define('BASE_XLFV_SRCERR', '(source string not found)');
define('BASE_XLFV_TGTERR', '(target string not found)');
define('BASE_XLFV_ALTERR', 'no alternative translations found');
define('BASE_XLFV_HIDET', 'hide Translations');
define('BASE_XLFV_HIDEM', 'hide Metadata');
define('BASE_XLFV_DOWNTF', 'Download Translated file');
define('BASE_XLFV_PREVF', 'Preview Translated file');

//XLIFF Viwer
define('BASE_XLFV_OUTOF', ' Output of ');

//create_project
define('BASE_CP_SOURCEERR', 'The source file you attempted to upload is not allowed.');
define('BASE_CP_SOURCEERR_LARGE', 'The source file you attempted to upload is too large.');
define('BASE_CP_RESERR','The resource file you attempted to upload is not allowed.');
define('BASE_CP_RESERR_LARGE','The resource file you attempted to upload is too large.');
define('BASE_CP_UPLOADERR','You cannot upload to the specified directory.');
define('BASE_CP_UPLOADERR_RES','There was an error during the resource file upload.  Please try again.');
define('BASE_CP_SUCCESS', 'Project Successfully Created');
define('BASE_CP_SUCCESS_M1', 'Your source file upload was successful<br/>');
define('BASE_CP_SUCCESS_M2', 'Job ID assigned to this project is: ');
define('BASE_CP_SUCCESS_M3', 'You can track the status of this project by clicking ');
define('BASE_CP_SUCCESS_M4', 'here');
define('BASE_CP_SUCCESS_M5', 'Your resource file was successfully uploaded and it can be accessed by Resource ID:');
define('BASE_CP_UPLOADERR_SRC','There was an error during the source file upload.  Please try again.');
define('BASE_CP_UPLOADERR_TXT','Please enter text to be translated and try again.');
define('BASE_CP_SUCCESS_M6','Your source text has been successfully converted into XLIFF and a locConnect project has been created.<br/>');

//delete
define('BASE_D_SUCCESS', 'Project and associated files were successfully deleted.');


//xconv
define('BASE_XCONV_PREVIEW', 'Preview');
define('BASE_XCONV_BACK', 'Back to XLIFF Editor');
define('BASE_PMUI_PSRCXLIFF', 'Source XLIFF file');
define('BASE_PMUI_INPUT_SOURCE', 'Choose your input source:');
define('BASE_PMUI_TEXT_INPUT', 'Text file or text input');
define('BASE_PMUI_XLIFF_INPUT', 'XLIFF file');


//locConnect UI Translations
define('BASE_UI_TRANS_BY', '');

$languages = array(
 "en" => ".", 
 "es" => "./es"
 );

//function curPageName() {
 //return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
//}

function curPageName() {
 $pageURL = 'http';
 //if ($_SERVER["HTTPS"] == "on"){$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return substr($pageURL,strrpos($pageURL,"/")+1);
}

?>
