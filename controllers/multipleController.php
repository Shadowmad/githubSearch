<?php
  require_once($_SERVER['DOCUMENT_ROOT'] . "core/database.php");
  require_once($_SERVER['DOCUMENT_ROOT'] . "core/filters.php");
  $connector = new Database();
  $filter = new Filters();
  $request = array("projectID","projectName","projectStars","language");
  $data = json_encode(array(  "records" =>  $filter->openPDOObject($connector->databaseRead($request, "reposTable") ) ) );
  echo ($data);
?>
