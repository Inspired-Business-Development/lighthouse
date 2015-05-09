<?php
/*
 * CLASS DESCRIPTION:
 * 
 */
final class Servlet{
/* CLASS PROPERTIES */
//PRIVATE SCOPE
private $requireLogin;
private $requirePostDefender;
private $userHasLogin;

//PROTECTED SCOPE

//PUBLIC SCOPE
public $resultArray;

/* CLASS OBJECTS */
//PRIVATE SCOPE
private $MakeSafe;
private $lhDB;

//PROTECTED SCOPE

//PUBLIC SCOPE
public $PostDefender;
public $Session;
public $lhUser;

/* CLASS METHODS */
//PRIVATE SCOPE

//PROTECTED SCOPE

//PUBLIC SCOPE
public function returnErr($errMode,$errMsg=""){$this->resultArray=array("rslt"=>$errMode,"msg"=>$errMsg);$JSON_DATA=json_encode($this->resultArray);die($JSON_DATA);}
public function returnSuccess($rtnData=""){$this->resultArray=array("rslt"=>"SUCCESS","rtnData"=>$rtnData);$JSON_DATA=json_encode($this->resultArray);die($JSON_DATA);}
public function startScript(){
    
    //Validate Post Token
    if($this->requirePostDefender){
        if(!$pTkn=$this->MakeSafe->thisData('pTkn','PARANOID_STRING',32,32,"POST")){self::returnErr("POST_DEFENDER");}
        if(!$lightSessID=$this->MakeSafe->thisData('lightSessID','PARANOID_STRING',"","","POST")){self::returnErr("POST_DEFENDER");}
        $this->PostDefender=new PostDefender($this->MakeSafe,$this->lhDB);
        if(!$this->PostDefender->validatePostToken($pTkn,$lightSessID)){self::returnErr("POST_DEFENDER");}
    }
    
    //Authorize User or return session authentication error
    $this->Session=new Session($this->MakeSafe,$this->lhDB);
    $uid=$this->Session->validateCurrentSession();
    if($uid!=false){$this->lhUser=new lhUser($uid);$this->userHasLogin=true;}
    else{if($this->requireLogin){self::returnErr("SESS_AUTH_ERR");}}

}

/* CLASS CONSTRUCT METHOD */
public function __construct($MakeSafe,$lhDB,$servletConfg){$this->MakeSafe=$MakeSafe;unset($MakeSafe);$this->lhDB=$lhDB;unset($lhDB);/* START CONSTRUCT METHOD DEFINITION */
    if(isset($servletConfg['requireLogin'])){$this->requireLogin=$servletConfg['requireLogin'];}else{$this->requireLogin=true;}
    if(isset($servletConfg['postDefender'])){$this->requirePostDefender=$servletConfg['postDefender'];}else{$this->requirePostDefender=true;}
    $this->userHasLogin=false;
}/* [END CONSTRUCT METHOD DEFINITION] */}?>