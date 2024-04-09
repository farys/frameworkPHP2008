<?php
include_once('mysql.class.php');
class nSpeed_Table
{
      var $table_name;  /* nazwa tabeli */
      var $primary_key = NULL; /* klucz indeksowania */
      var $fields = NULL;     /* kolumny w tabeli */
      var $db;          /* baza danych */

      function nSpeed_Table($table, $primary_key = 'id') /* konstruktor */
      {
           $this->table_name = $table;
           $this->primary_key = $primary_key;
           $this->db = nSpeed_MySQL::getHandle();
      }

      function getFields() /* pobiera pola tabeli */
      {
           return $this->fields;
      }
      
      private function getAllFields() //mozna zastapic funkcj¹ __set()
      {
       $query = $this->db->query('DESCRIBE '.$this->table_name);

       while($result =  mysql_fetch_assoc($query)) //tworzy nowe pola i primary key
           {
                    $this->$result['Field'] = $result['Default'];
                    $this->fields[] = $result['Field'];
                    if($result['Key'] == 'PRI')
                    {
                      $this->primary_key=$result['Field'];
                      if($this->primary_key != 'id')$this->$result['Field'] =& $this->id;
                    }
           }

      }

      private function cleanFields() /* jesli sa zainicjowane pola to zwalnia je*/
      {
           foreach($this->fields as $field)
           {
                unset($this->$field);
           }
           $this->fields=NULL;
      }

      function newRecord()      /* tworzy nowy rekord */
      {
           if($this->fields) $this->cleanFields();
           
           $this->getAllFields();
      }

      function findRecord($id,$what = '*')   /* szuka rekordu; id - id rekordu, what - jakie pola pobrac*/
      {
           if($this->fields) $this->cleanFields();

           $result = $this->db->query('SELECT '.$what.' FROM '.$this->table_name.' WHERE '.$this->primary_key.'=\''.$id.'\'');

           if(!mysql_num_rows($result)) return false;

           $this->id = $id;
           $result = mysql_fetch_assoc($result);

           foreach($result as $key => $value)
           {
                 $this->fields[] = $key;
                 $this->$key = $value;
           }

           return true;
      }

      function find($what,$query)
      {

               if($result = $this->db->query('SELECT '.$what.' FROM '.$this->table_name.' WHERE '.$query))
               {
                          if(!($ile = mysql_num_rows($result)))return false;
                          $tables = array();

                          for($i=0;$i<$ile;$i++)
                          {
                                       $wynik=mysql_fetch_assoc($result);
                                       $tables[$i] = new fastTable;
                                       foreach($wynik as $key => $value) $tables[$i]->$key = $value;
                          }
                          return $tables;
               }

              return array();


      }
        function findSortedPrimary($what,$query)
      {

               if((strpos($what,$this->primary_key) === false) 
               && (strpos($what,'*') === false))
               return false;
               
               if($result = $this->db->query('SELECT '.$what.' FROM '.$this->table_name.' WHERE '.$query))
               {
                          if(!($ile = mysql_num_rows($result)))return false;
                          $tables = array();

                          for($i=0;$i<$ile;$i++)
                          {
                                       $wynik=mysql_fetch_assoc($result);
                                       $tables[$wynik[$this->primary_key]] = new fastTable;
                                       foreach($wynik as $key => $value) $tables[$wynik[$this->primary_key]]->$key = $value;
                          }
                          return $tables;
               }

              return array();


      }

      function save()
      {
         $set='';
         if(!$this->fields)return;
         if(isset($this->id) && $this->id)
         {

              foreach($this->fields as $field)
              {
              if($field != $this->primary_key)$set.=$field.'=\''.$this->$field.'\',';
              }
              $set[strlen($set)-1]=' ';

              $this->db->query('UPDATE '.$this->table_name.' SET '.$set.'WHERE '.$this->primary_key.'=\''.$this->id.'\'');

              return true;
         }

              $this->id = ' ';
              $this->{$this->primary_key} = 'NULL';
              foreach($this->fields as $field)
              {
                                    if($field != $this->primary_key)$set.='\''.$this->$field.'\',';
                                    else $set.='NULL,';
              }
              $set[strlen($set)-1]=')';
              $this->db->query('INSERT INTO '.$this->table_name.' VALUES('.$set);
      }
      function delete()
      {
            $this->db->query('DELETE FROM '.$this->table_name.' WHERE '.$this->primary_key.'=\''.$this->id.'\'');
      }

}
class fastTable
{

}


?>