<?php
/*
*	printVortraege.php -- by Daniel Strathemeier <dstrathemeier@ywesee.com>
*
*
*/
include("function.php");
include("property.php");
include("browser.php");
include("object.php");
//

//echo $nocache;
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD html 4.0 Transitional//EN"
 "http://www.w3.org/TR/REC-html40/loose.dtd">
 
<html>
<head>
<title>Übersicht Vorträge Ganglion</title>
<link rel="stylesheet" href="/wsadmin/css/print.css" type="text/css">
</head>
<body>
<?php
//sortieren
//
//
if (empty($sortby)) $sortby="Titel";
if ($sortby == "standart" && $search != "all") $sortby = "Titel";
if ($sortby == "standart" && $search == "all") $sortby = "Thema";


	if 	(isset($sortby) && $sortby=="Titel")			{	$SortBy="Titel ASC";		$order[0] = 1;	}
	elseif	(isset($sortby) && $sortby=="datum")		{	$SortBy="gehalten DESC"; 	$order[1] = 1;	}
	elseif	(isset($sortby) && $sortby=="Thema")		{	$SortBy="thema  ASC";		$order[2] = 1;	}
	elseif	(isset($sortby) && $sortby=="Familie")		{	$SortBy="Familie DESC";		$order[3] = 1;	}
	elseif	(isset($sortby) && $sortby=="Arbeit")		{	$SortBy="Arbeit DESC";$order[4] = 1;	}
	elseif	(isset($sortby) && $sortby=="Gesundheit")	{	$SortBy="Gesundheit DESC";	$order[5] = 1;	}
	elseif	(isset($sortby) && $sortby=="Erziehung")		{	$SortBy="Erziehung DESC";	$order[6] = 1;	}
	elseif	(isset($sortby) && $sortby=="hits")			{	$SortBy="hits DESC";		$order[7] = 1;	}
	elseif	(isset($sortby) && $sortby=="downloads"	)	{	$SortBy="downloads DESC";	$order[8] = 1;	}
	elseif	(isset($sortby) && $sortby=="pdf")			{	$SortBy="pdf DESC";			$order[9] = 1;	}
//
	elseif  (isset($sortby) && $sortby=="Titel-")		{	$SortBy="Titel DESC";		}
	elseif  (isset($sortby) && $sortby=="datum-")	{	$SortBy="gehalten ASC";		}
	elseif  (isset($sortby) && $sortby=="Thema-")	{	$SortBy="thema  DESC";		}
	elseif	(isset($sortby) && $sortby=="Familie-")		{	$SortBy="Familie ASC";		}
	elseif	(isset($sortby) && $sortby=="Arbeit-")		{	$SortBy="Arbeit ASC";	}
	elseif	(isset($sortby) && $sortby=="Gesundheit-")	{	$SortBy="Gesundheit ASC";	}
	elseif	(isset($sortby) && $sortby=="Erziehung-")		{	$SortBy="Erziehung ASC";	}
	elseif	(isset($sortby) && $sortby=="hits-")			{	$SortBy="hits ASC";			}
	elseif	(isset($sortby) && $sortby=="pdf-")			{	$SortBy="pdf ASC";			}
//
//
(isset($order[0]) && $order[0] == 1) ? $Titel = "Titel-"           : $Titel = "Titel";
(isset($order[1]) && $order[1] == 1) ? $datum = "datum-"           : $datum = "datum";
(isset($order[2]) && $order[2] == 1) ? $Thema = "Thema-"           : $Thema = "Thema";
(isset($order[3]) && $order[3] == 1) ? $Familie = "Familie-"       : $Familie = "Familie";
(isset($order[4]) && $order[4] == 1) ? $Arbeit = "Arbeit-"         : $Arbeit = "Arbeit";
(isset($order[5]) && $order[5] == 1) ? $Gesundheit = "Gesundheit-" : $Gesundheit = "Gesundheit";
(isset($order[6]) && $order[6] == 1) ? $Erziehung = "Erziehung-"   : $Erziehung = "Erziehung";
(isset($order[7]) && $order[7] == 1) ? $hits = "hits-"             : $hits = "hits";
(isset($order[8]) && $order[8] == 1) ? $downloads = "downloads-"   : $downloads = "downloads";
(isset($order[9]) && $order[9] == 1) ? $pdf = "pdf-"               : $pdf = "pdf";
//


