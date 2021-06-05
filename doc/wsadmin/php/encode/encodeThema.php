<?php //encode.php
include("../function.php");
include("../property.php");
//
//SELECT Titel,Zusammenfassung,gehalten,Zielpublikum,hits,downloads,pdf,Arbeitsplatz,Erziehung,Gesundheit,Familie,thema_id,datumchange from vortrag
//SELECT id_thema,thema,datumchange from thema 
$i=0;
$result = mysqli_query($conn1, "SELECT id_thema,thema,datumchange from thema");
while ($row = mysqli_fetch_array($result)){
	$id_thema = $row["id_thema"];
	$thema = urlencode($row["thema"]);
	$datumchange = $row["datumchange"];

	$felder_mysql = "id_thema,thema,datumchange";
	$felder_form = "'$id_thema','$thema','$datumchange'";
	$query = "INSERT INTO thema2 ($felder_mysql) VALUES ($felder_form)";
	echo $query."<br>\n";
	mysqli_query($conn1, $query);
	$i++;

}
echo "Fertig<br>\n";
echo "das waren $i eintraege";

?>