<?php

require_once($_SERVER['DOCUMENT_ROOT']."/html/php/mysql_header.php");

if(isset($_GET["id"]) && preg_match("/^[0-9]+$/",$_GET["id"]))
{
  $query = "select pdf from artikel where id_artikel=".$_GET["id"];
  $result = mysql_query($query);
  $values = mysql_fetch_assoc($result);
  $query = "update artikel set downloads=downloads+1 where id_artikel=".$_GET["id"];
  mysql_query($query);

  header("Location: /pdf/".$values["pdf"]);
}

?>
