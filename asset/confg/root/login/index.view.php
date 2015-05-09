<?php
/* 
 * Action Path: /login/
 */
$aPath=explode("/",ACTION_PATH);
if($aPath[1]=="i"){$interruptMode=true;}else{$interruptMode=false;}
switch(BASE_URL){
    case"ibdlighthouse.com":
        if(!$REMUSN=$MakeSafe->thisData('IBDLH_REMRUN','PARANOID_STRING',5,32,'COOKIE')){$REMUSN="";}
        if(!$LREQ_URL=$MakeSafe->thisData('IBDLH_LREQ_URL','URL_STRING',"","",'COOKIE')){$LREQ_URL="";}
        $lhLogoFile="inspired_lighthouse_logo_lrg.png";
    break;
    case"dev.ibdlighthouse.com":
        if(!$REMUSN=$MakeSafe->thisData('DEV_IBDLH_REMRUN','PARANOID_STRING',5,32,'COOKIE')){$REMUSN="";}
        if(!$LREQ_URL=$MakeSafe->thisData('DEV_IBDLH_LREQ_URL','URL_STRING',"","",'COOKIE')){$LREQ_URL="";}
        $lhLogoFile="inspired_lighthouse_dev_mode_logo_lrg.png";
    break;
    case"local.ibdlighthouse.com":
        if(!$REMUSN=$MakeSafe->thisData('LOCAL_IBDLH_REMRUN','PARANOID_STRING',5,32,'COOKIE')){$REMUSN="";}
        if(!$LREQ_URL=$MakeSafe->thisData('LOCAL_IBDLH_LREQ_URL','URL_STRING',"","",'COOKIE')){$LREQ_URL="";}
        $lhLogoFile="inspired_lighthouse_dev_mode_logo_lrg.png";
    break;
default:$REMUSN="";$LREQ_URL="";$lhLogoFile="inspired_lighthouse_logo_lrg.png";}
?>
<div id="lh-lrg-logo" align="center"><?php echo'<img src="/rsrc/img/'.$lhLogoFile.'" alt="" />';?></div>
<div id="lh-guest-body">
    <form id="login_form" autocomplete="off" data-abide="ajax">
        <?php if($interruptMode){echo'<input type="hidden" id="i" value="'.$LREQ_URL.'" />';}?>
        <div class="row"><div class="small-12 medium-6 medium-centered columns"><h4 class="lh-green">Please Login</h4></div></div>
        <div id="login_form_error" class="row hidden"><div class="small-12 medium-6 medium-centered columns"><div data-alert class="alert-box alert radius">&nbsp;</div></div></div>
    	<div class="row"><div class="small-12 medium-6 medium-centered columns"><label for="username"><strong>Username</strong></label><?php echo'<input type="text" id="username" maxlength="32" placeholder="Username" autocorrect="off" autocapitalize="off" spellcheck="false" value="';if($REMUSN!=""){echo $REMUSN;}echo'" data-no-err-msg required />';?></div></div>
    	<div class="row"><div class="small-12 medium-6 medium-centered columns"><label for="password"><strong>Password</strong></label><input type="password" id="password" maxlength="32" placeholder="Password" autocapitalize="off" value="" data-no-err-msg required /></div></div>
    	<div class="row"><div align="right" class="small-12 medium-6 medium-centered columns"><?php echo'<input id="rememberme" type="checkbox"';if($REMUSN!=""){echo' checked="checked"';}echo' /><label for="rememberme"> Remember Me</label>&nbsp;';?><input type="submit" class="button radius" name="action" value="Login" /></div></div>
    </form>
</div>
<div id="lh-guest-footer">
    <div class="row"><div align="center" class="small-12 medium-6 medium-centered columns"><a href="/support/">Contact Support</a>&nbsp;|&nbsp;<a href="/recovery/">Account Recovery</a></div></div>
    <div class="row"><div class="small-12 medium-6 medium-centered columns"><small>&copy; 2015 - Inspired Business Development, LLC</small></div></div>
</div>