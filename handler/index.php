<?php
class Index{
    function get($data){
       $model = getModel("Test");
       $data = $model->i();
       while(list($key,$value)=  each($data)){
           print $key;
           print " : ";
           print $value;
           print "<br/>";
       } 
       print "<html><body>";
       print "<form method=\"post\" action=\"\">"
       . "<input type=\"text\" name=\"test\">"."<input type=\"submit\" value=\"ok\">"
               . "</form>";
       print "</body></html>";
    }
    function post($data){
       print $data["test"];
       echo remove_xss("<script></script>");
    }
}