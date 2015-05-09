<?php
/*
 * CLASS DESCRIPTION:
 * 
 */
final class lhDB{
/* CLASS PROPERTIES */
//PRIVATE SCOPE
private $db_dir; //Database Directory & Configuration Array
private $live_mode_usn;
private $live_mode_pwd;
private $dev_mode_usn;
private $dev_mode_pwd;
private $local_mode_usn;
private $local_mode_pwd;
private $is_connected; //Currently Connected to a Database [BOOLEAN]

//PROTECTED SCOPE

//PUBLIC SCOPE

/* CLASS OBJECTS */
//PRIVATE SCOPE

//PROTECTED SCOPE

//PUBLIC SCOPE
public $PDO;

/* CLASS METHODS */
//PRIVATE SCOPE

//PROTECTED SCOPE

//PUBLIC SCOPE
public function connect($db_selection){self::disconnect();
    if(array_key_exists($db_selection,$this->db_dir)){
        switch(BASE_URL){
            case"ibdlighthouse.com":
                $dsn=$this->db_dir[$db_selection]["LIVE_DSN"];
                $usn=$this->live_mode_usn;
                $pwd=$this->live_mode_pwd;
            break;
            case"dev.ibdlighthouse.com":
                $dsn=$this->db_dir[$db_selection]["DEV_DSN"];
                $usn=$this->dev_mode_usn;
                $pwd=$this->dev_mode_pwd;
            break;
            case"local.ibdlighthouse.com":
                $dsn=$this->db_dir[$db_selection]["LOCAL_DSN"];
                $usn=$this->local_mode_usn;
                $pwd=$this->local_mode_pwd;
            break;
        default:die('Permission Denied');}
        try{$this->PDO=new PDO($dsn,$usn,$pwd);$this->is_connected=true;}
        catch(PDOException $e){
            $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $e_msg=$e->getMessage();die('Database Connection Error: '.$e_msg);
        }
    }else{die('FATAL ERROR -> DBO::CONNECT - "Invalid Database Selection"');}
}
public function disconnect(){if($this->is_connected){$this->PDO=null;$this->is_connected=false;}}

/* CLASS CONSTRUCT METHOD */
public function __construct(){$this->is_connected=false;/* START CONSTRUCT METHOD DEFINITION */
    //Set Live Mode Username & Password
    $this->live_mode_usn="phpuser";
    $this->live_mode_pwd="KJHgi87G%jkjv@vkjj276hjsdakjFgjh";

    //Set Public Development Mode Username & Password
    $this->dev_mode_usn="devphpuser";
    $this->dev_mode_pwd="DEVgi42G%jkjv!vkjj273hjlfthjFgjh";

    //Set Local Development Mode Username & Password
    $this->local_mode_usn="root";
    $this->local_mode_pwd="";

    // Build Database Directory & Configuration Array
    $this->db_dir=array( //START Build db_dir Array
        
        //Lighthouse App:: HPA Reports - DC Form Submission Database
        "ibdapp_hpadcform"=>array(
            "LIVE_DSN"=>"mysql:host=localhost;dbname=hpadcform",
            "DEV_DSN"=>"mysql:host=localhost;dbname=dev_hpadcform",
            "LOCAL_DSN"=>"mysql:host=localhost;dbname=hpadcform",
        ),
        
        //Lighthouse CORE DB
        "ibdlighthouse"=>array(
            "LIVE_DSN"=>"mysql:host=localhost;dbname=ibdlighthouse",
            "DEV_DSN"=>"mysql:host=localhost;dbname=dev_ibdlighthouse",
            "LOCAL_DSN"=>"mysql:host=localhost;dbname=ibdlighthouse",
        ),

        //Lighthouse PostDefender DB
        "ibdpostdef"=>array(
            "LIVE_DSN"=>"mysql:host=localhost;dbname=ibdpostdef",
            "DEV_DSN"=>"mysql:host=localhost;dbname=dev_ibdpostdef",
            "LOCAL_DSN"=>"mysql:host=localhost;dbname=ibdpostdef",
        ),
        
        //Lighthouse User Session DB
        "ibdlhsession"=>array(
            "LIVE_DSN"=>"mysql:host=localhost;dbname=ibdlhsession",
            "DEV_DSN"=>"mysql:host=localhost;dbname=dev_ibdlhsession",
            "LOCAL_DSN"=>"mysql:host=localhost;dbname=ibdlhsession",
        ),

        

    ); //[END Build db_dir Array]
}/* [END CONSTRUCT METHOD DEFINITION] */}?>