<?php
  class Database{
    /* Variables */
    private $dbc;
    private $columnNames;
    private $countColumnNames;
    /* Functions */
    function Database(){
      /* Connect to an ODBC database using driver invocation */
      $dsn = 'mysql:host=localhost;dbname=github';
      $username = 'shadow';
      $password = 'VH25mbmel';
      $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
      );
      try {
        $this->dbc = new PDO($dsn, $username, $password, $options);
        $this->dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
      } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
      }
    }

    public function databaseInsert($toInsertData, $tableName){
      $this->columnNames = $this->columnsNamesFetching();
      $this->countColumnNames = count($this->columnNames);
      $queryString = $this->creatInsertString($tableName) ." ". $this->createOnUpdateString();

      $query = $this->dbc->prepare($queryString);
      print_r(count($toInsertData));
      foreach ($toInsertData as $key => $value) {
        for($i=0; $i<$this->countColumnNames; $i++){
          $query->bindParam(":$i",$value[$i]);
        }
        try {
          $query->execute();
        } catch (Exception $e) {
          echo $e->getMessage();
        }
      }

    }
    public function databaseRead($toRead, $tableName,$where = false, $dataWhere = ""){
      $whereClause = "";
      $dataReturn = array();
      if($where)
        $whereClause = $this->databaseReadWhere($dataWhere);

      $queryString = $this->dbc->prepare($this->databaseReadSelect($tableName,$toRead) . $whereClause);
      $queryString->execute();
      return $queryString;
    }
    public function databaseDistinct($toRead, $tableName){
      $queryString = $this->dbc->prepare("SELECT DISTINCT $toRead FROM $tableName");
      $queryString->execute();
      return ($queryString);
    }
    private function databaseReadSelect($tableName,$dataToRead){
      $tempString = "";
      for($i = 0; $i < count($dataToRead); $i++){
        $tempString = $tempString . $dataToRead[$i] . ",";
      }
      $tempString = substr($tempString,0,-1);
      $string = "SELECT $tempString FROM $tableName";
      return $string;
    }
    private function databaseReadWhere($dataWhere){
      return " WHERE projectID=" . $dataWhere;
    }

    private function creatInsertString($tableName){
      $tempNames = "";
      $tempValues = "";
      for($i=0; $i < $this->countColumnNames; $i++){
        $tempNames = $tempNames . $this->columnNames[$i] . ",";
      }
      $tempNames = substr($tempNames,0,-1);

      for($i=0; $i < count($this->columnNames); $i++){
        $tempValues = $tempValues . ":" . $i . ",";
      }
      $tempValues = substr($tempValues,0,-1);

      $string = "INSERT INTO $tableName ($tempNames) VALUES ($tempValues)";
      return $string;
    }
    private function createOnUpdateString(){
      $tempString = "";
      for($i=0; $i<$this->countColumnNames;$i++){
        $tempString = $tempString . $this->columnNames[$i] . " = (:" . $i . "), ";
      }
      $tempString = substr($tempString,0,-2);
      $string = "ON DUPLICATE KEY UPDATE " . $tempString;

      return $string;
    }
    private function getTableColumns(){
      $query = "SHOW COLUMNS FROM reposTable";
      $result = $this->dbc->prepare($query);
      try {
        $result->execute();
      } catch (Exception $e) {
        echo "Please try again later" . $e->getMessage();
      }
      return $result;
    }
    private function columnsNamesFetching(){
      $arrayOfNames = array();
      $resultNames = $this->getTableColumns();

      foreach ($resultNames as $key => $value) {
        if($value["Extra"] == "auto_increment")
          continue;
        array_push($arrayOfNames, $value["Field"]);
      }
      return $arrayOfNames;
    }


    /* MISC */



  }
?>
