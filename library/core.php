<?php
/*
 * Author:qinliming
 * date 29-6-2014
 * Email:qlm1991@hotmail.com
 * 
 * QiaWei All right reserved
 */
/* to include the database init class*/
require_once $GLOBALS['projectroot']."/library/model.php";
require_once $GLOBALS['projectroot']."/library/xss_remove.php";

/*
 * this function define the render method of the template 
 * @param $view the view path
 * @oaram $data the assigned data
 * 
 */
function render($view,$data=Array()){
    require_once $GLOBALS['projectroot']."/library/smarty/Smarty.class.php";
    $smarty = new Smarty;
    $smarty->caching=TRUE;
    $smarty->cache_lifetime=120;
    while (list($key,$value) = each($data)){
        $smarty->assignByRef($key, $value);
    }
    $path = $GLOBALS['projectroot']."/view/".$view;
    $smarty->display($path);
}

/*
 * function getModel()
 * 
 * @param $name the Model name;
 * this function defined to get the database operation  classes(Models)
 * return the Models'Object
 */
function  getModel($name){
    require_once $GLOBALS['projectroot']."/model/".strtolower($name).".php";
    return new $name();
}
/*
 * class EasyMvc
 * the core Class of this frame
 * mantains the requst from browser  
 */
class EasyMvc{
    /*init this class*/
    public function __construct() {
    }
    
    /*
     * get the request method
     * return String 
     */
    public function getMethod(){
        return $_SERVER['REQUEST_METHOD'];
    }
    
    /*
     * check the requestmethod
     * return if the request is get return true;
     * if the request is post return false
     * otherwise die()
     */
    public function checkMethod(){
        if($this->getMethod()=="GET"){
            return TRUE;
        }else if($this->getMethod()=="POST"){
            return FALSE;
        }  else {
           die("unsupported request!");
        }
    }
    
    /*
     * get the requestString
     * return for example you url is qiawei.com/?r=abc/bcd
     * you will get String "abc/bcd"
     * if not "r=xxx" this script will die();
     * this is designed to avoid security problems
     */
    public function getRequestString(){
        if(@$_SERVER['QUERY_STRING']!=""){
            $piece = explode("=",$_SERVER['QUERY_STRING']);
            if($piece[0]=='r'){
                return $piece[1];
            }else
            {
                die("illegal request");
            }
        }  
        else 
        {
            return "";
        }
    }
    
    /*
     * in this framework every page have a handler
     * this function is defined to get the Handler's name
     * return String handlerName
     * 
     */
    public function getHandlerName(){
        $namelist = $this->getRequestString();
        if($namelist==""){
            return "index";
        }else
        {
            $queryArray = explode("/", $namelist);
            return $queryArray[0];
        }
    }
    
    /*
     * this function will get the handler
     * return Object Handler requested
     */
    public function getHandler(){
        $name = $this->getHandlerName();
        $handlerfile =$GLOBALS['projectroot']."/handler/".$name.".php";
        if(file_exists($handlerfile)){
            require_once $handlerfile;
            $classname = ucfirst($name);
            return new $classname();
        }
        else
        {
            die("handler not found");
        }
    }
    
    /*
     * to get the get data of a get Request
     * return Array an array of get data 
     */
    public function getGetDate(){
        return explode("/",$this->getRequestString());
    }
    
    /*
     * to get the post date of a post Request
     * return Array an array of post data
     */
    public function getPostDate(){
        return $_POST;
    }
    
    /*
     *the boot function of this frameworkd 
     */
    public function start(){
        $handler = $this->getHandler();
        if($this->checkMethod()){
            $handler->get($this->getGetDate());
        }
        else
        {
            $handler->post($this->getPostDate());
        }
    }
} 
/*end of class EasyMvc*/
 