<?php
//////Klasa szablonów
class nSpeed_Template
{
    var $data = array();      //wartosci kluczy
    var $template; //kod szablonu HTML
    function __construct($filename = NULL)
    {
       if($filename) $this->template = file_get_contents('app/templates/'.basename($filename));
    }
    function loadTemplateFile($filename)
    {
        $this->template = file_get_contents('app/templates/'.basename($filename));
    }
    
    public function __set($name,$value)
    {
               $this->data['{'.$name.'}'] = $value;
    }
    function parseSite()
    {
        echo str_replace(array_keys($this->data), array_values($this->data), $this->template);
    }
    function getParsedSite()
    {
        return str_replace(array_keys($this->data), array_values($this->data), $this->template);
    }
}
////////////////////////////
?>