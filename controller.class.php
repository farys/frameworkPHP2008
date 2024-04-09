<?php
include_once('nspeed/nspeed.php');
class nSpeed_Controller
{

      function __call($name, $params)
      {
               if(substr($name,0,-6) != $this->sDefaultAction)
               {
                        return $this->{$this->sDefaultAction.'Action'}();
               }
               return false;
      }
      function getPostVariable($name)
      {
               if(!isset($_POST[$name]))return NULL;
               return addslashes(strip_tags($_POST[$name]));
      }
 public $iAccess = 0; //default access range [ 0- guest / 10- admin]
 public $sDefaultAction = '';
 public $sView = '';
 public $aViewParameters = array();
 public $aParameters = array();
}

?>