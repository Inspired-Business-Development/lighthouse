<?php
/* 
 * Try Login Servlet
 */

//Load Lighthouse Bootstrap
include '../../asset/lighthouse.bootstrap.php';

//Servlet Configuration Settings
$servletConfg=array(
    "requireLogin"=>false,
    "postDefender"=>true,
);

//Build Servlet Object
$servletObj=new Servlet($MakeSafe,$lhDB,$servletConfg);$servletObj->startScript();

//Validate Username Input
if(!$username=$MakeSafe->thisData('username','PARANOID_STRING',1,32,"POST")){$servletObj->returnErr("ERR","Invalid Username");}

//Set or Unset Remember Me Cookie
$rembrUsn=$MakeSafe->thisData('rembrUsn','PARANOID_STRING',"","","POST");
if($rembrUsn==true){
    switch(BASE_URL){
        case"ibdlighthouse.com":setcookie("IBDLH_REMRUN",$username,time()+60*60*24*30,"/",BASE_URL,false,true);break;
        case"dev.ibdlighthouse.com":setcookie("DEV_IBDLH_REMRUN",$username,time()+60*60*24*30,"/",BASE_URL,false,true);break;
        case"local.ibdlighthouse.com":setcookie("LOCAL_IBDLH_REMRUN",$username,time()+60*60*24*30,"/",BASE_URL,false,true);break;
    default:}
}else{
    switch(BASE_URL){
        case"ibdlighthouse.com":if(isset($_COOKIE['IBDLH_REMRUN'])){unset($_COOKIE['IBDLH_REMRUN']);setcookie('IBDLH_REMRUN','',time()-3600,"/",BASE_URL,false,true);}break;
        case"dev.ibdlighthouse.com":if(isset($_COOKIE['DEV_IBDLH_REMRUN'])){unset($_COOKIE['DEV_IBDLH_REMRUN']);setcookie('DEV_IBDLH_REMRUN','',time()-3600,"/",BASE_URL,false,true);}break;
        case"local.ibdlighthouse.com":if(isset($_COOKIE['LOCAL_IBDLH_REMRUN'])){unset($_COOKIE['LOCAL_IBDLH_REMRUN']);setcookie('LOCAL_IBDLH_REMRUN','',time()-3600,"/",BASE_URL,false,true);}break;
    default:}
}

//Validate Password Input
if(!$password=$MakeSafe->thisData('password','PASSWORD_STRING',"","","POST")){$servletObj->returnErr("ERR","Invalid Password");}

//Check for Username & Password Match
$lhDB->connect('ibdlighthouse');
$SELECT_CREDENTIALS=$lhDB->PDO->prepare("SELECT `uid`,`pwd` FROM `tbl_user_login` WHERE `usn`=:usn");
$SELECT_CREDENTIALS->bindParam(':usn',$username);$SELECT_CREDENTIALS->execute();
if($R=$SELECT_CREDENTIALS->fetch(PDO::FETCH_ASSOC)){$SELECT_CREDENTIALS->closeCursor();
    if($password==$R['pwd']){
        if($uid=$MakeSafe->thisData($R['uid'],'PARANOID_STRING',32,32)){unset($R);
            $AUTHENTICATE_USER=$lhDB->PDO->prepare("SELECT `archived`,`lastUrl` FROM `tbl_user` WHERE `uid`=:uid LIMIT 1");
            $AUTHENTICATE_USER->bindParam(':uid',$uid);$AUTHENTICATE_USER->execute();
            if($R=$AUTHENTICATE_USER->fetch(PDO::FETCH_ASSOC)){$AUTHENTICATE_USER->closeCursor();
		if($R['archived']==0){if(!$lastURL=$MakeSafe->thisData($R['lastUrl'],'URL_STRING')){$servletObj->returnErr("ERR","Unexpected Error. Please try again.");}unset($R);
                    
                    //Log this Login
                    $created=date("Y-m-d H:i:s",REQ_TS);$ipAddr=VISIT_IPA;
                    $LOG_USER_LOGIN=$lhDB->PDO->prepare("INSERT INTO `log_user_login` (`created`,`uid`,`ipAddr`) VALUES (:created,:uid,:ipAddr)");
                    $LOG_USER_LOGIN->bindParam(':created',$created);
                    $LOG_USER_LOGIN->bindParam(':uid',$uid);
                    $LOG_USER_LOGIN->bindParam(':ipAddr',$ipAddr);
                    $LOG_USER_LOGIN->execute();
                    
                    //Build New Session
                    $Session=new Session($MakeSafe,$lhDB);
                    $Session->buildNewSession($uid);
                    
                    //Return Successfully with lastUrl data
                    $servletObj->returnSuccess($lastURL);
                    
		}else{$servletObj->returnErr("ERR","Incorrect Username or Password.");}
            }else{$AUTHENTICATE_USER->closeCursor();$servletObj->returnErr("ERR","Unexpected Error. Please try again.");}
	}else{$servletObj->returnErr("ERR","Unexpected Error. Please try again.");}
    }else{$servletObj->returnErr("ERR","Incorrect Username or Password.");}
}else{$SELECT_CREDENTIALS->closeCursor();$servletObj->returnErr("ERR","Incorrect Username or Password.");}


?>