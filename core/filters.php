<?php
  Class Filters{
    private $startRange = "0";
    private $endRange   = "9999/12/12";

    public function Filters(){}

    public function openPDOObject($pdoObject){ //think of making forech to eliminate table columns names form output and change them to something
      $createJsonFromSQL = $pdoObject->fetchAll(PDO::FETCH_ASSOC);
      return ($createJsonFromSQL);
    }

    public function createBetweenFilter($arrayOfDataToLookUp){
      $stringToReturn = "";
      foreach ($arrayOfDataToLookUp as $key => $value) {
        if(strpos($key,"Before")){
          $stringToReturn .= " BETWEEN '$this->startRange' AND '$value'";
        }
        if(strpos($key,"After")){
          $stringToReturn .= " BETWEEN '$value' AND '$this->endRange'";
        }
        if(strpos($key,"From")){
          $stringToReturn .= " BETWEEN '$value' ";
        }
        if(strpos($key,"To")){
          $stringToReturn .= "'$value'";
        }
      }
      return $stringToReturn;
    }

    private function checkForRange(){

    }

  }
?>
