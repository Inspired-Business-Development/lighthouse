<?php 
/* 
 * Lighthouse Index Page
 * Version: 2.0.0
 */

//Set Default Timezone
date_default_timezone_set('America/Detroit');

//Define and Build MakeSafe Data Validation Object [$MakeSafe]
include '/asset/MakeSafe.class.php';$MakeSafe=new MakeSafe();

/* Define Constants
 * 
 * ACTION_PATH: Action Path
 * BASE_URL: Domain Name
 * DOC_ROOT: Absolute path to the root directory
 * REQ_PATH: Requested Path
 * REQ_TS: Unix timestamp for this request
 * VISIT_IPA: Absolute path to the root directory
 */
if($action_path=$MakeSafe->thisData("a","FORMATTED_STRING","","","GET")){define("ACTION_PATH",$action_path);unset($action_path);}else{define("ACTION_PATH","/");} //Get Action Path [ACTION_PATH]
if($svr_name=$MakeSafe->thisData("SERVER_NAME","STRICT_STRING","","","SERVER")){define("BASE_URL",$svr_name);unset($svr_name);}else{die('FATAL ERROR - SERVER CONFIGURATION ERROR');} //Define Domain Name [BASE_URL]
if($root=realpath($MakeSafe->thisData("DOCUMENT_ROOT","FORMATTED_STRING","","","SERVER"))){define("DOC_ROOT",$root);unset($root);}else{die('FATAL ERROR - SERVER CONFIGURATION ERROR');} //Absolute path to the root directory [DOC_ROOT]
if($req_path=$MakeSafe->thisData("REQUEST_URI","FORMATTED_STRING","","","SERVER")){define("REQ_PATH",$req_path);unset($req_path);}else{die('FATAL ERROR - SERVER CONFIGURATION ERROR');} //Requested Path [REQ_PATH]
define("REQ_TS",time()); //Unix timestamp for this request [REQ_TS]
if($visit_ipa=$MakeSafe->thisData("REMOTE_ADDR","STRICT_STRING","","","SERVER")){define("VISIT_IPA",$visit_ipa);unset($visit_ipa);}else{define("VISIT_IPA","NONE");} //Visitors IP Address [VISIT_IPA]

//Define PHP Class Autoloader Function
spl_autoload_register(function($class){include DOC_ROOT.'/asset/class/'.$class .'.class.php';});

//Build Lighthouse Database Object [$lhDB]
$lhDB=new lhDB();

//Set the Last Request Cookie
switch(BASE_URL){
    case"ibdlighthouse.com":setcookie("IBDLH_LREQ_URL",REQ_PATH,time()+60*60*24*30,"/",BASE_URL,false,true);break; //Store Cookie for Live Site
    case"dev.ibdlighthouse.com":setcookie("DEV_IBDLH_LREQ_URL",REQ_PATH,time()+60*60*24*30,"/",BASE_URL,false,true);break; //Store Cookie for Development Site
    case"local.ibdlighthouse.com":setcookie("LOCAL_IBDLH_LREQ_URL",REQ_PATH,time()+60*60*24*30,"/",BASE_URL,false,true);break; //Store Cookie for Training Site
default:}
	
//Load Requested Page Configuration Files
if(ACTION_PATH=="/"){include '/asset/confg/root/index.confg.php';}else{$aPath=explode("/",ACTION_PATH);
    
    switch($aPath[0]){
        
    default:}

}













//Authorize User or redirect to login page
$Session=new Session($MakeSafe,$lhDB);
$uid=$Session->validateCurrentSession();
if($uid!=false){
    $lhUser=new lhUser($uid);
    $has_login=true;
    if(!$lhUser->setLastPageViewed()){die('FATAL_ERROR -> Failed to set Last URL Viewed');}
}else{
    if($require_login==true){
        header('Location: /login/index.php?i=t');
    }else{$has_login=false;}
}







//Define URL Rewriting Script
$urlRewriteScript='<script>var a="'.ACTION_PATH.'";var stateObj={foo:"bar"};history.pushState(stateObj,"",aPath);</script>';









//print_r($aPath);

echo $_SERVER["REQUEST_URI"];

?>