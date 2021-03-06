<?php
  require_once($_SERVER['DOCUMENT_ROOT'] . "/core/filters.php");
  class Database extends Filters{
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
      $this->columnNames = $this->columnsNamesFetching($tableName);
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
    public function databaseRead($toRead, $tableName,$whereCheck, $dataWhere = ""){
      $whereClause = "";
      $dataReturn = array();

      if($whereCheck == false)
        $whereClause = $this->databaseReadWhereFilter($dataWhere);
      if($whereCheck == true)
        $whereClause = $this->databaseReadWhereId($dataWhere);

      $queryString = $this->dbc->prepare($this->databaseReadSelect($tableName,$toRead) . $whereClause);
      $queryString->execute();
      return( $this->openPDOObject($queryString));
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

    private function databaseReadWhereFilter($dataWhere){
      return " WHERE projectStars BETWEEN '" . $dataWhere["slider"]["minValue"] . "' AND '" . $dataWhere["slider"]["maxValue"] . "' AND projectCreated " . $this->createBetweenFilter($dataWhere["date"]) . " AND language = '" . $dataWhere["lang"] . "'";
    }
    private function databaseReadWhereId($dataWhere){
      return " WHERE projectId = '$dataWhere'";
    }
    private function convertKeyValueToArray($dataWhere){
      $m = array();
      foreach ($dataWhere as $key => $value) {
        array_push($m,$value);
      }
      return $m;
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
    private function getTableColumns($tableName){
      $query = "SHOW COLUMNS FROM $tableName";
      $result = $this->dbc->prepare($query);
      try {
        $result->execute();
      } catch (Exception $e) {
        echo "Please try again later" . $e->getMessage();
      }
      return $result;
    }
    private function columnsNamesFetching($tableName){
      $arrayOfNames = array();
      $resultNames = $this->getTableColumns($tableName);

      foreach ($resultNames as $key => $value) {
        if($value["Extra"] == "auto_increment")
          continue;
        array_push($arrayOfNames, $value["Field"]);
      }
      return $arrayOfNames;
    }

  }
?>
