$resultLinks = mysql_query("SELECT id_thema, thema, count(B.thema_id) as anzahlLinks FROM thema AS A LEFT OUTER JOIN links AS B ON A.id_thema=B.thema_id GROUP BY id_thema");
$resultVortrag = mysql_query("SELECT id_thema, thema, count(B.thema_id) as anzahlVortrag FROM thema AS A LEFT OUTER JOIN vortrag AS B ON A.id_thema=B.thema_id GROUP BY id_thema");
$resultKurse = mysql_query("SELECT id_thema, thema, count(B.thema_id) as anzahlKurse FROM thema AS A LEFT OUTER JOIN kurse AS B ON A.id_thema=B.thema_id GROUP BY id_thema");

$i=0;
while ($rowLinks = mysql_fetch_array($resultLinks)){
	$rowVortrag = mysql_fetch_array($resultVortrag);
	$rowKurse = mysql_fetch_array($resultKurse);
	$row = array_merge($rowLinks, $rowVortrag, $rowKurse);

    echo "id_thema: ".$row["id_thema"]."<br>\n";
    echo "thema: ".$row["thema"]."<br>\n";
    echo "anzahlLinks: ".$row["anzahlLinks"]."<br>\n";
    echo "anzahlVortrag: ".$row["anzahlVortrag"]."<br>\n";
    echo "anzahlKurse: ".$row["anzahlKurse"]."<br>\n";
	$i++;
}
mysql_free_result($resultLinks);
mysql_free_result($resultVortrag);
mysql_free_result($resultKurse);
