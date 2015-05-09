<?php
/*
 * CLASS DESCRIPTION:
 * 
 */
final class lhID{
/* CLASS PROPERTIES */
//PRIVATE SCOPE
private $sysID;

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
private function buildNewID($idType){$U=$this->sysID[$idType]['ID_CONFIG']['UPPERCASE'];$L=$this->sysID[$idType]['ID_CONFIG']['LOWERCASE'];$N=$this->sysID[$idType]['ID_CONFIG']['NUMBERS'];$S=$this->sysID[$idType]['ID_CONFIG']['SPECIAL'];$LENGTH=$this->sysID[$idType]['ID_CONFIG']['LENGTH'];$strObj=new RandString($U,$L,$N,$S,$LENGTH);$newID=$strObj->RAND_STR;return $newID;}
private function isUnique($idType,$testID){$DB=$this->sysID[$idType]['DB_NAME'];$TBL=$this->sysID[$idType]['TBL_NAME'];$this->lhDB->connect($DB);$COUNT_EXISTING_IDS=$this->lhDB->PDO->prepare("SELECT COUNT(`$idType`) AS `TOTAL_FOUND` FROM `$TBL` WHERE `$idType`=:testID");$COUNT_EXISTING_IDS->bindParam(':testID',$testID);$COUNT_EXISTING_IDS->execute();if($R=$COUNT_EXISTING_IDS->fetch(PDO::FETCH_ASSOC)){$COUNT_EXISTING_IDS->closeCursor();if($R['TOTAL_FOUND']==0){return true;}else{return false;}}else{$COUNT_EXISTING_IDS->closeCursor();die('Lighthouse ID Generator - ERROR "Query Error"');}}

//PROTECTED SCOPE

//PUBLIC SCOPE
public function getNewID($idType){$newID=self::buildNewID($idType);if($this->sysID[$idType]['UNIQUE']){$idIsUnique=false;while(!$idIsUnique){if(self::isUnique($idType,$newID)){$idIsUnique=true;}}}return $newID;}

/* CLASS CONSTRUCT METHOD */
public function __construct($MakeSafe,$lhDB){$this->MakeSafe=$MakeSafe;unset($MakeSafe);$this->lhDB=$lhDB;unset($lhDB);/* START CONSTRUCT METHOD DEFINITION */
    $this->sysID=array(
        
        //LightSession ID
        "lightSessID"=>array(
            "UNIQUE"=>false,
            "DB_NAME"=>"",
            "TBL_NAME"=>"",
            "ID_CONFIG"=>array(
                "UPPERCASE"=>true,
                "LOWERCASE"=>true,
                "NUMBERS"=>true,
                "SPECIAL"=>false,
                "LENGTH"=>128,
            ),
        ),
        
       //PostToken
        "pTkn"=>array(
            "UNIQUE"=>true,
            "DB_NAME"=>"ibdpostdef",
            "TBL_NAME"=>"tbl_index",
            "ID_CONFIG"=>array(
                "UPPERCASE"=>true,
                "LOWERCASE"=>true,
                "NUMBERS"=>true,
                "SPECIAL"=>false,
                "LENGTH"=>32,
            ),
        ),

    );
}/* [END CONSTRUCT METHOD DEFINITION] */}?>