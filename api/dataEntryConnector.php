<?php
  require_once($_SERVER['DOCUMENT_ROOT']."/api/dataEntryPoint.php");
  require_once($_SERVER['DOCUMENT_ROOT']."/core/database.php");
  $apiDataObject = new dataEntryPoint();
  $sortedData = $apiDataObject->getSortedDataFullList("language:php","stars");
  //print_r(json_decode(json_encode($sortedData),true));
  $dataConn = new Database();
  $dataConn->databaseInsert($sortedData,"reposTable");
?>
