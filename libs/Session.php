<?php

class Session {

   

    public static function init()
    {
         session_start();
    }
    
    

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    public static function get($key)
    {
        if(isset($_SESSION[$key]))
           return $_SESSION[$key];
        else 
            return $_SESSION[$key] = false;
    }
    
    public static function distroy()
    {
        
        unset($_SESSION);
        session_destroy();
        header('location:'.URL.'');
    }
    
    public static function sessionCheck(){
       return session_status();
    }
}