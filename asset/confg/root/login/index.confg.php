<?php
/*
 * Action Path: /login/
 */

//Webpage Configuration Settings
$webPageConfg=array(
    "requireLogin"=>false,
    "saveForInterrupt"=>false,
    "postDefender"=>true,
    "foundation"=>array(
        "pageTitle"=>"Login:Lighthouse",
        "favIcon"=>"/favicon.ico",
        "mode"=>"GUEST",
        "globalSpace"=>array(
            "globalOverlay"=>true,
            "globalNotify"=>false,
            "pageTopBtn"=>false,
        ),
        "topBar"=>false,
	"onTab"=>false,
	"style"=>false,
	"script"=>array(
            "login/index.js",
        ),
        "runTime"=>false,
        "docFoundOpts"=>false,
    ),
);




?>