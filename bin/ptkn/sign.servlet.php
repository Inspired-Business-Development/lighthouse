<?php
/* 
 * Sign Post Token Servlet
 */

//Load Lighthouse Bootstrap
include '../../asset/lighthouse.bootstrap.php';

//Servlet Configuration Settings
$servletConfg=array(
    "requireLogin"=>false,
    "postDefender"=>false,
);

//Build Servlet Object
$servletObj=new Servlet($MakeSafe,$lhDB,$servletConfg);$servletObj->startScript();

//Validate & Sanitize Input
if(!$pTkn=$MakeSafe->thisData('pTkn','PARANOID_STRING',32,32,"POST")){$servletObj->returnErr("ERR");}
if(!$lightSessID=$MakeSafe->thisData('lightSessID','PARANOID_STRING',128,128,"POST")){$servletObj->returnErr("ERR");}

$PostDefender=new PostDefender($MakeSafe,$lhDB);
$isSigned=$PostDefender->signPostToken($pTkn,$lightSessID);
if($isSigned){$servletObj->returnSuccess();}
else{$servletObj->returnErr("ERR");}

?>