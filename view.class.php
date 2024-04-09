<?php
class nSpeed_View
{
      //var $data = array();
      //var $template;
      function render($_filename)
      {
               include('app/templates/'.$_filename);
      }
      function escape($_what)
      {
               return htmlspecialchars($_what);
      }
      ///////////////////////////////////////////////////////////////////
      //function parseSite($htmlfile)
      //{
      //         $this->template = file_get_contents('app/templates/'.basename($htmlfile));
      //         echo str_replace(array_keys($this->data), array_values($this->data), $this->template);
      //}
      //function loadTemplate($htmlfile)
      //{
      //         return file_get_contents('app/templates/'.basename($htmlfile));
      //}
      //public function __set($name,$value)
      //{
      //         $this->data['{'.$name.'}'] = $value;
      //}

}

?>