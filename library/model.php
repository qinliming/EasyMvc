<?php
/*
 * Author qinliming
 * date 30-6-2014
 * filename:model.php
 * email:qlm1991@hotmail.com
 * 
 * QiaWei all right reserved
 * 
 */

/*
 * request the medoo database orm library
 */
require_once $GLOBALS['projectroot']."/library/medoo.min.php";

/*
 * class Model the base class of Models
 * extends from medoo
 */
class Model extends medoo{
    public $database;
    public function __construct(){
        /* request the configure file of the database*/
        require_once $GLOBALS['projectroot']."/config.php";
        
        /*init medoo*/
        parent::__construct([
         // required
            'database_type' => 'mysql',
            'database_name' => $database_name,
            'server' => $server,
            'username' => $username,
            'password' => $password,
            'charset' => 'utf8',
            'option' => [
            PDO::ATTR_CASE => PDO::CASE_NATURAL
            ]
            ]);
    }
}
/*end of file Base.class.php*/
?>
