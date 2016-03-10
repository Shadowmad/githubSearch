<?php
  $text = "Max!";
  $val = str_split($text);
  for($i=0;$i < count($val); $i++){
    echo $val[$i];
    echo ord($val[$i]) + " ";
  }

 ?>
