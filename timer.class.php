<?php
class nSpeed_Timer
{

  function czas()
  {
           list($msek, $sek) = explode(' ', microtime());
           return ((float)$msek + (float)$sek);
  }
  function start()
  {
           $this->iStart = $this->czas();
  }
  function stop()
  {
           return round($this->czas() - $this->iStart, 2);
  }
 var $iStart;
}

?>