<?php
class nSpeed_Route
{
      public function go($url)
      {
             header('Location: '.$url);
             exit;
      }
      public function start()
      {
        
      }
}


?>