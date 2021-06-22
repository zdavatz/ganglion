<?php

require_once($_SERVER['DOCUMENT_ROOT']."/html/php/mysql_header.php");

if(isset($_GET["id"]) && preg_match("/^[0-9]+$/",$_GET["id"]))
{
  $query = "select pdf from artikel where id_artikel='".mysqli_real_escape_string($conn1,$_GET["id"])."'";
  $result = mysqli_query($conn1, $query);
  $values = mysqli_fetch_assoc($result);
  $query = "update artikel set downloads=downloads+1 where id_artikel='".mysqli_real_escape_string($conn1,$_GET["id"])."'";
  mysqli_query($conn1, $query);

  header("Location: /pdf/".$values["pdf"]);
}

?>
