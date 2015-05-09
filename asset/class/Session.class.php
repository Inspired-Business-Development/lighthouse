<?php
/*
 * CLASS DESCRIPTION:
 * Handles session based user authentication.
 */
final class session{
/* CLASS PROPERTIES */
//PRIVATE SCOPE
private $created; //Session Creation [DATETIME]
private $phpsid; //PHP Session ID
private $sectknslt; //Security Token Salt
private $sectkn; //Security Token
private $valid; //Session is Valid [BOOLEAN]
private $uid; //User ID

//PROTECTED SCOPE

//PUBLIC SCOPE

/* CLASS OBJECTS */
//PRIVATE SCOPE
private $MakeSafe;
private $lhDB;

//PROTECTED SCOPE

//PUBLIC SCOPE

/* CLASS METHODS */
//PRIVATE SCOPE
private function getCurrentPhpSid(){if($this->phpsid=$this->MakeSafe->thisData("PHPSESSID","PARANOID_STRING",26,32,"COOKIE")){$this->valid=true;}else{$this->valid=false;}}
private function validatePhpSid(){
    if($this->valid){$this->valid=false;
	$SELECT_RECORD=$this->lhDB->PDO->prepare("SELECT * FROM `tbl_session` WHERE `phpsid`=:phpsid LIMIT 1");
	$SELECT_RECORD->bindParam(':phpsid',$this->phpsid);$SELECT_RECORD->execute();
	if($R=$SELECT_RECORD->fetch(PDO::FETCH_ASSOC)){$SELECT_RECORD->closeCursor();
            if($srec_id=$this->MakeSafe->thisData($R['srec_id'],'NUMBER')){
		if($created=$this->MakeSafe->thisData($R['created'],'DATETIME')){
                    if($uid=$this->MakeSafe->thisData($R['uid'],'PARANOID_STRING',32,32)){
			if($sectkn=$this->MakeSafe->thisData($R['sectkn'],'PARANOID_STRING',128,128)){
                            if($sctkslt=$this->MakeSafe->thisData($R['sctkslt'],'PARANOID_STRING',128,128)){unset($R);$created_ts=strtotime($created);$age=REQ_TS-$created_ts;
				if($age<=1800){$this->sectkn=hash("whirlpool",$sctkslt.$_SERVER['HTTP_USER_AGENT'].$uid);
                                    if($this->sectkn==$sectkn){$this->uid=$uid;self::startSession();
                                        $UPDATE_RECORD=$this->lhDB->PDO->prepare("UPDATE `tbl_session` SET `created`=:created,`phpsid`=:phpsid WHERE `srec_id`=:srec_id LIMIT 1");
                                        $UPDATE_RECORD->bindParam(':created',$this->created);$UPDATE_RECORD->bindParam(':phpsid',$this->phpsid);$UPDATE_RECORD->bindParam(':srec_id',$srec_id);
                                        $UPDATE_RECORD->execute();$UPDATE_RECORD->closeCursor();$this->valid=true;
                                    }
				}else{$DELETE_RECORD=$this->lhDB->PDO->prepare("DELETE FROM `tbl_session` WHERE `srec_id`=:srec_id LIMIT 1");$DELETE_RECORD->bindParam(':srec_id',$srec_id);$DELETE_RECORD->execute();$DELETE_RECORD->closeCursor();}
                            }else{unset($R);}
			}else{unset($R);}
                    }else{unset($R);}
		}else{unset($R);}
            }else{unset($R);}
	}else{$SELECT_RECORD->closeCursor();}
    }
}
private function startSession(){$this->created=date("Y-m-d H:i:s",REQ_TS);
    switch(BASE_URL){
        case"ibdlighthouse.com":session_set_cookie_params(1800,'/',BASE_URL,FALSE,TRUE);break;
        case"dev.ibdlighthouse.com":session_set_cookie_params(1800,'/',BASE_URL,FALSE,TRUE);break;
        case"local.ibdlighthouse.com":session_set_cookie_params(1800,'/',BASE_URL,FALSE,TRUE);break;
    default:}session_start();$_SESSION=array();$this->phpsid=session_id();
}
private function deleteExpiredSessions($uid){
    $SELECT_USR_SESSIONS=$this->lhDB->PDO->prepare("SELECT `srec_id`,`created`,`uid` FROM `tbl_session` WHERE `uid`=:uid");
    $SELECT_USR_SESSIONS->bindParam(':uid',$uid);
    $SELECT_USR_SESSIONS->execute();$sary=array();$recCnt=0;
    while($R=$SELECT_USR_SESSIONS->fetch(PDO::FETCH_ASSOC)){$sary[$recCnt]=array();
        $sary[$recCnt]['rid']=$R['srec_id'];
        $sary[$recCnt]['created']=$R['created'];
    $recCnt++;}
    $SELECT_USR_SESSIONS->closeCursor();unset($R);
    if($recCnt!=0){unset($recCnt);
        foreach($sary as $selSess){
            $rid=$selSess['rid'];
            $created=$selSess['created'];
            $created_ts=strtotime($created);$age=REQ_TS-$created_ts;
            if($age>=1800){$DELETE_EXPIRED_RECORD=$this->lhDB->PDO->prepare("DELETE FROM `tbl_session` WHERE `srec_id`=:srec_id LIMIT 1");
                $DELETE_EXPIRED_RECORD->bindParam(':srec_id',$rid);
                $DELETE_EXPIRED_RECORD->execute();
                $DELETE_EXPIRED_RECORD->closeCursor();
                return true;
            }else{return true;}
        }
    }else{return true;}
}

private function deleteCurrentPhpSid(){if($this->valid){$this->valid=false;$DELETE_CURRENT_RECORD=$this->lhDB->PDO->prepare("DELETE FROM `tbl_session` WHERE `phpsid`=:phpsid LIMIT 1");$DELETE_CURRENT_RECORD->bindParam(':phpsid',$this->phpsid);$DELETE_CURRENT_RECORD->execute();$DELETE_CURRENT_RECORD->closeCursor();}}

//PROTECTED SCOPE

//PUBLIC SCOPE
public function validateCurrentSession(){$this->lhDB->connect('ibdlhsession');self::getCurrentPhpSid();self::validatePhpSid();$this->lhDB->disconnect();if($this->valid){$uid=$this->uid;return $uid;}else{return false;}}

public function buildNewSession($uid){$this->lhDB->connect('ibdlhsession');
    if(self::deleteExpiredSessions($uid)){self::getCurrentPhpSid();
        if($this->valid){self::deleteCurrentPhpSid();}
        $a=uniqid();$this->sctkslt=hash("whirlpool",$a.$uid);unset($a);
        $this->sectkn=hash("whirlpool",$this->sctkslt.$_SERVER['HTTP_USER_AGENT'].$uid);
        self::startSession();
        $INSERT_NEW_SESSION=$this->lhDB->PDO->prepare("INSERT INTO `tbl_session` (`created`,`uid`,`phpsid`,`sectkn`,`sctkslt`) VALUES (:created,:uid,:phpsid,:sectkn,:sctkslt)");
        $INSERT_NEW_SESSION->bindParam(':created',$this->created);
        $INSERT_NEW_SESSION->bindParam(':uid',$uid);
        $INSERT_NEW_SESSION->bindParam(':phpsid',$this->phpsid);
        $INSERT_NEW_SESSION->bindParam(':sectkn',$this->sectkn);
        $INSERT_NEW_SESSION->bindParam(':sctkslt',$this->sctkslt);
        $INSERT_NEW_SESSION->execute();$INSERT_NEW_SESSION->closeCursor();
    }else{die('FATAL ERROR -> SESSION::BUILD_NEW_SESSION - "Error deleting expired sessions"');}
    $this->lhDB->disconnect();
}

public function destroyCurrentSession(){$this->lhDB->connect('ibdlhsession');self::getCurrentPhpSid();self::deleteCurrentPhpSid();$this->lhDB->disconnect();session_unset();session_destroy();}

/* CLASS CONSTRUCT METHOD */
public function __construct($MakeSafe,$lhDB){$this->MakeSafe=$MakeSafe;unset($MakeSafe);$this->lhDB=$lhDB;unset($lhDB);/* START CONSTRUCT METHOD DEFINITION */
	$this->valid=false;
}/* [END CONSTRUCT METHOD DEFINITION] */}?>