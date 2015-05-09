/*!
* Lighthouse Javascript API
* Version: 1.0
*/
//CUSTOM INPUT MASK ALIAS DEFINITIONS
(function($){$.extend($.inputmask.defaults.aliases,{
    'BTU':{mask:"9{1,100} BTU",greedy:false,onUnMask:function(maskedValue,unmaskedValue){var step_1=maskedValue.replace("_","");var processedValue=step_1.replace(" BTU","");return processedValue;}},
    'CFM':{mask:"[~]9{0,100}[.9{0,2}] CFM",greedy:false,onUnMask:function(maskedValue,unmaskedValue){var step_1=maskedValue.replace("_","");var processedValue=step_1.replace(" CFM","");return processedValue;},definitions:{'~':{validator:"[-]",cardinality:1,prevalidator:null},'.':{validator:"[.]",cardinality:1,prevalidator:null}}},
    'CurrencyUS':{mask:"$ [~]9{1,100}.9{2}",placeholder:"0",greedy:false,onUnMask:function(maskedValue,unmaskedValue){var processedValue=maskedValue.replace("$ ","");return processedValue;},definitions:{'~':{validator:"[-]",cardinality:1,prevalidator:null}}},
    'DateTime':{mask:"99/99/9999 99:99 aa"},
    'DeciNegNumber':{mask:"[~]9{0,100}[.9{0,2}]",greedy:false,onUnMask:function(maskedValue,unmaskedValue){var processedValue=maskedValue.replace("_","");return processedValue;},definitions:{'~':{validator:"[-]",cardinality:1,prevalidator:null},'.':{validator:"[.]",cardinality:1,prevalidator:null}}},
    'DeciPosNumber':{mask:"9{0,100}[.9{0,2}]",greedy:false,onUnMask:function(maskedValue,unmaskedValue){var processedValue=maskedValue.replace("_","");return processedValue;},definitions:{'.':{validator:"[.]",cardinality:1,prevalidator:null}}},
    'DeciNegPercentage':{mask:"[~]9{0,100}[.9{0,2}]%",greedy:false,onUnMask:function(maskedValue,unmaskedValue){var step_1=maskedValue.replace("_","");var step_2=step_1.replace("%","");var processedValue=parseFloat(step_2)/100;return processedValue;},definitions:{'~':{validator:"[-]",cardinality:1,prevalidator:null},'.':{validator:"[.]",cardinality:1,prevalidator:null}}},
    'DeciPosPercentage':{mask:"9{0,100}[.9{0,2}]%",greedy:false,onUnMask:function(maskedValue,unmaskedValue){var step_1=maskedValue.replace("_","");var step_2=step_1.replace("%","");var processedValue=parseFloat(step_2)/100;return processedValue;},definitions:{'~':{validator:"[-]",cardinality:1,prevalidator:null},'.':{validator:"[.]",cardinality:1,prevalidator:null}}},
    'Framing':{mask:'2X 9[9] @ 9{1,2}[.9{0,2}]" O/C',greedy:false,skipOptionalPartCharacter:"@",definitions:{'.':{validator:"[.]",cardinality:1,prevalidator:null}}},
    'ft':{mask:"9{0,100}[.9{0,2}] ft",greedy:false,onUnMask:function(maskedValue,unmaskedValue){var step_1=maskedValue.replace("_","");var processedValue=step_1.replace(" ft","");return processedValue;},definitions:{'.':{validator:"[.]",cardinality:1,prevalidator:null}}},
    'gal':{mask:"9{1,100} g\\al",greedy:false,onUnMask:function(maskedValue, unmaskedValue){var step_1=maskedValue.replace("_","");var processedValue=step_1.replace(" gal","");return processedValue;}},
    'in':{mask:"9{0,100}[.9{0,2}] in",greedy:false,onUnMask:function(maskedValue,unmaskedValue){var step_1=maskedValue.replace("_","");var processedValue=step_1.replace(" in","");return processedValue;},definitions:{'.':{validator:"[.]",cardinality:1,prevalidator:null}}},
    'LnFt':{mask:"9{0,100}[.9{0,2}] Ln ft",greedy:false,onUnMask:function(maskedValue,unmaskedValue){var step_1=maskedValue.replace("_","");var processedValue=step_1.replace(" Ln ft","");return processedValue;},definitions:{'.':{validator:"[.]",cardinality:1,prevalidator:null}}},
    'NegNumber':{mask:"[~]9{1,100}",greedy:false,definitions:{'~':{validator:"[-]",cardinality:1,prevalidator:null}}},
    'Pa':{mask:"[~]9{0,100}[.9{0,2}] P\\a",greedy:false,onUnMask:function(maskedValue,unmaskedValue){var step_1=maskedValue.replace("_","");var processedValue=step_1.replace(" Pa","");return processedValue;},definitions:{'~':{validator:"[-]",cardinality:1,prevalidator:null},'.':{validator:"[.]",cardinality:1,prevalidator:null}}},
    'Percentage':{mask:"9{1,3}%",onUnMask:function(maskedValue,unmaskedValue){var step_1=maskedValue.replace("_","");var step_2=step_1.replace("%","");var processedValue=parseFloat(step_2)/100;return processedValue;}},
    'PosNumber':{mask:"9{1,100}"},
    'ppm':{mask:"9{0,100}[.9{0,2}] pp\\m",greedy:false,onUnMask:function(maskedValue,unmaskedValue){var step_1=maskedValue.replace("_","");var processedValue=step_1.replace(" ppm","");return processedValue;},definitions:{'.':{validator:"[.]",cardinality:1,prevalidator:null}}},
    'rVal':{mask:"R-9{1,100}",greedy:false,onUnMask:function(maskedValue,unmaskedValue){var step_1=maskedValue.replace("_","");var processedValue=step_1.replace(" R-","");return processedValue;}},
    'SqFt':{mask:"9{0,100}[.9{0,2}] SqFt",greedy:false,onUnMask:function(maskedValue,unmaskedValue){var step_1=maskedValue.replace("_","");var processedValue=step_1.replace(" SqFt","");return processedValue;},definitions:{'.':{validator:"[.]",cardinality:1,prevalidator:null}}},
    'TempC':{mask:"[~]9{0,100}[.9{0,2}]℃",greedy:false,definitions:{'~':{validator:"[-]",cardinality:1,prevalidator:null},'.':{validator:"[.]",cardinality:1,prevalidator:null}}},
    'TempF':{mask:"[~]9{0,100}[.9{0,2}]℉",greedy:false,definitions:{'~':{validator:"[-]",cardinality:1,prevalidator:null},'.':{validator:"[.]",cardinality:1,prevalidator:null}}}
});return $.fn.inputmask;})(jQuery);
//Auto Initialize Input Mask Functionality
$(document).ready(function(){$(":input").inputmask();});

