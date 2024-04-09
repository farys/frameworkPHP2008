<?php

include('nspeed/mysql.class.php');
class nSpeed_Session
{

    function __construct()
    {        
       
        foreach($_SESSION as $s => $value) $this->$s = $value;
    }       
    function getHandle()
    {
        if(!self::$handle)self::$handle = new nSpeed_Session;
        return self::$handle;
    }
    function clear()
    {
        session_unset();
    }
    function register($name, $value = '')
    {
        $this->$name = $value;
        $_SESSION[$name] = $value;
    }
    function unRegister($name) //dopracowac
    {
        session_unregister($name);
    }
    function isRegistered($name)
    {
        return isset($_SESSION[$name]);
    }
      private static $handle = NULL;
}


?>