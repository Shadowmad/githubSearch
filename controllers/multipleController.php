<?php
  require_once($_SERVER['DOCUMENT_ROOT'] . "core/database.php");
  $connector = new Database();
  $request = array("projectID","projectName","projectStars","language");
  $data = json_encode(array("records"=>$connector->databaseRead($request, "reposTable")));
  echo ($data);
?>
