<?php //links.php

//register session variables
session_register("php_link_search");
session_register("php_link_sortierung");
session_register("php_link_zeitfenster");

//keep vars or replace?
if (!isset($search)) 		$search 	= (empty($php_link_search) ? "all" : $php_link_search);
if (!isset($sortierung))	$sortierung = (empty($php_link_sortierung) ? "datum DESC" : $php_link_sortierung);
if (!isset($zeitfenster)) 	$zeitfenster = (empty($php_link_zeitfenster) ? 0 : $php_link_zeitfenster);

//remember variables for next run
$php_link_search=$search;
$php_link_sortierung=trim($sortierung);
$php_link_zeitfenster=$zeitfenster;

//check in which Bereich there are entries to be displayed...
$query = "SELECT MAX(Familie) AS f, MAX(Arbeit) AS a, MAX(Gesundheit) AS g, MAX(Erziehung) AS e FROM links";
$result = mysqli_query($conn1, $query);
list ($Familie, $Arbeit, $Gesundheit, $Erziehung) = mysqli_fetch_row($result);
mysqli_free_result($result);
echo "<p>&linksFamilie=$Familie&</p>\n";
echo "<p>&linksArbeit=$Arbeit&</p>\n";
echo "<p>&linksGesundheit=$Gesundheit&</p>\n";
echo "<p>&linksErziehung=$Erziehung&</p>\n";
$linkSumme=$Familie+$Arbeit+$Gesundheit+$Erziehung-$$bereich;
echo "<p>&linkSumme=$linkSumme&</p>\n";

$felderIn_links = "url, text, thema_id, Familie, Arbeit, Gesundheit, Erziehung, datum";
$felderIn_thema = "id_thema, thema";
$tabellenIn_ganglion = "links AS A, thema AS B";
$whereBedingungen = "B.id_thema = A.thema_id AND $bereich=1";
$precision = ($search=="all" ? "" : "A.thema_id='" . mysqli_real_escape_string($conn1,$search) . "' AND");
$epoche = ($zeitfenster == 0 ? "" : "AND TO_DAYS(datum) > (TO_DAYS(NOW())-$zeitfenster)");

$query = "SELECT $felderIn_links, $felderIn_thema FROM $tabellenIn_ganglion WHERE $precision $whereBedingungen $epoche ORDER BY $sortierung";
echo "query = $query <br>";

$result = mysqli_query($conn1, $query);

$i=0;

while($row = mysqli_fetch_array($result)){
	$url=$row["url"];
	$uri=(substr($url, 0, 7) == "http://" ? "" : "http://").$url;
	$link=($url == $uri ? substr($url, 7, strlen($url)-6) : $url);
	echo"<p>&url$i=".$uri."&</p>\n";
	$text=stripslashes($row["text"]);
	echo"<p>&text$i=".(empty($text) ? $link : $text)."&</p>\n";
	echo"<p>&thema$i=".stripslashes($row["thema"])."&</p>\n";
	echo"<p>&datum$i=".datum_ch($row["datum"])."&</p>\n";

	$i++;
}
	if ($i==0){
		echo "<p>&text0=Keine Eintr%E4ge vorhanden&</p>\n";
		$i=1;
	}


echo"<p>&anzahl=$i&</p>\n";
echo"<p>&eof=true&</p>\n";

mysqli_free_result($result);

?>

