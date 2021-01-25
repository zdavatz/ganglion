<?php

require_once($_SERVER['DOCUMENT_ROOT']."/html/php/mysql_header.php");

if(isset($_GET["id"]) && preg_match("/^[0-9]+$/",$_GET["id"]) && $_GET["download"]=='pdf')
{
  $query = "select pdf from vortrag where id=".$_GET["id"];
  $result = mysql_query($query);
  $values = mysql_fetch_assoc($result);
  $query = "update vortrag set downloads=downloads+1 where id=".$_GET["id"];
  mysql_query($query);

  header("Location: /pdf/".$values["pdf"]);
} elseif (isset($_GET["id"]) && preg_match("/^[0-9]+$/",$_GET["id"]) && $_GET["download"]=='audiofile') {
  $query = "select audiofile from vortrag where id=".$_GET["id"];
  $result = mysql_query($query);
  $values = mysql_fetch_assoc($result);
  $query = "update vortrag set audiofile_downloads=audiofile_downloads+1 where id=".$_GET["id"];
  mysql_query($query);

#  header("Location: http://ganglion.zftp.com/".$values["audiofile"]);
  header("Location: ".$values["audiofile"]);
} elseif (isset($_GET["id"]) && preg_match("/^[0-9]+$/",$_GET["id"]) && $_GET["download"]=='google_video') {
  $query = "select google_video_url from vortrag where id=".$_GET["id"];
  $result = mysql_query($query);
  $values = mysql_fetch_assoc($result);
  $query = "update vortrag set google_video_downloads=google_video_downloads+1 where id=".$_GET["id"];
  mysql_query($query);

  header("Location: ".$values["google_video_url"]);
}

?>
