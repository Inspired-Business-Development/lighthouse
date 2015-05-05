<?php
/*
 * CLASS DESCRIPTION:
 * Used to clean and sanitize user input from global environment variables and raw database result data.
 */
final class MakeSafe{
/* CLASS PROPERTIES */
//PRIVATE SCOPE

//PROTECTED SCOPE

//PUBLIC SCOPE

/* CLASS OBJECTS */
//PRIVATE SCOPE

//PROTECTED SCOPE

//PUBLIC SCOPE

/* CLASS METHODS */
//PRIVATE SCOPE
private function testMinLength($input,$min_length){if(strlen($input)<$min_length){return false;}else{return true;}}
private function testMaxLength($input,$max_length){if(strlen($input)>$max_length){return false;}else{return true;}}

//PROTECTED SCOPE

//PUBLIC SCOPE
public function thisData($input,$mode,$min_length=0,$max_length=0,$use_filter=""){
    $input=trim($input); //Remove spaces and new line from beginning and end of input data
    if($min_length!=0 && $min_length!=""){$test_min_length=true;}else{$test_min_length=false;} //Determine Min Length Settings
    if($max_length!=0 && $max_length!=""){$test_max_length=true;}else{$test_max_length=false;} //Determine Max Length Settings
    if($use_filter!=""){$input_needs_filter=true;}else{$input_needs_filter=false;} //Determine Filter Settings
    $is_valid=true; //Set is_valid to true by default

    //Get filtered input if needed
    if($input_needs_filter){
        switch($use_filter){
            case"COOKIE":if(filter_has_var(INPUT_COOKIE,$input)){$input=filter_input(INPUT_COOKIE,$input);}else{$is_valid=false;}break;
            case"GET":if(filter_has_var(INPUT_GET,$input)){$input=filter_input(INPUT_GET,$input);}else{$is_valid=false;}break;
            case"POST":if(filter_has_var(INPUT_POST,$input)){$input=filter_input(INPUT_POST,$input);}else{$is_valid=false;}break;
            case"SERVER":if(filter_has_var(INPUT_SERVER,$input)){$input=filter_input(INPUT_SERVER,$input);}else{$is_valid=false;}break;
        default:$is_valid=false;}
    }
    
    //Mode Switch - Validate Input based on the current settings
    switch($mode){

        //String that can only contain alphanumeric characters, underscores, or dashes. No whitespace allowed. Input is not encoded.
        //NOTE: Use this for validating passwords that have already been encrypted. Length should be exactly 128 characters.
        case"PARANOID_STRING":$pattern='/[a-zA-Z0-9_\-]+/';
            if($test_min_length){if(!self::testMinLength($input,$min_length)){$is_valid=false;}}
            if($test_max_length){if(!self::testMaxLength($input,$max_length)){$is_valid=false;}}
            if(!preg_match($pattern,$input)){$is_valid=false;}
        break;

        //String that can only contain alphanumeric characters and specified special characters. No Whitespace allowed. Input is encoded.
        case"STRICT_STRING":$pattern='/[0-9a-zA-Z!#&+,\-.\/:;<=>?@\\_]+/';
            if($test_min_length){if(!self::testMinLength($input,$min_length)){$is_valid=false;}}
            if($test_max_length){if(!self::testMaxLength($input,$max_length)){$is_valid=false;}}
            if(preg_match($pattern,$input)){$input=htmlspecialchars($input,ENT_QUOTES);}else{$is_valid=false;}
        break;

        //String that can only contain alphanumeric characters, specified special characters, and spaces. Input is encoded.
        case"STRING":$pattern='/[0-9a-zA-Z!#&+,\-.\/:;<=>?@\\_ ]+/';
            if($test_min_length){if(!self::testMinLength($input,$min_length)){$is_valid=false;}}
            if($test_max_length){if(!self::testMaxLength($input,$max_length)){$is_valid=false;}}
            if(preg_match($pattern,$input)){$input=htmlspecialchars($input,ENT_QUOTES);}else{$is_valid=false;}
        break;

        //String that can contain anything including whitespace. Input is encoded.
        case"FORMATTED_STRING":
            if($test_min_length){if(!self::testMinLength($input,$min_length)){$is_valid=false;}}
            if($test_max_length){if(!self::testMaxLength($input,$max_length)){$is_valid=false;}}
            if(!$input=filter_var($input,FILTER_SANITIZE_FULL_SPECIAL_CHARS)){$is_valid=false;}
        break;

        //String that must pass PHP's native email validator. Input is encoded.
        case"EMAIL_STRING":
            if($test_min_length){if(!self::testMinLength($input,$min_length)){$is_valid=false;}}
            if($test_max_length){if(!self::testMaxLength($input,$max_length)){$is_valid=false;}}
            if($input=filter_var($input,FILTER_VALIDATE_EMAIL)){$input=htmlspecialchars($input,ENT_QUOTES);}else{$is_valid=false;}
        break;

        //String that must contain at least 1 lowercase letter, 1 uppercase letter, 1 special charcter, and must be 7+ characters but <= 32 characters. Input is encrypted.
        // !-WARNING-: Do NOT use this to validate passwords that are already encrypted. Instead use PARANOID_STRING with 128 for both min and max length.
        case"PASSWORD_STRING":$pattern='/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{7,32}/';
            if(preg_match($pattern,$input)){$input=hash("whirlpool",$input);}else{$is_valid=false;}
        break;

        //Numeric String, float, or int. Can contain a single decimal point anywhere as well as a + or - only if it's the first character. Input is sanitized but not encoded.
        case"NUMBER":
            if($test_min_length){if(!self::testMinLength($input,$min_length)){$is_valid=false;}}
            if($test_max_length){if(!self::testMaxLength($input,$max_length)){$is_valid=false;}}
            if(is_numeric($input)){
                if($input!=0){
                    if(!$input=filter_var($input,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION)){$is_valid=false;}
                }else{$input=preg_replace('/[+\-]+/','',$input);}
            }else{$is_valid=false;}
        break;

        //DateTime String matching date("Y-m-d H:i:s"). Input is not encoded. 
        case"DATETIME":$pattern='/[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2} [0-9]{2}:[0-9]{2}:[0-9]{2}/';
            if(!preg_match($pattern,$input)){$is_valid=false;}
        break;

        //String that can contain anything including whitespace. Input is not encoded.
        case"URL_STRING":
            if($input==""){$is_valid=false;}
        break;

    default:$is_valid=false;}

//Determine how the function should return based on IS_VALID
if($is_valid){$output=$input;}else{$output=false;}

//Return Value
return $output;
}

/* CLASS CONSTRUCT METHOD */
public function __construct(){/* START CONSTRUCT METHOD DEFINITION */
}/* [END CONSTRUCT METHOD DEFINITION] */}?>