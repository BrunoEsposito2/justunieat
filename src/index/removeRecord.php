<?php
  session_start();
  $val = $_REQUEST["val"];
  $id = session_id();

  function getVet($id, $val) {
    $temp = $_SESSION[$id];
    foreach ($temp as $key => $value) {
      //echo "OUT ->".$key;
      if($value === $val) {
        //echo "IN ->".$key."\n";
        unset($temp[$key]);
        return $temp;
      }
    }
    return $temp;
  }

  reset($_SESSION[$id]);
  $_SESSION[$id] = getVet($id, $val);

?>
