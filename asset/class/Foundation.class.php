<?php
/*
 * CLASS DESCRIPTION:
 * 
 */
final class Foundation{
/* CLASS PROPERTIES */
//PRIVATE SCOPE
private $pTkn;
private $pageTitle;
private $favIcon;
private $mode;
private $globalSpace;
private $topBar;
private $onTab;
private $style;
private $script;
private $runTime;
private $docFoundOpts;

//PROTECTED SCOPE

//PUBLIC SCOPE

/* CLASS OBJECTS */
//PRIVATE SCOPE
private $MakeSafe;
private $lhDB;
private $lhUser;

//PROTECTED SCOPE

//PUBLIC SCOPE

/* CLASS METHODS */
//PRIVATE SCOPE
private function getTopWrapper(){
  $HTML='<!DOCTYPE html>'."\n".
        '<html class="no-js" lang="en">'."\n".
            '<head>'."\n".
		'<meta charset="utf-8" />'."\n".
		'<meta name="description" content="">'."\n".
		'<meta name="viewport" content="width=device-width, initial-scale=1.0" />'."\n".
		'<title>'.$this->pageTitle.'</title>'."\n".
                '<link rel="shortcut icon" href="'.$this->favIcon.'">'."\n".
                '<link rel="stylesheet" href="/rsrc/css/normalize.min.css" />'."\n".
		'<link rel="stylesheet" href="/rsrc/css/foundation.min.css" />'."\n".
		'<link rel="stylesheet" href="/rsrc/jquery-ui-1.11.4/jquery-ui.min.css" />'."\n".
                '<link rel="stylesheet" href="/rsrc/css/font-awesome.min.css">'.
		'<link rel="stylesheet" href="/rsrc/css/lighthouse.css" />'."\n";
                if($this->style!=false){foreach($this->style as $stylePath){$HTML.='<link rel="stylesheet" href="/rsrc/css/'.$stylePath.'" />'."\n";}}
         $HTML.='<script src="/rsrc/js/vendor/jquery.js"></script>'."\n".
		'<script src="/rsrc/jquery-ui-1.11.4/jquery-ui.min.js"></script>'."\n".
		'<script src="/rsrc/js/vendor/modernizr.js"></script>'."\n".
                '<script src="/rsrc/js/plugins.js"></script>'."\n".
		'<script src="/rsrc/js/lighthouse.js"></script>'."\n";
     $HTML.='</head>'."\n".
            '<body';if($this->mode=="GUEST"){$HTML.=' class="lh-guest"';}$HTML.=' data-ptkn="'.$this->pTkn.'">'."\n".
                '<script>var a="'.ACTION_PATH.'";var stateObj={foo:"bar"};history.replaceState(stateObj,"",a);</script>';
         $HTML.='<script>$(document).ready(function(){var RUNTIME_SCRIPTS=["lhrt-DetectOffline"';
                if($this->runTime!=false){$HTML.=',';$rtQty=count($this->runTime);foreach($this->runTime as $runTimeScript){$rtQty--;$HTML.='"'.$runTimeScript.'"';if($rtQty!=0){$HTML.=',';}}}
         $HTML.='];initLighthouse(RUNTIME_SCRIPTS);});</script>';
                if($this->globalSpace['globalOverlay']){$HTML.='<div id="lh-global-overlay" class="hidden"><div id="lh-global-overlay-wrapper"><span id="lh-global-overlay-content">&nbsp;</span></div></div>';}
                if($this->globalSpace['globalNotify']){$HTML.='<div id="lh-global-notify" class="hidden"><div data-alert class="alert-box radius"><a href="#" class="close">&times;</a><span id="lh-global-notify-content">&nbsp;</span></div></div>';}
                if($this->topBar==true){
             $HTML.='<nav class="top-bar hide-for-small" data-topbar role="navigation">'.
                        '<ul class="title-area"><li class="name"><h1><a href="/home/"><img src="/rsrc/img/lighthouse_icon_white_24.png" alt="" /> Lighthouse</a></h1></li></ul>'.
			'<section class="top-bar-section"><ul class="left">';
                    $HTML.='<li';if($this->onTab=="APPS"){$HTML.=' class="active"';}$HTML.='><a href="/apps/">apps</a></li>';
                    $HTML.='<li';if($this->onTab=="TASKS"){$HTML.=' class="active"';}$HTML.='><a href="/tasks/">tasks</a></li>';
                    $HTML.='<li';if($this->onTab=="CONTACTS"){$HTML.=' class="active"';}$HTML.='><a href="/contacts/">contacts</a></li>';
                    $HTML.='<li';if($this->onTab=="CALENDAR"){$HTML.=' class="active"';}$HTML.='><a href="/calendar/">calendar</a></li>';
                    $HTML.='<li';if($this->onTab=="REPORTS"){$HTML.=' class="active"';}$HTML.='><a href="/reports/">reports</a></li>';
                            if($this->lhUser!="NONE"){if($this->lhUser->hasPerm('LH_CONFIG')){$HTML.='<li';if($this->onTab=="CONFIG"){$HTML.=' class="active"';}$HTML.='><a href="/config/">config</a></li>';}}
                 $HTML.='</ul></section>'.
			'<section class="top-bar-section"><ul class="right">'.
                            '<li class="divider"></li>';
                            if($this->lhUser!="NONE"){
                         $HTML.='<li class="has-dropdown"><a id="lh-top-bar-dname" href="#">'.$this->lhUser->GET_DNAME().'</a><ul class="dropdown">'.
                                    '<li><a href="/settings/">Settings</a></li>'.
                                    '<li><a href="/logout/">Log Out</a></li>'.
                                '</ul></li>';
                            }else{
                         $HTML.='<li><a href="/login/">Login</a></li>';
                            }
			'</ul></section>'.
                    '</nav>'.
                    '<div class="off-canvas-wrap" data-offcanvas>'.
			'<div class="inner-wrap">'.
                            '<nav class="tab-bar show-for-small">'.
				'<section class="left-small"><a href="#idOfLeftMenu" role="button" aria-controls="idOfLeftMenu" aria-expanded="false" class="left-off-canvas-toggle menu-icon" ><span></span></a></section>'.
				'<section class="middle tab-bar-section"><h1 class="title"><img src="/rsrc/img/lighthouse_icon_white_24.png" alt="" /> Lighthouse</h1></section>'.
                            '</nav>'.
                            '<aside class="left-off-canvas-menu">'.
				'<ul class="off-canvas-list">'.
                                    '<li><label class="first">Lighthouse</label></li>'.
                             $HTML.='<li';if($this->onTab=="HOME"){$HTML.=' class="active"';}$HTML.='><a href="/home/">Home</a></li>';
                             $HTML.='<li';if($this->onTab=="APPS"){$HTML.=' class="active"';}$HTML.='><a href="/apps/">Apps</a></li>';
                             $HTML.='<li';if($this->onTab=="TASKS"){$HTML.=' class="active"';}$HTML.='><a href="/tasks/">Tasks</a></li>';
                             $HTML.='<li';if($this->onTab=="CONTACTS"){$HTML.=' class="active"';}$HTML.='><a href="/contacts/">Contacts</a></li>';
                             $HTML.='<li';if($this->onTab=="CALENDAR"){$HTML.=' class="active"';}$HTML.='><a href="/calendar/">Calendar</a></li>';
                             $HTML.='<li';if($this->onTab=="REPORTS"){$HTML.=' class="active"';}$HTML.='><a href="/reports/">Reports</a></li>';
                                    if($this->lhUser!="NONE"){if($this->lhUser->hasPerm('LH_CONFIG')){$HTML.='<li';if($this->onTab=="CONFIG"){$HTML.=' class="active"';}$HTML.='><a href="/config/">Config</a></li>';}}
			 $HTML.='</ul>'.
                                '<ul class="off-canvas-list">';
                                if($this->lhUser!="NONE"){
                             $HTML.='<li><label id="lh-off-canvas-menu-dname" class="first">'.$this->lhUser->GET_DNAME().'</label></li>'.
                                    '<li><a href="/settings/">Settings</a></li>'.
                                    '<li><a href="/logout/">Log Out</a></li>';
                                }else{
                             $HTML.='<li><label id="lh-off-canvas-menu-dname" class="first">Please Login</label></li>'.
                                    '<li><a href="/login/">Login</a></li>';
                                }
				'</ul>'.
                            '</aside>';
                }else{
                    if($this->topBar!=false){
                        //Handle Custom TopBar Here
                    }
                }
                $HTML.='<div id="lh-main-container">';
                if($this->globalSpace['pageTopBtn']){$HTML.='<button class="linkto-page-top button radius tiny" onclick="jumpToPageTop();">Page Top</button>';}
    return $HTML;
}

private function getBottomWrapper(){
    $HTML='</div>';
    if($this->topBar==true){
        $HTML.='<a class="exit-off-canvas" href="#"></a></div></div>';
    }else{
        if($this->topBar!=false){
           //Handle Custom TopBar Here
        } 
    }
    $lhID=new lhID($this->MakeSafe,$this->lhDB);
    $lightSessID=$lhID->getNewID("lightSessID");
 $HTML.='<script src="/rsrc/js/vendor/fastclick.js"></script>'.
        '<script src="/rsrc/js/foundation.min.js"></script>'.
        '<script>'.
            'if(typeof(Storage)!=="undefined"){'.
                'if(sessionStorage.lightSessID===undefined){sessionStorage.lightSessID="'.$lightSessID.'"}'.
                '$(\'body\').attr(\'data-ptkn-signed\',false);'.
                'var lightSessID=sessionStorage.lightSessID;'.
                'var pTkn=getPostToken();'.
                'if(pTkn!="" && pTkn!=undefined){'.
                    '$.post("/bin/ptkn/sign.servlet.php",{'.
                        'pTkn:pTkn,'.
                        'lightSessID:lightSessID'.
                    '},function(data){'.
                        'if(data.rslt=="SUCCESS"){'.
                            '$(\'body\').attr(\'data-ptkn-signed\',true);'.
                        '}'.
                    '},"json");'.
                '}'.
            '}else{showGlobalOverlay(\'<h3 class="red">Unsupported Browser<br /></h3><p>Please use a different web browser.</p>\');}'.
        '</script>';
        if($this->docFoundOpts!=false){
            foreach($this->docFoundOpts as $Option){$HTML.='<script>$(document).foundation('.$Option.');</script>';}
        }else{
            $HTML.='<script>$(document).foundation();</script>';
        }
        if($this->script!=false){foreach($this->script as $scriptPath){$HTML.='<script src="/rsrc/js/'.$scriptPath.'"></script>';}}
    $HTML.="\n".'</body>'."\n".
    '</html>';
    return $HTML;
}

//PROTECTED SCOPE

//PUBLIC SCOPE
public function renderTopWrapper(){$HTML=self::getTopWrapper();echo $HTML;}
public function renderBottomWrapper(){$HTML=self::getBottomWrapper();echo $HTML;}

/* CLASS CONSTRUCT METHOD */
public function __construct($MakeSafe,$lhDB,$foundationConfg,$pTkn,$lhUser){$this->MakeSafe=$MakeSafe;unset($MakeSafe);$this->lhDB=$lhDB;unset($lhDB);$this->pTkn=$pTkn;unset($pTkn);$this->lhUser=$lhUser;unset($lhUser);/* START CONSTRUCT METHOD DEFINITION */
    if(isset($foundationConfg['pageTitle'])){$this->pageTitle=$foundationConfg['pageTitle'];}else{$this->pageTitle="IBD:Lighthouse";}
    if(isset($foundationConfg['favIcon'])){$this->favIcon=$foundationConfg['favIcon'];}else{$this->favIcon="/favicon.ico";}
    if(isset($foundationConfg['mode'])){$this->mode=$foundationConfg['mode'];}else{$this->mode="GUEST";}
    if(isset($foundationConfg['globalSpace'])){$this->globalSpace=$foundationConfg['globalSpace'];}else{$this->globalSpace=array("globalOverlay"=>false,"globalNotify"=>false,"pageTopBtn"=>false);}
    if(isset($foundationConfg['topBar'])){$this->topBar=$foundationConfg['topBar'];}else{$this->topBar=false;}
    if(isset($foundationConfg['onTab'])){$this->onTab=$foundationConfg['onTab'];}else{$this->onTab=false;}
    if(isset($foundationConfg['style'])){$this->style=$foundationConfg['style'];}else{$this->style=false;}
    if(isset($foundationConfg['script'])){$this->script=$foundationConfg['script'];}else{$this->script=false;}
    if(isset($foundationConfg['runTime'])){$this->runTime=$foundationConfg['runTime'];}else{$this->runTime=false;}
    if(isset($foundationConfg['docFoundOpts'])){$this->docFoundOpts=$foundationConfg['docFoundOpts'];}else{$this->docFoundOpts=false;}
}/* [END CONSTRUCT METHOD DEFINITION] */}?>