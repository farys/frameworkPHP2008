<?php
//////Klasa MAIL

class nSpeed_Mail
{
  var $from;
  var $from_display = '';
  var $to;
  var $to_display = '';
  var $subject;
  var $message;

      private $login = '';
      private $password = '';
      private $smtp_host = '';
      private $localhost = '127.0.0.1';
      private $socket;

    function send()
    {
         if($this->message == '')return false;
         if(!$this->from_display)$this->from_display=$this->from;
         if(!$this->to_display)$this->to_display=$this->to;

         $this->socket = fsockopen($this->smtp_host,25); //otwieranie polaczenia
         if(!$this->answer('220'))return false;

         fputs($this->socket,'helo '.$this->localhost."\r\n"); //przywitanie sie
         if(!$this->answer('250'))return false;

         fputs($this->socket,"auth login\r\n".base64_encode($this->login)."\r\n".base64_encode($this->password)."\r\n"); //przywitanie sie
         if(!$this->answer('334'))return false;
         if(!$this->answer('334'))return false;
         if(!$this->answer('235'))return false;

         fputs($this->socket,'mail from:<'.$this->from.">\r\n");
         if(!$this->answer('250'))return false;
         
         fputs($this->socket,'rcpt to:<'.$this->to.">\r\n");
         if(!$this->answer('250'))return false;
         
         fputs($this->socket,"data\r\n");
         if(!$this->answer('354'))return false;
         $data = "Content-Type: text/html; charset=windows-1250\r\n";
         $data .= 'From: "'.$this->from_display.'" <'.$this->from.">\r\n";
         $data .= 'To: "'.$this->to_display.'" <'.$this->to.">\r\n";
         $data .= 'Subject: '.$this->subject."\r\n";
         $data .= $this->message."\r\n";
         $data .= ".\r\n";
         fputs($this->socket,$data);
         if(!$this->answer('250'))return false;

         fputs($this->socket,"quit\r\n");
         if(!$this->answer('221'))return false;
         
         return true;
    }

    private function answer($good)
    {
         if(substr(fgets($this->socket),0,3) != $good)return false;
         return true;
    }

};



////////////////////////////
?>
