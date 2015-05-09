<?php 
/* 
 * Lighthouse Index Page
 */

//Load Lighthouse Bootstrap
include '/asset/lighthouse.bootstrap.php';

//Use Action Path Engine to Get Path to Webpage Config and View Files
$aPathEngine=new ActionPathEngine($MakeSafe,$lhDB);
$pathToConfgFile=$aPathEngine->getConfgFilePath();
$pathToViewFile=$aPathEngine->getViewFilePath();

//Load Webpage Config File
include $pathToConfgFile;

//Prepare in case of Login Interrupt
if($webPageConfg['saveForInterrupt']){switch(BASE_URL){
    case"ibdlighthouse.com":setcookie("IBDLH_LREQ_URL",ACTION_PATH,time()+60*60*24*30,"/",BASE_URL,false,true);break; //Store Cookie for Live Site
    case"dev.ibdlighthouse.com":setcookie("DEV_IBDLH_LREQ_URL",ACTION_PATH,time()+60*60*24*30,"/",BASE_URL,false,true);break; //Store Cookie for Development Site
    case"local.ibdlighthouse.com":setcookie("LOCAL_IBDLH_LREQ_URL",ACTION_PATH,time()+60*60*24*30,"/",BASE_URL,false,true);break; //Store Cookie for Training Site
default:}}

//Authorize User or redirect to login page
$Session=new Session($MakeSafe,$lhDB);
$uid=$Session->validateCurrentSession();
if($uid!=false){
    $lhUser=new lhUser($uid);
    if(!$lhUser->setLastPageViewed()){die('FATAL_ERROR -> Failed to set Last URL Viewed');}
    $userHasLogin=true;
}else{
    if($webPageConfg['requireLogin']){header('Location: /login/i/');}
    $userHasLogin=false;
}

//Configure Lighthouse Post Token
if($webPageConfg['postDefender']){
    $PostDefender=new PostDefender($MakeSafe,$lhDB);
    $pTkn=$PostDefender->generatePostToken();
}else{$pTkn="";}

//Build Foundation Object
if(!$userHasLogin){$lhUser="NONE";}
$Foundation=new Foundation($MakeSafe,$lhDB,$webPageConfg['foundation'],$pTkn,$lhUser);

//Render Top Wrapper
$Foundation->renderTopWrapper();

//Load Webpage View File
include $pathToViewFile;

//Render Bottom Wrapper
$Foundation->renderBottomWrapper();

?>