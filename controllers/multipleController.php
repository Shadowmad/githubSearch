<?php
  require_once($_SERVER['DOCUMENT_ROOT'] . "/core/database.php");
  $connector = new Database();

  $_POST = json_decode(file_get_contents('php://input'), true);
  $maxValueStars = (isset($_POST["slider"]["maxValue"]) ? $_POST["slider"]["maxValue"] : "0");
  $minValueStars = (isset($_POST["slider"]["minValue"]) ? $_POST["slider"]["minValue"] : "50000");
  $lang = (isset($_POST["selectLang"]["name"]) ? $_POST["selectLang"]["name"] : "php");

  $dateSet = (isset($_POST["select"]["date"]) ? $_POST["select"]["date"] : array("rangeFrom" => "0", "rangeTo" => "9999/12/12"));

  $request = array("projectID","projectName","projectStars","language");
  $data = json_encode(array(  "records" =>  $connector->databaseRead($request, "reposTable", false, array('slider' => array("minValue" => $minValueStars, "maxValue" => $maxValueStars), "date" => $dateSet, "lang" => $lang) ) ) );
  echo ($data);

?>
