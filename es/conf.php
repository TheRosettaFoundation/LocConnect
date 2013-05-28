<?php
define('BASE_UPLOAD_PATH','c:/uploads/');			//UPLOAD FOLDER PATH
date_default_timezone_set('Europe/Dublin');
//ini_set('display_errors',1); error_reporting(E_ALL|E_STRICT); //Set php error display
define('BASE_PATH',realpath('.')); 						
define('BASE_URL', dirname($_SERVER["SCRIPT_NAME"]));	    //folder path where locConnect is installed
//define('BASE_DB_URL', '../locConnect2.0/');	
define('BASE_DB_URL', '../');								// locConnect database location
define('BASE_DEF_VAL', 'ON');
define('BASE_VER', 'v2.7');									//locConnect version
define('BASE_UPDATE', '13th April, 2011');				//last updated date
define('BASE_EMAIL', 'Asanka.Wasala@ul.ie');			//locConnect email
define('BASE_PREV_STYLE','none');                    //translation preview style none or glue

/*Localisation Strings*/

//header
define('BASE_LOCCONNECT', 'locConnect');
define('BASE_MOTO', 'Conector de componentes');

define('BASE_TITLE', 'locConnect '.BASE_VER.' - Gestor de proyectos de localización');
//define('BASE_H1', 'MUESTRA DE PRIMAVERA');
//define('BASE_H2', '8 de julio de 2011');
define('BASE_H1', 'SOLAS');
define('BASE_H2', 'Service-oriented localisation architecture solution');

//common
define('BASE_LATEST_PROJECTS', 'Últimos proyectos');
define('BASE_TP_DOWNLOAD', 'Descargar');
define('BASE_T_VIEW', 'Ver');
define('BASE_T_DXLIFF', ' Descargar archivo XLIFF ');

//Top Navigation
define('BASE_HOME', 'Inicio');
define('BASE_NEW_PROJECT', 'Crear proyecto');
define('BASE_TRACK_PROJECTS', 'Control de proyectos');
define('BASE_ABOUT', 'Acerca de...');

//About page
define('BASE_ABOUT_LOCCONNECT', 'Acerca de locConnect..');
define('BASE_ABOUT_CURRENT_VERSION', 'Versión actual:');
define('BASE_ABOUT_LAST_MODIFIED', 'Última modificación:');
define('BASE_ABOUT_DESC', 'Este proyecto ha sido desarrollado con el apoyo del  Centre for Next Generation Localisation y la gestión del Localisation Research Centre en la Universidad de Limerick, Irlanda.');

