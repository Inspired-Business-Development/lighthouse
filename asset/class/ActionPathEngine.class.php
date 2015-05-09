<?php
/*
 * CLASS DESCRIPTION:
 * 
 */
final class ActionPathEngine{
/* CLASS PROPERTIES */
//PRIVATE SCOPE
private $aPath;
private $confgFileName;
private $confgFilePath;
private $confgRoot;
private $paramQty;
private $viewFileName;
private $viewFilePath;
private $viewRoot;

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

//PROTECTED SCOPE

//PUBLIC SCOPE
public function getConfgFilePath(){$path=$this->confgRoot.$this->confgFilePath;return $path;}
public function getViewFilePath(){$path=$this->viewRoot.$this->viewFilePath;return $path;}

/* CLASS CONSTRUCT METHOD */
public function __construct($MakeSafe,$lhDB){$this->MakeSafe=$MakeSafe;unset($MakeSafe);$this->lhDB=$lhDB;unset($lhDB);/* START CONSTRUCT METHOD DEFINITION */
    //Action Path Engine Configuration Settings
    $this->confgRoot="/asset/confg/root/"; //Path to the root folder for webpage config files
    $this->confgFileName="index.confg.php"; //Default webpage config file name
    $this->viewRoot="/asset/confg/root/"; //Path to the root folder for webpage view files
    $this->viewFileName="index.view.php"; //Default webpage view file name
    
    //Configure Action Path Array and Determine Number of Parameters
    $this->aPath=explode("/",ACTION_PATH);$this->paramQty=count($this->aPath);
    
    switch($this->aPath[0]){
        case"":$this->confgFilePath='home/'.$this->confgFileName;$this->viewFilePath='home/'.$this->viewFileName;break;
        case"home":$this->confgFilePath='home/'.$this->confgFileName;$this->viewFilePath='home/'.$this->viewFileName;break;
        case"login":$this->confgFilePath='login/'.$this->confgFileName;$this->viewFilePath='login/'.$this->viewFileName;break;
        
    default:$this->confgFilePath="error_pages/404.confg.php";$this->viewFilePath="error_pages/404.view.php";}
    
}/* [END CONSTRUCT METHOD DEFINITION] */}?>