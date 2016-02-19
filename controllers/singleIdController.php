<?php
  require_once($_SERVER['DOCUMENT_ROOT'] . "core/database.php");
  require_once($_SERVER['DOCUMENT_ROOT'] . "core/filters.php");
  $dataGet = (isset($_GET['id']) ? $_GET['id'] : "");
  $trueGet = (isset($_GET['single']) ? $_GET['single'] : false);
  $connector = new Database();
  $filter = new Filters();
  $data = json_encode(  array(  "records"=> $filter->openPDOObject(  $connector->databaseRead(array("*"), "reposTable", $trueGet, $dataGet)  )  ) );
  echo ($data);
?>
