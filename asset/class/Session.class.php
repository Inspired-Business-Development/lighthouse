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
private $MakeSafe; // Data Validation Object
private $DataBase; // Database Object

//PROTECTED SCOPE

//PUBLIC SCOPE

/* CLASS METHODS */
//PRIVATE SCOPE
private function GET_CURRENT_PHPSID(){
	if(isset($_COOKIE['PHPSESSID'])){
		if($this->PHPSID=$this->MSOBJ->VALIDATE($_COOKIE['PHPSESSID'],'PARANOID_STRING',26,32)){$this->VALID=true;}
		else{$this->VALID=false;}
	}else{$this->VALID=false;}
}
private function VALIDATE_PHPSID(){
	if($this->VALID){$this->VALID=false;
		$SELECT_RECORD=$this->DBO->PDO->prepare("SELECT * FROM `tbl_session` WHERE `PHPSID`=:PHPSID LIMIT 1");
		$SELECT_RECORD->bindParam(':PHPSID',$this->PHPSID);$SELECT_RECORD->execute();
		if($R=$SELECT_RECORD->fetch(PDO::FETCH_ASSOC)){$SELECT_RECORD->closeCursor();
			if($RID=$this->MSOBJ->VALIDATE($R['SREC_ID'],'NUMBER')){
				if($CREATED=$this->MSOBJ->VALIDATE($R['CREATED'],'DATETIME')){
					if($UID=$this->MSOBJ->VALIDATE($R['UID'],'PARANOID_STRING',32,32)){
						if($SECTKN=$this->MSOBJ->VALIDATE($R['SECTKN'],'PARANOID_STRING',128,128)){
							if($SCTKSLT=$this->MSOBJ->VALIDATE($R['SCTKSLT'],'PARANOID_STRING',128,128)){unset($R);$CREATED_TS=strtotime($CREATED);$AGE=REQ_TS-$CREATED_TS;
								if($AGE<=1800){$this->SECTKN=hash("whirlpool",$SCTKSLT.$_SERVER['HTTP_USER_AGENT'].$UID);
									if($this->SECTKN==$SECTKN){$this->UID=$UID;self::START_SESSION();
										$UPDATE_RECORD=$this->DBO->PDO->prepare("UPDATE `tbl_session` SET `CREATED`=:CREATED,`PHPSID`=:PHPSID WHERE `SREC_ID`=:RID LIMIT 1");
										$UPDATE_RECORD->bindParam(':CREATED',$this->CREATED);$UPDATE_RECORD->bindParam(':PHPSID',$this->PHPSID);$UPDATE_RECORD->bindParam(':RID',$RID);
										$UPDATE_RECORD->execute();$UPDATE_RECORD->closeCursor();$this->VALID=true;
									}
								}else{$DELETE_RECORD=$this->DBO->PDO->prepare("DELETE FROM `tbl_session` WHERE `SREC_ID`=:RID LIMIT 1");
									$DELETE_RECORD->bindParam(':RID',$RID);$DELETE_RECORD->execute();$DELETE_RECORD->closeCursor();}
							}else{unset($R);}
						}else{unset($R);}
					}else{unset($R);}
				}else{unset($R);}
			}else{unset($R);}
		}else{$SELECT_RECORD->closeCursor();}
	}
}
private function START_SESSION(){$this->CREATED=date("Y-m-d H:i:s",REQ_TS);
	switch(BASE_URL){
		case"ibdlighthouse.com":session_set_cookie_params(1800,'/',BASE_URL,FALSE,TRUE);break;
		case"dev.ibdlighthouse.com":session_set_cookie_params(1800,'/',BASE_URL,FALSE,TRUE);break;
		case"train.ibdlighthouse.com":session_set_cookie_params(1800,'/',BASE_URL,FALSE,TRUE);break;
	default:}session_start();$_SESSION=array();$this->PHPSID=session_id();
}
private function DELETE_EXPIRED_SESSIONS($UID){
	$SELECT_USR_SESSIONS=$this->DBO->PDO->prepare("SELECT `SREC_ID`,`CREATED`,`UID` FROM `tbl_session` WHERE `UID`=:UID");
	$SELECT_USR_SESSIONS->bindParam(':UID',$UID);
	$SELECT_USR_SESSIONS->execute();$SARY=array();$R_CNT=0;
	while($R=$SELECT_USR_SESSIONS->fetch(PDO::FETCH_ASSOC)){$SARY[$R_CNT]=array();
		$SARY[$R_CNT]['RID']=$R['SREC_ID'];
		$SARY[$R_CNT]['CREATED']=$R['CREATED'];
	$R_CNT++;}
	$SELECT_USR_SESSIONS->closeCursor();unset($R);
	if($R_CNT!=0){unset($R_CNT);
		foreach($SARY as $SELS){
			$RID=$SELS['RID'];
			$CREATED=$SELS['CREATED'];
			$CREATED_TS=strtotime($CREATED);$AGE=REQ_TS-$CREATED_TS;
			if($AGE>=1800){$DELETE_EXPIRED_RECORD=$this->DBO->PDO->prepare("DELETE FROM `tbl_session` WHERE `SREC_ID`=:RID LIMIT 1");
				$DELETE_EXPIRED_RECORD->bindParam(':RID',$RID);
				$DELETE_EXPIRED_RECORD->execute();
				$DELETE_EXPIRED_RECORD->closeCursor();
				return true;
			}else{return true;}
		}
	}else{return true;}
}

