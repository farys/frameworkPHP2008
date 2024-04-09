<?php
include('session.class.php');
class nSpeed_Access
{

      function __construct()
      {
               $this->session = nSpeed_Session::getHandle();
               if(!$this->session->isRegistered('nSpeedAccess')) $this->session->register('nSpeedAccess',$this->iDefaultAccess);
      }
      
      function getAccessNumber()
      {
               return $this->session->nSpeedAccess;
      }

      function isControllerAllowed($controller)
      {
               if($controller->iAccess <= $this->session->nSpeedAccess)return true;
               return false;
      }

      private $session = NULL;
      var $iDefaultAccess = 0; //default session access. [0 - 10]
}

?>