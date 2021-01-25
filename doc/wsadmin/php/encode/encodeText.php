<?php //encode.php
include("../function.php");
include("../property.php");
//
//SELECT Titel,Zusammenfassung,gehalten,Zielpublikum,hits,downloads,pdf,Arbeitsplatz,Erziehung,Gesundheit,Familie,thema_id,datumchange from vortrag
//SELECT bereich_text,inhalt_text,datum_text from text 
$i=0;
$result = mysql_query("SELECT bereich_text,inhalt_text,datum_text from text");
while ($row = mysql_fetch_array($result)){
	$bereich_text = urlencode($row["bereich_text"]);
	$inhalt_text = urlencode($row["inhalt_text"]);
	$datum_text = $row["datum_text"];

	$felder_mysql = "bereich_text,inhalt_text,datum_text";
	$felder_form = "'$bereich_text','$inhalt_text','$datum_text'";
	$query = "INSERT INTO text2 ($felder_mysql) VALUES ($felder_form)";
	echo $query."<br>\n";
	mysql_query($query);
	$i++;

}
echo "Fertig<br>\n";
echo "das waren $i eintraege";

?>