<?php
  require_once($_SERVER['DOCUMENT_ROOT'] . "core/database.php");
  require_once($_SERVER['DOCUMENT_ROOT'] . "core/filters.php");
  $connector = new Database();
  $filter = new Filters();


  $_POST = json_decode(file_get_contents('php://input'), true);
  print_r($_POST);
  $request = array("projectID","projectName","projectStars","language");
  $data = json_encode(array(  "records" =>  $filter->openPDOObject($connector->databaseRead($request, "reposTable") ) ) );
  echo ($data);
?>
