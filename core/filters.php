<?php
  Class Filters{
    public function Filters(){}

    public function toArray(){

    }


    public function openPDOObject($pdoObject){ //think of making forech to eliminate table columns names form output and change them to something
      $createJsonFromSQL = $pdoObject->fetchAll(PDO::FETCH_ASSOC);
      return ($createJsonFromSQL);
    }

  }

?>
