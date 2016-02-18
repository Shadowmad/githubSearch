<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
  header("Content-Type: text/html");
  include $_SERVER["DOCUMENT_ROOT"] . '/core/AltoRouter.php';

  $router = new AltoRouter();
  $router->setBasePath('');

  $router->map('GET','/', 'presentation/home.html', 'home');


  $match = $router->match();
  if($match) {
    require $match['target'];
  }
  else {
    header("HTTP/1.0 404 Not Found");
    require '404.html';
  }
?>
