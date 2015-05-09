<?php
/* 
 * 404 Error Page
 */
switch(BASE_URL){
    case"ibdlighthouse.com":$lhLogoFile="inspired_lighthouse_logo_lrg.png";break;
    case"dev.ibdlighthouse.com":$lhLogoFile="inspired_lighthouse_dev_mode_logo_lrg.png";break;
    case"local.ibdlighthouse.com":$lhLogoFile="inspired_lighthouse_dev_mode_logo_lrg.png";break;
default:$lhLogoFile="inspired_lighthouse_logo_lrg.png";}
?>
<div id="lh-lrg-logo" align="center"><?php echo'<img src="/rsrc/img/'.$lhLogoFile.'" alt="" />';?></div>
<div id="lh-guest-body">
    <div class="row"><div class="small-12 columns"><h1 class="text-center">404 Page Not Found</h1></div></div>
    <div class="row"><div class="small-12 columns"><p class="text-center">The page you requested could not be located.</p></div></div>
</div>
<div id="lh-guest-footer">
    <div class="row"><div align="center" class="small-12 medium-6 medium-centered columns"><a href="/support/">Contact Support</a>&nbsp;|&nbsp;<a href="/login/">Login</a></div></div>
    <div class="row"><div class="small-12 medium-6 medium-centered columns"><small>&copy; 2015 - Inspired Business Development, LLC</small></div></div>
</div>