/* 
 * Login Form
 */
$("form#login_form").on('valid',function(){
    showGlobalOverlay('<h3>Attempting Login<br /><small>Please Wait...</small></h3><h4><i class="fa fa-spinner fa-pulse"></i></h4>');
    $('div#login_form_error').makeHidden();
    $('div#login_form_error div.alert-box').html('&nbsp;');
    if(authPostToken()){
        var lightSessID=sessionStorage.lightSessID;
        var pTkn=getPostToken();
        var rembrUsn=$('input#rememberme').prop('checked');
        var username=$('input#username').val();
        var password=$('input#password').val();
        var interruptMode=$('input#i').val();
        if(interruptMode===undefined){interruptMode=false;}
        $.post("/bin/login/try_login.servlet.php",{
            pTkn:pTkn,
            lightSessID:lightSessID,
            rembrUsn:rembrUsn,
            username:username,
            password:password
        },function(data){
            if(data.rslt=="SUCCESS"){
                if(interruptMode!=false){window.location.assign(interruptMode);}
                else{window.location.assign(data.rtnData);}
            }else{
                $('input#password').val('');
                $('div#login_form_error div.alert-box').html(data.msg);
                $('div#login_form_error').makeVisible();
                hideGlobalOverlay();
            }
        },"json");
    }else{
       $('div#login_form_error div.alert-box').html('Stale Session Detected. Please refresh the page and try again.');
       $('div#login_form_error').makeVisible();
       hideGlobalOverlay(); 
    }
});