//DISABLE SCROLLING FEATURE ON NUMBER INPUTS WITH STEP="0"
$(':input[step="0"]').on('mousewheel',function(e){e.preventDefault();});

//LIGHTHOUSE GLOBAL OVERLAY FUNCTIONS
function showGlobalOverlay(OVERLAY_CONTENT){$('span#lh-global-overlay-content').html(OVERLAY_CONTENT);$('div#lh-global-overlay').addClass('visible').removeClass('hidden');$(document).foundation();}
function hideGlobalOverlay(){$('div#lh-global-overlay').addClass('hidden').removeClass('visible');$('span#lh-global-overlay-content').html('&nbsp;');$(document).foundation();}

//BUILD ALERT HTML CODE
function buildAlertHtml(ALERT_TYPE,ALERT_MSG){
    var HTML='<div data-alert class="alert-box';
    switch(ALERT_TYPE){
        case"success":HTML=HTML+' success';break;
        case"warning":HTML=HTML+' warning';break;
        case"info":HTML=HTML+' info';break;
        case"alert":HTML=HTML+' alert';break;
        case"secondary":HTML=HTML+' secondary';break;
    default:HTML=HTML+'';}
    HTML=HTML+' radius">'+ALERT_MSG+'<a href="#" class="close">&times;</a></div>';
    return HTML;
}

//Custom Make Elements Visible Plugin
(function($){$.fn.extend({makeVisible:function(){return this.each(function(){$(this).addClass('visible').removeClass('hidden');});}});}(jQuery));

//Custom Make Elements Hidden Plugin
(function($){$.fn.extend({makeHidden:function(){return this.each(function(){$(this).addClass('hidden').removeClass('visible');});}});}(jQuery));

//Custom Make Form Elements Required Plugin
(function($){$.fn.extend({makeRequired:function(){return this.each(function(){$(this).prop("required",true);});}});}(jQuery));

//Custom Make Form Elements Not Required Plugin
(function($){$.fn.extend({makeNotRequired:function(){return this.each(function(){$(this).removeAttr("aria-invalid").removeAttr("data-invalid").prop("required",false).parents('div.error').removeClass('error');});}});}(jQuery));

//Link to Page Top
function jumpToPageTop(){$(window).scrollTop(0);}


function getPostToken(){var pTkn=$('body').attr('data-ptkn');return pTkn;}
function getPostTokenSigned(){var pTknSigned=$('body').attr('data-ptkn-signed');return pTknSigned;}
function signPostToken(){
    var pTknSigned=getPostTokenSigned();
    if(!pTknSigned){
        var lightSessID=sessionStorage.lightSessID;
        var pTkn=getPostToken();
        $.post("/bin/ptkn/sign.servlet.php",{
            pTkn:pTkn,
            lightSessID:lightSessID
        },function(data){
            if(data.rslt=="SUCCESS"){$('body').attr('data-ptkn-signed',true);}
        },"json");
    } 
}
function authPostToken(){signPostToken();var pTknSigned=getPostTokenSigned();if(pTknSigned){return true;}else{return false;}}

/////////////////////////////////////////
// LIGHTHOUSE RUNTIME WORKER FUNCTIONS //
/////////////////////////////////////////

function initLighthouse(RT_SCRIPT){
    if(RT_SCRIPT!==undefined){
        for(i=0; i < RT_SCRIPT.length; i++){
            switch(RT_SCRIPT[i]){

                //DetectOffline - Test for internet connection
                case"lhrt-DetectOffline":
                    if(typeof(DetectOffline)=="undefined"){DetectOffline= new Worker("/rsrc/js/runtime/detectOffline.js");} //BUILD NEW WEB WORKER
                    DetectOffline.postMessage("TEST_CONN"); //PASS DATA TO WORKER
                    DetectOffline.onmessage=function(e){ //LISTEN FOR WORKER RESPONSE
                        //PROCESS RESULTS
                        if(e.data=="OFFLINE"){
                            sessionStorage.DetectOfflineSts="OFFLINE";
                            $('span#detect_offline_conn_sts').attr("data-connsts","false");
                            $('img#network-disconnected-small').removeClass('hidden').addClass('visible');
                            $('img#network-connected-small').removeClass('visible').addClass('hidden');
                        }else{
                            sessionStorage.DetectOfflineSts="CONNECTED";
                            $('span#detect_offline_conn_sts').attr("data-connsts","true");
                            $('img#network-disconnected-small').removeClass('visible').addClass('hidden');
                            $('img#network-connected-small').removeClass('hidden').addClass('visible');
                        }
                    };
                break;
                
            default:console.log('Invalid Runtime Script');}
        }
    }
}



















