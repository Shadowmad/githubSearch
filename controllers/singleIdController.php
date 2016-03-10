<?php
  require_once($_SERVER['DOCUMENT_ROOT'] . "/core/database.php");
  $dataGet = (isset($_GET['id']) ? $_GET['id'] : "");
  $trueGet = (isset($_GET['single']) ? $_GET['single'] : false);
  $connector = new Database();
  $data = json_encode(  array(  "records"=>   $connector->databaseRead(array("*"), "reposTable", $trueGet, $dataGet)  )  );
  echo ($data);
?>
