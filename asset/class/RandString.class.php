<?php
/*
 * CLASS DESCRIPTION:
 * 
 */
final class RandString{
/* CLASS PROPERTIES */
//PRIVATE SCOPE
private $CHAR_LIST;

//PROTECTED SCOPE

//PUBLIC SCOPE
public $RAND_STR;

/* CLASS OBJECTS */
//PRIVATE SCOPE

//PROTECTED SCOPE

//PUBLIC SCOPE

/* CLASS METHODS */
//PRIVATE SCOPE

//PROTECTED SCOPE

//PUBLIC SCOPE

/* CLASS CONSTRUCT METHOD */
public function __construct($U,$L,$N,$S,$LENGTH){/* START CONSTRUCT METHOD DEFINITION */
    $this->CHAR_LIST=array();$KEY=0;
    if($U){$this->CHAR_LIST[$KEY]="A";$KEY++;$this->CHAR_LIST[$KEY]="B";$KEY++;$this->CHAR_LIST[$KEY]="C";$KEY++;$this->CHAR_LIST[$KEY]="D";$KEY++;$this->CHAR_LIST[$KEY]="E";$KEY++;$this->CHAR_LIST[$KEY]="F";$KEY++;$this->CHAR_LIST[$KEY]="G";$KEY++;$this->CHAR_LIST[$KEY]="H";$KEY++;$this->CHAR_LIST[$KEY]="I";$KEY++;$this->CHAR_LIST[$KEY]="J";$KEY++;$this->CHAR_LIST[$KEY]="K";$KEY++;$this->CHAR_LIST[$KEY]="L";$KEY++;$this->CHAR_LIST[$KEY]="M";$KEY++;$this->CHAR_LIST[$KEY]="N";$KEY++;$this->CHAR_LIST[$KEY]="O";$KEY++;$this->CHAR_LIST[$KEY]="P";$KEY++;$this->CHAR_LIST[$KEY]="Q";$KEY++;$this->CHAR_LIST[$KEY]="R";$KEY++;$this->CHAR_LIST[$KEY]="S";$KEY++;$this->CHAR_LIST[$KEY]="T";$KEY++;$this->CHAR_LIST[$KEY]="U";$KEY++;$this->CHAR_LIST[$KEY]="V";$KEY++;$this->CHAR_LIST[$KEY]="W";$KEY++;$this->CHAR_LIST[$KEY]="X";$KEY++;$this->CHAR_LIST[$KEY]="Y";$KEY++;$this->CHAR_LIST[$KEY]="Z";$KEY++;}unset($U);
    if($L){$this->CHAR_LIST[$KEY]="a";$KEY++;$this->CHAR_LIST[$KEY]="b";$KEY++;$this->CHAR_LIST[$KEY]="c";$KEY++;$this->CHAR_LIST[$KEY]="d";$KEY++;$this->CHAR_LIST[$KEY]="e";$KEY++;$this->CHAR_LIST[$KEY]="f";$KEY++;$this->CHAR_LIST[$KEY]="g";$KEY++;$this->CHAR_LIST[$KEY]="h";$KEY++;$this->CHAR_LIST[$KEY]="i";$KEY++;$this->CHAR_LIST[$KEY]="j";$KEY++;$this->CHAR_LIST[$KEY]="k";$KEY++;$this->CHAR_LIST[$KEY]="l";$KEY++;$this->CHAR_LIST[$KEY]="m";$KEY++;$this->CHAR_LIST[$KEY]="n";$KEY++;$this->CHAR_LIST[$KEY]="o";$KEY++;$this->CHAR_LIST[$KEY]="p";$KEY++;$this->CHAR_LIST[$KEY]="q";$KEY++;$this->CHAR_LIST[$KEY]="r";$KEY++;$this->CHAR_LIST[$KEY]="s";$KEY++;$this->CHAR_LIST[$KEY]="t";$KEY++;$this->CHAR_LIST[$KEY]="u";$KEY++;$this->CHAR_LIST[$KEY]="v";$KEY++;$this->CHAR_LIST[$KEY]="w";$KEY++;$this->CHAR_LIST[$KEY]="x";$KEY++;$this->CHAR_LIST[$KEY]="y";$KEY++;$this->CHAR_LIST[$KEY]="z";$KEY++;}unset($L);
    if($N){$this->CHAR_LIST[$KEY]="0";$KEY++;$this->CHAR_LIST[$KEY]="1";$KEY++;$this->CHAR_LIST[$KEY]="2";$KEY++;$this->CHAR_LIST[$KEY]="3";$KEY++;$this->CHAR_LIST[$KEY]="4";$KEY++;$this->CHAR_LIST[$KEY]="5";$KEY++;$this->CHAR_LIST[$KEY]="6";$KEY++;$this->CHAR_LIST[$KEY]="7";$KEY++;$this->CHAR_LIST[$KEY]="8";$KEY++;$this->CHAR_LIST[$KEY]="9";$KEY++;}unset($N);
    if($S){$this->CHAR_LIST[$KEY]="!";$KEY++;$this->CHAR_LIST[$KEY]="@";$KEY++;$this->CHAR_LIST[$KEY]="#";$KEY++;$this->CHAR_LIST[$KEY]="%";$KEY++;}unset($S);
    if($KEY!=0){$KEY--;
        if($LENGTH>=1){$this->RAND_STR="";
            while($LENGTH!=0){$X=rand(0,$KEY);$this->RAND_STR=$this->RAND_STR.$this->CHAR_LIST[$X];$LENGTH--;}unset($LENGTH);unset($KEY);unset($X);
        }else{die('Random String Generator - ERROR "Invalid String Length"');}
    }else{die('Random String Generator - ERROR "Invalid Character Options"');}
}/* [END CONSTRUCT METHOD DEFINITION] */}?>