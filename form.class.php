<?php
class nSpeed_Form
{

      function __construct($action = '...', $method = 'post')
      {
               $this->sHTMLCode='<form action=\''.$action.'\' method=\''.$method.'\'>';
      }
      function setNewForm($action = '...', $method = 'post')
      {
               $this->sHTMLCode='<form action=\''.$action.'\' method=\''.$method.'\'>';
      }
      function addTextInput($name, $value = '', $afterInput= '')
      {
               $this->sHTMLCode.='<input type=\'text\' name=\''.$name.'\' value=\''.$value.'\' />'.$after_input;
      }
      function addHiddenInput($name, $value = '')
      {
               $this->sHTMLCode.='<input type=\'hidden\' name=\''.$name.'\' value=\''.$value.'\' />';
      }
      function addRadioInput($name, $value = '', $values = array(), $afterInput= '')
      {
               foreach($values as $val => $des)
               {
              //         $this->sHTMLCode.='<input type=\'radio\' name=\''.$name.'\' value=\''.$val.'\''.{($value != $val)?  '/>' : ' checked=\'checked\' />';}.$des.$afterInput;
               }
      }
      function addSelectInput($name, $value = '', $values = array())
      {
               $this->sHTMLCode.='<select name='.$name.'>';
               foreach($values as $val)
               {
                       //$this->sHTMLCode.='<option'.{($value != $val)?  '>' : ' selected=\'selected\' >';}.$val.'</option>';
               }
               $this->sHTMLCode.='</select>';
      }


      function addHTMLCode($code)
      {
               $this->sHTMLCode.=$code;
      }
      function getParsedForm()
      {
               return $this->sHTMLCode.'</form>';
      }
      function getPostVariable($name)
      {
               if(!isset($_POST[$name]) || !$_POST[$name])return NULL;
               return addslashes(strip_tags($_POST[$name]));
      }

      private $sHTMLCode = '';

}

?>