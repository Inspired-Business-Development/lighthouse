<?php
/* 
 * Lighthouse Bootstrap
 */
//Set Default Timezone
date_default_timezone_set('America/Detroit');

//Define and Build MakeSafe Data Validation Object [$MakeSafe]
include 'class/MakeSafe.class.php';$MakeSafe=new MakeSafe();

/* Define Constants
 * 
 * ACTION_PATH: Action Path
 * BASE_URL: Domain Name
 * DOC_ROOT: Absolute path to the root directory
 * REQ_PATH: Requested Path
 * REQ_TS: Unix timestamp for this request
 * VISIT_IPA: Absolute path to the root directory
 */
if($action_path=$MakeSafe->thisData("a","FORMATTED_STRING","","","GET")){define("ACTION_PATH",$action_path);unset($action_path);}else{define("ACTION_PATH","/home/");} //Get Action Path [ACTION_PATH]
if($svr_name=$MakeSafe->thisData("SERVER_NAME","STRICT_STRING","","","SERVER")){define("BASE_URL",$svr_name);unset($svr_name);}else{die('FATAL ERROR - SERVER CONFIGURATION ERROR');} //Define Domain Name [BASE_URL]
if($root=realpath($MakeSafe->thisData("DOCUMENT_ROOT","FORMATTED_STRING","","","SERVER"))){define("DOC_ROOT",$root);unset($root);}else{die('FATAL ERROR - SERVER CONFIGURATION ERROR');} //Absolute path to the root directory [DOC_ROOT]
if($req_path=$MakeSafe->thisData("REQUEST_URI","FORMATTED_STRING","","","SERVER")){define("REQ_PATH",$req_path);unset($req_path);}else{die('FATAL ERROR - SERVER CONFIGURATION ERROR');} //Requested Path [REQ_PATH]
define("REQ_TS",time()); //Unix timestamp for this request [REQ_TS]
if($visit_ipa=$MakeSafe->thisData("REMOTE_ADDR","STRICT_STRING","","","SERVER")){define("VISIT_IPA",$visit_ipa);unset($visit_ipa);}else{define("VISIT_IPA","NONE");} //Visitors IP Address [VISIT_IPA]

//Define PHP Class Autoloader Function
spl_autoload_register(function($class){include DOC_ROOT.'/asset/class/'.$class .'.class.php';});

//Build Lighthouse Database Object [$lhDB]
$lhDB=new lhDB();

?>