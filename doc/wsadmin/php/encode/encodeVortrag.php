<?php //encode.php
include("function.php");
include("property.php");
//
//SELECT Titel,Zusammenfassung,gehalten,Zielpublikum,hits,downloads,pdf,Arbeitsplatz,Erziehung,Gesundheit,Familie,thema_id,datumchange from vortrag
//SELECT bereich_text,inhalt_text,datum_text from text 
$i=0;
$result = mysql_query("SELECT Titel,Zusammenfassung,gehalten,Zielpublikum,hits,downloads,pdf,Arbeitsplatz,Erziehung,Gesundheit,Familie,thema_id,datumchange from vortrag");
while ($row = mysql_fetch_array($result)){
	$Titel = urlencode($row["Titel"]);
	$Zusammenfassung = urlencode($row["Zusammenfassung"]);
	$gehalten = $row["gehalten"];
	$Zielpublikum = urlencode($row["Zielpublikum"]);
	$hits = "1";
	$downloads = "1";
	$pdf = $row["pdf"];
	$Arbeitsplatz = $row["Arbeitsplatz"];
	$Erziehung = $row["Erziehung"];
	$Gesundheit = $row["Gesundheit"];
	$Familie = $row["Familie"];
	$thema_id = $row["thema_id"];
	$datumchange = $row["datumchange"];

	$felder_mysql = "Titel, Zusammenfassung, Zielpublikum, gehalten, pdf, Arbeitsplatz, Erziehung, Gesundheit, Familie, thema_id, datumchange";
	$felder_form = "'$Titel', '$Zusammenfassung', '$Zielpublikum','$gehalten', '$pdf', '$Arbeitsplatz', '$Erziehung', '$Gesundheit', '$Familie', '$thema_id', '$datumchange'";
	$query = "INSERT INTO vortrag2 ($felder_mysql) VALUES ($felder_form)";
	echo $query."<br>\n";
	mysql_query($query);
	$i++;

}
echo "Fertig<br>\n";
echo "das waren $i eintraege";

?>