<?php
//////Klasa BAZY DANYCH
class nSpeed_MySQL
{
  var $sql;
  var $wykonaj;

  var $name_db='';
  var $login_db='';
  var $pass_db='';
  var $file;
  private static $handle = NULL;
  
  function czas()
  {
           list($msek, $sek) = explode(' ', microtime());
           return ((float)$msek + (float)$sek);
  }

  function __construct()
  {
           $this->sql = mysql_connect('localhost', $this->login_db, $this->pass_db);

           //LOG - START
           $this->file = fopen('log.html','w');
           $log = "<style type='css/text'>a {font-size: 11px;font-family: verdana}</style><table border='1' bordercolor='orange'><tr><td style='width:800px;height:30px'><a>czynnosc</a></td><td><a>czas</a></td></tr><tr><td><a>POŁĄCZENIE Z MYSQL USTANOWIONE</a></td></tr>";
           fwrite($this->file,$log, strlen($log));
           //LOG - BREAK

           $this->query('use '.$this->name_db);
  }
  function getHandle()
  {
           if(!self::$handle)self::$handle = new nSpeed_MySQL;
           return self::$handle;
  }
  function __destruct(){ mysql_close($this->sql); $this->sql=NULL;$log='<tr><td><a>POŁĄCZENIE Z MYSQL ZAKOŃCZONE</a></td></tr></table>'; fwrite($this->file,$log, strlen($log));fclose($this->file);}

  function query($zapytanie,$cache = 0)
  {
          //LOG - START
           $start = $this->czas();
        //echo '<input type=\'text\' value="'.$zapytanie.'" style=\'width:600px\' /><br />';

         /*if(!$cache)
           {
                      $this->wykonaj = mysql_query($zapytanie) or die(mysql_error());
                      foreach($this->wykonaj as $wyk)
                      {
                        echo $wyk;
                      }
                      return $this->wykonaj;
           }
           
           $hash = md5($zapytanie);
           
           if(!file_exists('cmysql/'.$hash))
           {
                      $this->wykonaj = mysql_query($zapytanie) or die(mysql_error());
                      $file = fopen('cmysql/'.$hash,'w');
                      fwrite($file,$this->wykonaj, strlen($this->wykonaj));
                      fclose($file);
                      return $this->wykonaj;
           }
           $file_source = file_get_contents('cmysql/'.$hash);

           
           $filetime = filemtime('cmysql/'.$hash);
           
           if($filetime+$cache > time())
           {
                                   return $file_source;
           }
               
           $this->wykonaj = mysql_query($zapytanie) or die(mysql_error());
           $file = fopen('cmysql/'.$hash,'w');
           fwrite($file,$this->wykonaj, strlen($this->wykonaj));
           fclose($file);
           return $this->wykonaj;
          */  
          //echo $zapytanie.'<br />';
          $this->wykonaj = mysql_query($zapytanie) or die(mysql_error());


           $log = '<tr style=\'height: 30px\'><td><a>ZAPYTANIE:</a> <a style=\'font-weight:bold\'>'.$zapytanie.'</a></td><td>'.round($this->czas() - $start, 4).' s</td></tr>';
          fwrite($this->file,$log, strlen($log));
          //LOG - STOP


           return $this->wykonaj;
  }
  function getLastResult()
  {
           return $this->wykonaj;
  }

};
//include_once('cfg/database.php');
////////////////////////////
?>