$result = mysql_query ("SELECT * FROM vortrag AS A, thema AS B WHERE A.thema_id=B.id_thema ORDER BY $SortBy");
$Ptot = mysql_num_rows($result);


	echo "<table class='TABLEliste' width='100%' cellspacing='2'>\n";
	echo "<tr>\n";

	echo "<th nowrap>Nr. <font size='1'>($Ptot)</font></th>\n";

	echo "<th>\n";
	echo "	<a class='Atitel' href='echo PHP_SELF?&sortby=$Titel'>Titel</a>\n";
	echo "</th>\n";

	echo "<th>\n";
	echo "	<a class='Atitel' href='echo PHP_SELF?&sortby=$datum'>Datum</a>\n";
	echo "</th>\n";

	echo "<th>\n";
	echo "	<a class='Atitel' href='echo PHP_SELF?&sortby=$pdf'>PDF</a>\n";
	echo "</th>\n";

	echo "<th>\n";
	echo "	<a class='Atitel' href='echo PHP_SELF?&sortby=$hits'>Gelesen</a>\n";
	echo "</th>\n";

	echo "<th>\n";
	echo "	<a class='Atitel' href='echo PHP_SELF?&sortby=$downloads'>Downloads</a>\n";
	echo "</th>\n";

	echo "<th>Thema</th>\n";

	echo "<th>\n";
	echo "	<a class='Atitel' href='echo PHP_SELF?&sortby=$Familie'>F</a>\n";
	echo "</th>\n";

	echo "<th>\n";
	echo "	<a class='Atitel' href='echo PHP_SELF?&sortby=$Arbeit'>A</a></th>\n";

	echo "<th>\n";
	echo "<a class='Atitel' href='echo PHP_SELF?&sortby=$Gesundheit't'>G</a></th>\n";

	echo "<th>\n";
	echo "	<a class='Atitel' href='echo PHP_SELF?&sortby=$Erziehung'>E</a></th>\n";
	echo "</tr>\n";


//

$ok = "<img class='IMGok' src='../images/OK.gif' alt=''>";
$i = 1;
while ($row = mysql_fetch_array($result)){
	$gehalten = datum_ch($row["gehalten"]);
	$id = $row["id"];
	$thema_id = $row["thema_id"];
	$Titel = urldecode($row["Titel"]);
	if (empty($Titel)) $Titel = "***";
	$statusTitel = addslashes($Titel);
	//$statusTitel = $Titel;
	$pdf_file = $row["pdf"];
	$pdf_path = "/var/www/ganglion.ch/doc/pdf/".$pdf_file;
	$pdf_file = @filesize($pdf_path);
	$pdf_file > 4096 ? $pdf_file = $ok : $pdf_file ="";
	$thema = urldecode($row["thema"]);
	$thema = $thema;
	$hits = $row["hits"];
	$fam = $row["Familie"];
	$arb = $row["Arbeit"];
	$ges = $row["Gesundheit"];
	$erz = $row["Erziehung"];
	if ($fam == 1) { $fam = $ok; }	else 	{ $fam = "&nbsp;"; 	}
	if ($arb == 1) { $arb = $ok; }	else 	{ $arb = "&nbsp;"; 	}
	if ($ges == 1) { $ges = $ok; }	else 	{ $ges = "&nbsp;"; 	}
	if ($erz == 1) { $erz = $ok; }	else	{ $erz = "&nbsp;"; 	}
	if (empty($id))  	$id		= "&nbsp;";
	if (empty($Titel)) 	$Titel	= "&nbsp;";
	if (empty($thema))  $thema	= "&nbsp;";
	if ($gehalten == "01.01.1970") $gehalten = "&nbsp;";
	echo "<tr>\n";
	echo "<td class='TDnr'>$i</td>\n";
	echo "	<td class='TDtitel'>".$Titel."</td>\n";
	echo "	<td class='TDdatum'>".$gehalten."</td>\n";
	echo "	<td class='TDzahl'>".$pdf_file."</td>\n";
	echo "	<td class='TDzahl'>".$row["hits"]."</td>\n";
	echo "	<td class='TDzahl'>".$row["downloads"]."</td>\n";
	echo "	<td class='TDthema'>$thema</td>\n";
	echo "	<td class='TDbereich'>$fam</td>\n";
	echo "	<td class='TDbereich'>$arb</td>\n";
	echo "	<td class='TDbereich'>$ges</td>\n";
	echo "	<td class='TDbereich'>$erz</td>\n";
	echo "</tr>\n";
	$i++;

}
@mysql_free_result($result);
echo "</table>";
?>



</body>
</html>
