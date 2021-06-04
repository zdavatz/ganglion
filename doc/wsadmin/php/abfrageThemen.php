$resultLinks = mysqli_query($conn1, "SELECT id_thema, thema, count(B.thema_id) as anzahlLinks FROM thema AS A LEFT OUTER JOIN links AS B ON A.id_thema=B.thema_id GROUP BY id_thema");
$resultVortrag = mysqli_query($conn1, "SELECT id_thema, thema, count(B.thema_id) as anzahlVortrag FROM thema AS A LEFT OUTER JOIN vortrag AS B ON A.id_thema=B.thema_id GROUP BY id_thema");
$resultKurse = mysqli_query($conn1, "SELECT id_thema, thema, count(B.thema_id) as anzahlKurse FROM thema AS A LEFT OUTER JOIN kurse AS B ON A.id_thema=B.thema_id GROUP BY id_thema");

$i=0;
while ($rowLinks = mysqli_fetch_array($resultLinks)){
	$rowVortrag = mysqli_fetch_array($resultVortrag);
	$rowKurse = mysqli_fetch_array($resultKurse);
	$row = array_merge($rowLinks, $rowVortrag, $rowKurse);

    echo "id_thema: ".$row["id_thema"]."<br>\n";
    echo "thema: ".$row["thema"]."<br>\n";
    echo "anzahlLinks: ".$row["anzahlLinks"]."<br>\n";
    echo "anzahlVortrag: ".$row["anzahlVortrag"]."<br>\n";
    echo "anzahlKurse: ".$row["anzahlKurse"]."<br>\n";
	$i++;
}
mysqli_free_result($resultLinks);
mysqli_free_result($resultVortrag);
mysqli_free_result($resultKurse);
