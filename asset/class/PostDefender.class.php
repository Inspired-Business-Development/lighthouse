<?php
/*
 * CLASS DESCRIPTION:
 * 
 */
final class PostDefender{
/* CLASS PROPERTIES */
//PRIVATE SCOPE

//PROTECTED SCOPE

//PUBLIC SCOPE

/* CLASS OBJECTS */
//PRIVATE SCOPE
private $MakeSafe;
private $lhDB;
private $lhID;

//PROTECTED SCOPE

//PUBLIC SCOPE

/* CLASS METHODS */
//PRIVATE SCOPE
private function deleteOldPostTokens(){
    $ageLimit=REQ_TS-86400;
    $DELETE_OLD_TOKENS=$this->lhDB->PDO->prepare("DELETE FROM `tbl_index` WHERE `created`<=:ageLimit");
    $DELETE_OLD_TOKENS->bindParam(':ageLimit',$ageLimit);
    $DELETE_OLD_TOKENS->execute();
    $DELETE_OLD_TOKENS->closeCursor();  
}
private function tokenExists($test_pTkn){
    $SELECT_RECORD=$this->lhDB->PDO->prepare("SELECT * FROM `tbl_index` WHERE `pTkn`=:pTkn LIMIT 1");
    $SELECT_RECORD->bindParam(':pTkn',$test_pTkn);
    $SELECT_RECORD->execute();
    if($R=$SELECT_RECORD->fetch(PDO::FETCH_ASSOC)){$SELECT_RECORD->closeCursor();
        if(!$found_pTkn=$this->MakeSafe->thisData($R['pTkn'],'PARANOID_STRING',32,32)){$found_pTkn="";}
        if(!$found_lightSessID=$this->MakeSafe->thisData($R['lightSessID'],'PARANOID_STRING',128,128)){$found_lightSessID="";}
        if(!$found_created=$this->MakeSafe->thisData($R['created'],'NUMBER')){$found_created="";}
        unset($R);
        $tknData=array(
            "pTkn"=>$found_pTkn,
            "lightSessID"=>$found_lightSessID,
            "created"=>$found_created,
        );
        return $tknData;
    }else{$SELECT_RECORD->closeCursor();return false;}
}

//PROTECTED SCOPE

//PUBLIC SCOPE
public function generatePostToken(){$pTkn=$this->lhID->getNewID("pTkn");$this->lhDB->connect('ibdpostdef');self::deleteOldPostTokens();$created=REQ_TS;
    $INSERT_NEW_TOKEN=$this->lhDB->PDO->prepare("INSERT INTO `tbl_index` (`pTkn`,`created`) VALUES (:pTkn,:created)");
    $INSERT_NEW_TOKEN->bindParam(':pTkn',$pTkn);
    $INSERT_NEW_TOKEN->bindParam(':created',$created);
    $INSERT_NEW_TOKEN->execute();$INSERT_NEW_TOKEN->closeCursor();
    $this->lhDB->disconnect();
    return $pTkn;
}
public function signPostToken($pTkn,$lightSessID){
    //Filter Input
    if(!$test_pTkn=$this->MakeSafe->thisData($pTkn,'PARANOID_STRING')){return false;}
    if(!$test_lightSessID=$this->MakeSafe->thisData($lightSessID,'PARANOID_STRING')){return false;}
    
    //Connect to db
    $this->lhDB->connect('ibdpostdef');
    
    //If token exists
    $tDat=self::tokenExists($test_pTkn);
    if($tDat==false){$this->lhDB->disconnect();return false;}
    if($tDat['pTkn']==""){$this->lhDB->disconnect();return false;}
    
    //If token is not already signed
    if($tDat['lightSessID']!=""){$this->lhDB->disconnect();return false;}
     
    //If token is not expired
    if($tDat['created']==""){$this->lhDB->disconnect();return false;}$age=REQ_TS-$tDat['created'];
    if($age>86400){self::deleteOldPostTokens();$this->lhDB->disconnect();return false;}
     
    //Sign Post Token
    $UPDATE_TOKEN=$this->lhDB->PDO->prepare("UPDATE `tbl_index` SET `lightSessID`=:lightSessID WHERE `pTkn`=:pTkn LIMIT 1");
    $UPDATE_TOKEN->bindParam(':pTkn',$test_pTkn);
    $UPDATE_TOKEN->bindParam(':lightSessID',$test_lightSessID);
    $UPDATE_TOKEN->execute();
    $UPDATE_TOKEN->closeCursor();
    
    //Disconnect from db and return result
    $this->lhDB->disconnect();
    return true;
}
public function validatePostToken($pTkn,$lightSessID){
    //Filter Input
    if(!$test_pTkn=$this->MakeSafe->thisData($pTkn,'PARANOID_STRING')){return false;}
    if(!$test_lightSessID=$this->MakeSafe->thisData($lightSessID,'PARANOID_STRING')){return false;}
    
    //Connect to db
    $this->lhDB->connect('ibdpostdef');
    
    //If signed token exists
    $tDat=self::tokenExists($test_pTkn);
    if($tDat==false){return false;}
    if($tDat['pTkn']==""){return false;}
    if($tDat['lightSessID']==""){return false;}
    
    //If token is not expired
    if($tDat['created']==""){$this->lhDB->disconnect();return false;}$age=REQ_TS-$tDat['created'];
    if($age>86400){self::deleteOldPostTokens();$this->lhDB->disconnect();return false;}
    
    //Disconnect from db
    $this->lhDB->disconnect();
    
    //If signature match
    if($tDat['lightSessID']!=$test_lightSessID){return false;}
    
    //Return result
    return true;
}

/* CLASS CONSTRUCT METHOD */
public function __construct($MakeSafe,$lhDB){$this->MakeSafe=$MakeSafe;unset($MakeSafe);$this->lhDB=$lhDB;unset($lhDB);/* START CONSTRUCT METHOD DEFINITION */
    $this->lhID=new lhID($this->MakeSafe,$this->lhDB);
}/* [END CONSTRUCT METHOD DEFINITION] */}?>