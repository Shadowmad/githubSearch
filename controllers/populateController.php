<?php
  require_once($_SERVER['DOCUMENT_ROOT'] . "/core/database.php");
  require_once($_SERVER['DOCUMENT_ROOT'] . "/core/filters.php");
  $dataGet = new Database();
  $filter = new Filters();
  $data = json_encode(  array(  "records"=> $filter->openPDOObject(  $dataGet->databaseDistinct("language", "reposTable")  )  ) );
  echo ($data);


?>
