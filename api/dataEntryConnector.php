<?php
  require_once($_SERVER['DOCUMENT_ROOT']."/api/dataEntryPoint.php");
  require_once($_SERVER['DOCUMENT_ROOT']."/core/database.php");
  $apiDataObject = new dataEntryPoint();
  $sortedData = $apiDataObject->getSortedDataFullList("language:php","stars");
  print_r($sortedData);
  $dataConn = new Database();
  $dataConn->databaseInsert($sortedData,"reposTable");
?>