private function DELETE_CURRENT_PHPSID(){if($this->VALID){$this->VALID=false;$DELETE_CURRENT_RECORD=$this->DBO->PDO->prepare("DELETE FROM `tbl_session` WHERE `PHPSID`=:PHPSID LIMIT 1");$DELETE_CURRENT_RECORD->bindParam(':PHPSID',$this->PHPSID);$DELETE_CURRENT_RECORD->execute();$DELETE_CURRENT_RECORD->closeCursor();}}

//PROTECTED SCOPE

//PUBLIC SCOPE
public function VALIDATE_CURRENT_SESSION(){$this->DBO->CONNECT('ibdlhsession');self::GET_CURRENT_PHPSID();self::VALIDATE_PHPSID();$this->DBO->DISCONNECT();if($this->VALID){$UID=$this->UID;return $UID;}else{return false;}}

public function BUILD_NEW_SESSION($UID){$this->DBO->CONNECT('ibdlhsession');
	if(self::DELETE_EXPIRED_SESSIONS($UID)){self::GET_CURRENT_PHPSID();
		if($this->VALID){self::DELETE_CURRENT_PHPSID();}
		$a=uniqid();$this->SCTKSLT=hash("whirlpool",$a.$UID);unset($a);
		$this->SECTKN=hash("whirlpool",$this->SCTKSLT.$_SERVER['HTTP_USER_AGENT'].$UID);
		self::START_SESSION();
		$INSERT_NEW_SESSION=$this->DBO->PDO->prepare("INSERT INTO `tbl_session` (`CREATED`,`UID`,`PHPSID`,`SECTKN`,`SCTKSLT`) VALUES (:CREATED,:UID,:PHPSID,:SECTKN,:SCTKSLT)");
		$INSERT_NEW_SESSION->bindParam(':CREATED',$this->CREATED);
		$INSERT_NEW_SESSION->bindParam(':UID',$UID);
		$INSERT_NEW_SESSION->bindParam(':PHPSID',$this->PHPSID);
		$INSERT_NEW_SESSION->bindParam(':SECTKN',$this->SECTKN);
		$INSERT_NEW_SESSION->bindParam(':SCTKSLT',$this->SCTKSLT);
		$INSERT_NEW_SESSION->execute();$INSERT_NEW_SESSION->closeCursor();
	}else{die('FATAL ERROR -> SESSION::BUILD_NEW_SESSION - "Error deleting expired sessions"');}$this->DBO->DISCONNECT();}

public function DESTROY_CURRENT_SESSION(){$this->DBO->CONNECT('ibdlhsession');self::GET_CURRENT_PHPSID();self::DELETE_CURRENT_PHPSID();$this->DBO->DISCONNECT();session_unset();session_destroy();}

/* CLASS CONSTRUCT METHOD */
public function __construct($MSOBJ,$DBO,$DATA){$this->MSOBJ=$MSOBJ;unset($MSOBJ);$this->DBO=$DBO;unset($DBO);/* START CONSTRUCT METHOD DEFINITION */
	$this->VALID=false;
}/* [END CONSTRUCT METHOD DEFINITION] */}?>