<?php
$url = $_SERVER["PHP_SELF"];
$link = array
(
	"../index.php"				=>	"Home",
  "vortraege.php"				=>  "Vortr&auml;ge",
  "kurse.php"					=>  "Kurse",
  "kontakt.php"					=>  "Kontakt",
  "artikel.php"					=>  "Zeitschriften",
  "links.php"					=>  "Links",
  "Tagungen.php"				=>  "<b><a href='http://adhs.expert/tagungen' target='blank'>Tagungen</a></b>",
  "schizoli.php"				=>  "<b><a href='http://adhs.expert' target='blank'>adhs.expert</a></b>",
  "therapjur.php"				=>  "<b><a href='http://therapjur.net' target='blank'>Therapjur.net</a></b>",
  "twitter.php"				=>  "<b><a href='https://twitter.com/udavatz' target='blank'>Twitter</a></b>",
  "facebook.php"				=>  "<b><a href='https://facebook.com/schizoadhs' target='blank'>Facebook</a></b>",
  "youtube.php"				=>  "<b><a href='https://www.youtube.com/watch?v=HyDMtL-W-yI&list=UUDZ9tWjHLJIvwwl40XbaT1w' target='blank'>Youtube</a></b>",
//  "stelle.php"				        =>  "<b><a href='http://goo.gl/0qZjD' target='blank'>Assistenz-Arzt/&Auml;rztin gesucht</a></b>",
);
echo  "<table class='navbar-table' cellspacing='0'><tr>";
$spacer = false;
foreach($link as $key => $value)
{
  if($spacer)
  {
    echo "<td>&nbsp;|&nbsp;</td>";
  }
  else
  {
    $spacer = true;
  }
  if($url == "/html/".$key)
  {
    echo "<td class='navbar-hell'>$value</td>\n";
  }
  else
  {
    echo "<td><a class='navbar' href='/html/$key'>$value</a></td>\n";
  }
}
echo	"</tr></table>";
?>