//index page (home)
define('BASE_INDEX_WHAT_IS', '¿Qué es locConnect?');
define('BASE_INDEX_DESC',
'La localización es un proceso complicado compuesto de muchos pasos
(gestión del proyecto,traducción, revisión, control de calidad, etc) , muchos
idiomas y&nbsp;muchos retos (p. ej. idiomas bidireccionales, distribución
simultánea,&nbsp; grandes volúmenes, etc). A lo largo de los años se han
desarollado un número de componentes (herramientas informáticas) para
&nbsp; responder a las necesidades del proceso de localización. Para producir
un flujo de trabajo automatizado y optimizado, estas herramientas deben 
estar conectadas de forma eficiente.&nbsp; <span style="font-style: italic;">La interoperabilidad</span>
es la clave para una integración con éxito.&nbsp; Sin embargo, lograrla 
es uno de los &nbsp;problemas más complejos en el campo de la localización 
hoy en día.</p><p style="text-align: left;"><br /></p><p style="text-align: left;">LocConnect ha sido desarrollado para 
hacer que los diferentes componentes funcionen como una sola pieza.
Tiene un motor de flujo de trabajo integrado que automatiza el 
funcionamiento de los diferentes componentes.&nbsp; LocConnect es 
totalmente compatible con XLIFF y tiene una interfaz de programación de 
aplicaciones (API) de muy fácil utilización.&nbsp;<br /><br /><img style="border: 1px solid ; width: 336px; height: 205px;" alt="Diagrama que ilustra el funcionamiento de locConnect" src="images/locDiag.jpg" /> </p>
<p><br />LocConnect conecta los componentes a la vez que
gestiona los recursos pertenecientes a cada uno de ellos. 
Facilita la máxima automatización de las tareas de localización.
 &nbsp;LocConnect es ideal para pequenhas y medianas empresas
 que no pueden permitirse una gran inversión en localización.');


//PMUI
define('BASE_PMUI_CREATE_PROJECT', 'Crear un proyecto nuevo');
define('BASE_PMUI_PNAME', 'Nombre del proyecto');
define('BASE_PMUI_PDESC', 'Descripción');
define('BASE_PMUI_PDOMA', 'Campo de conocimiento');
define('BASE_PMUI_PSRCL', 'Lengua de origen');
define('BASE_PMUI_PTGTL', 'Lengua meta');
define('BASE_PMUI_PSTDT', 'Fecha de inicio');
define('BASE_PMUI_PDEAD', 'Fecha límite');
define('BASE_PMUI_PBUDG', 'Presupuesto (â‚¬)');
define('BASE_PMUI_PQAUL', 'Calidad requerida');
define('BASE_PMUI_PMT', 'Usar traducción automática');
define('BASE_PMUI_PRT', 'Evaluar');
define('BASE_PMUI_PCNAME', 'Nombre de la empresa');
define('BASE_PMUI_PCTNAME', 'Persona de contacto');
define('BASE_PMUI_PCTEMAIL', 'Email de contacto');
define('BASE_PMUI_PLMC', 'Archivo LMC');
define('BASE_PMUI_PSRCF', 'Archivo de texto original');
define('BASE_PMUI_PSRCT', 'Texto original<br/> (si no tiene archivo)');
define('BASE_PMUI_CLIENT', 'Cliente');

//track project
define('BASE_TP_AP', 'Proyectos activos');
define('BASE_TP_CP', 'Proyectos finalizados');
define('BASE_TP_TRACK', 'Estado');
define('BASE_TP_DELETE', 'Borrar');
define('BASE_TP_CONFIRM', '¿Está seguro de que quiere borrar el proyecto?');
define('BASE_TP_EDIT', 'Ver|Editar');


// track page

define('BASE_T_STATUS', 'Estado');
define('BASE_T_WORKFLOW', 'Flujo de trabajo');
define('BASE_T_LOADING', 'Cargando');
$arr = array(
 "LKR" => "Catálogo de conocimiento sobre localización",
 "WFR" => "Recomendador de flujos de trabajo", 
 "LMC" => "Contenedor de memorias de localización", 
 "RT" => "Evaluador de traducciones", 
 "MT" => "Traducción automática", 
 "DDC" => "Clasificador del ámbito de datos",
 "CMG" => "Generador de CMS-L10N", 
 "CMP" => "Procesador de CMS-L10N", 
 "COMSIM" => "LocConnect Component Simulator", 
 "DST" => "Traductor de ámbito específico",
 "EXT" => "Extractor",
 "MGR" => "Merger"
 );
$st = array(
 "Processing" => "En proceso",
 "Pending" => "Pendiente", 
 "Complete" => "Completo" );
define('BASE_T_CSTATUS', 'Estado actual:');
define('BASE_T_PF', ' Proyecto concluído el ');
define('BASE_T_ORCON', ' o continuar ');
define('BASE_T_POST', ' post edición ');
define('BASE_T_INL', ' en locConnect.');
define('BASE_T_STO', 'Estado & Resultados');
define('BASE_T_COM', 'Componente');
define('BASE_T_PICKED', 'Iniciado');
define('BASE_T_OUTON', 'Concluido');
define('BASE_T_OUTPUT', 'Resultado');
define('BASE_T_FB', 'Observaciones');

define('BASE_T_XMETA', 'Metadatos del proyecto');
define('BASE_T_XFILE', 'Metadatos del XLIFF ');
define('BASE_T_XWF', 'Metadatos de flujo de trabajo');
define('BASE_T_XPM', 'Metadatos de fase del XLIFF');
define('BASE_T_XTM', 'Metadatos del herramientas para XLIFF ');
define('BASE_T_XCGM', 'Metadatos de cuentas del XLIFF');
define('BASE_T_XNM', 'Metadatos de las notas del XLIFF');

//XLIFF Editor
define('BASE_XLFV_EDITOR', ' Editor de XLIFF ');
define('BASE_XLFV_PEDIT', ' Post edición ');
define('BASE_XLFV_SRC', 'original');
define('BASE_XLFV_TGT', 'meta');
define('BASE_XLFV_ALT', 'Tranducciones alternativas');
define('BASE_XLFV_TRAN', 'Traducciones');
define('BASE_XLFV_META', 'Metadatos');
define('BASE_XLFV_SRCERR', '(no se encuentra el texto original)');
define('BASE_XLFV_TGTERR', '(no se encuentra el texto meta)');
define('BASE_XLFV_ALTERR', 'no se encuentran traducciones alternativas');
define('BASE_XLFV_HIDET', 'ocultar traducciones');
define('BASE_XLFV_HIDEM', 'ocultar metadatos');
define('BASE_XLFV_DOWNTF', 'Descargar ');
define('BASE_XLFV_PREVF', 'Vista preliminar del archivo traducido');

//XLIFF Viwer
define('BASE_XLFV_OUTOF', ' Resultado de ');

//create_project
define('BASE_CP_SOURCEERR', 'El tipo de archivo original que ha intentado subir no es válido');
define('BASE_CP_SOURCEERR_LARGE', 'El archivo original que ha intentado subir es demasiado grande.');
define('BASE_CP_RESERR','El tipo de archivo de recursos que ha intentado subir no es válido.');
define('BASE_CP_RESERR_LARGE','El archivo original que ha intentado subir es demasiado grande.');
define('BASE_CP_UPLOADERR','No puede subir archivos a la carpeta especificada');
define('BASE_CP_UPLOADERR_RES','Ha habido un problema al subir el archivo. Por favor, vuelva a intentarlo.');
define('BASE_CP_SUCCESS', 'El proyecto se ha creado correctamente');
define('BASE_CP_SUCCESS_M1', 'El archivo se ha subido correctamente<br/>\n');
define('BASE_CP_SUCCESS_M2', 'El número de identificación (ID) del proyecto es: ');
define('BASE_CP_SUCCESS_M3', 'Puede ver el estado del proyecto pulsando ');
define('BASE_CP_SUCCESS_M4', 'aquí');
define('BASE_CP_SUCCESS_M5', 'El archivo de recursos se ha subido correctamente y puede accederse usando la ID de recurso:');
define('BASE_CP_UPLOADERR_SRC','Ha habido un problema al subir el archivo. Por favor, vuelva a intentarlo.');
define('BASE_CP_UPLOADERR_TXT','Por favor, introduzca una vez más el texto que quiere traducir y  vuelva a intentarlo ');
define('BASE_CP_SUCCESS_M6','El texto original que ha sido convertido en XLIFF correctamente y se ha creado un proyecto de locConnect.<br/>\n');

//delete
define('BASE_D_SUCCESS', 'Se han borrado el proyecto y los archivos asociados.');


//xconv
define('BASE_XCONV_PREVIEW', 'Vista previa');
define('BASE_XCONV_BACK', 'Volver al editor de XLIFF');
define('BASE_PMUI_PSRCXLIFF', 'Archivo XLIFF original');
define('BASE_PMUI_INPUT_SOURCE', 'Elija la fuente de entrada de datos:');
define('BASE_PMUI_TEXT_INPUT', 'Archivo de texto o inserción de texto');
define('BASE_PMUI_XLIFF_INPUT', 'Archivo XLIFF');

//locConnect UI Translations
define('BASE_UI_TRANS_BY', 'Paquete de interfaz de idioma español para locConnect mantenido por Aram Morera Mesa, última actualización: 15-10-2010');

$languages = array(
 "en" => "..",
 "es" => ".");

//function curPageName() {
 //return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
//}

function curPageName() {
 $pageURL = 'http';
 //if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return substr($pageURL,strrpos($pageURL,"/")+1);
}

?>
