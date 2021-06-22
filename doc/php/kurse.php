<?php //kurse.php

//set session variables
session_register("kurse_array");
session_register("php_kurse_pointer");
session_register("php_kurse_id");
session_register("php_kurse_search");
session_register("php_kurse_sortierung");
session_register("php_kurse_zeitfenster");


if (isset($request) && ($request == "uebersicht" || $request == "zeitfenster")){
	
	//check in which Bereich there are entries to be displayed...
	$query = "SELECT MAX(Familie) AS f, MAX(Arbeit) AS a, MAX(Gesundheit) AS g, MAX(Erziehung) AS e FROM kurse";
	$result = mysqli_query($conn1, $query);
	list ($Familie, $Arbeit, $Gesundheit, $Erziehung) = mysqli_fetch_row($result);
	mysqli_free_result($result);
	echo "<p>&kurseFamilie=$Familie&</p>\n";
	echo "<p>&kurseArbeit=$Arbeit&</p>\n";
	echo "<p>&kurseGesundheit=$Gesundheit&</p>\n";
	echo "<p>&kurseErziehung=$Erziehung&</p>\n";
	$kurseSumme=$Familie+$Arbeit+$Gesundheit+$Erziehung-$$bereich;
	echo "<p>&kurseSumme=$kurseSumme&</p>\n";

	//keep vars or replace
	if($bereich == "Nächste Kurse") $zeitfenster = "future";
	if (!isset($search)) 	$search 	= (empty($php_kurse_search) ? "all" : $php_kurse_search);
	if (!isset($sortierung))	$sortierung = (empty($php_kurse_sortierung) ? "beginn_kurse DESC" : $php_kurse_sortierung);
	if (!isset($zeitfenster)) $zeitfenster = (empty($php_kurse_zeitfenster) ? "default" : $php_kurse_zeitfenster);
	
	//remember variables for next run
	$php_kurse_search=$search;
	$php_kurse_sortierung=trim($sortierung);
	$php_kurse_zeitfenster=$zeitfenster;

	$array_bereiche = array("Arbeit", "Gesundheit", "Familie", "Erziehung");
	if(!in_array( $bereich, $array_bereiche) ) $bereich=implode(",", $array_bereiche); 
	unset($kurse_array);

	$felderIn_kurse = "id_kurse,titel_kurse,$bereich,thema_id,beginn_kurse,ende_kurse,platz_kurse,teilnehmer_kurse";
	$felderIn_thema = "id_thema, thema";
	$tabellenIn_ganglion = "kurse AS A, thema AS B";
	$whereBedingungen = "B.id_thema = A.thema_id AND 1 IN ($bereich)";
	$precision = ($search=="all" ? "" : "A.thema_id='" . mysqli_real_escape_string($conn1,$search) . "' AND");
	switch($zeitfenster) {
		case "default"	: 
		case "all"		:	$epoche = "";
							break;
		case "past"		: 	$epoche = "AND ende_kurse < NOW() ";
							break;
		case "present"	:	$epoche = "AND NOW() BETWEEN beginn_kurse AND ende_kurse ";
							break;
		case "future"	: 	$epoche = "AND beginn_kurse > NOW() ";
							break;
		default			: 	$epoche = "";
	}

	$result = mysqli_query($conn1, "SELECT $felderIn_kurse, $felderIn_thema FROM $tabellenIn_ganglion WHERE $precision $whereBedingungen $epoche ORDER BY $sortierung");
	
	if ($zeitfenster == "default" && mysqli_num_rows($result) == 0) {
		$epoche = "AND TO_DAYS(beginn_kurse) > TO_DAYS(NOW())";
		mysqli_free_result($result);
		$result = mysqli_query($conn1, "SELECT $felderIn_kurse, $felderIn_thema FROM $tabellenIn_ganglion WHERE $precision $whereBedingungen $epoche ORDER BY $sortierung");
		if (mysqli_num_rows($result) == 0) {
			mysqli_free_result($result);
			$result = mysqli_query($conn1, "SELECT $felderIn_kurse, $felderIn_thema FROM $tabellenIn_ganglion WHERE $precision $whereBedingungen ORDER BY $sortierung");
		}
	}

	$i=0;

	while($row = mysqli_fetch_array($result)){
		$kurse_array[]=$row["id_kurse"];
		if ($request == "uebersicht"){		
			echo"<p>&id$i=".$row["id_kurse"]."&</p>\n";
			echo"<p>&Titel$i=".stripslashes($row["titel_kurse"])."&</p>\n";
			echo"<p>&thema$i=".stripslashes($row["thema"])."&</p>\n";
			echo"<p>&Kursbeginn$i=".datum_ch($row["beginn_kurse"])."&</p>\n";
			echo"<p>&Kursende$i=".$row["ende_kurse"]."&</p>\n";
			echo"<p>&Plaetze$i=".$row["platz_kurse"]."&</p>\n";
			echo"<p>&Teilnehmer$i=".$row["teilnehmer_kurse"]."&</p>\n";
		}

		$i++;
	}
		
	echo "<p>&php_sortby=".trim(strtok($sortierung, " "))."&</p>\n";
	echo "<p>&php_richtung=".trim(strstr($sortierung, " "))."&</p>\n";
	echo"<p>&anzahl=$i&</p>\n";
	echo"<p>&eof=true&</p>\n";

	mysqli_free_result($result);

}

if (isset($request) && $request=="keepPointer"){
	$php_kurse_pointer=$pointer;
	unset ($php_kurse_id);
	echo "<p>&eof=true&</p>\n";	
}
if (isset($request) && $request=="keepID"){
	$php_kurse_id=$id;
	unset($kurse_array);
	echo "<p>&eof=true&</p>\n";	
}

if (isset($request) && $request == "directThread"){

	//check in which Bereich there are entries to be displayed...
	$query = "SELECT MAX(Familie) AS f, MAX(Arbeit) AS a, MAX(Gesundheit) AS g, MAX(Erziehung) AS e FROM kurse";
	$result = mysqli_query($conn1, $query);
	list ($Familie, $Arbeit, $Gesundheit, $Erziehung) = mysqli_fetch_row($result);
	mysqli_free_result($result);
	echo "<p>&kurseFamilie=$Familie&</p>\n";
	echo "<p>&kurseArbeit=$Arbeit&</p>\n";
	echo "<p>&kurseGesundheit=$Gesundheit&</p>\n";
	echo "<p>&kurseErziehung=$Erziehung&</p>\n";
	$kurseSumme=$Familie+$Arbeit+$Gesundheit+$Erziehung-$$bereich;
	echo "<p>&kurseSumme=$kurseSumme&</p>\n";

	if (sizeof($kurse_array) == 0){
	//echo "kein kurse_array gefunden<br>";
		$query="SELECT id_kurse, $bereich FROM kurse WHERE $bereich=1 ORDER BY beginn_kurse DESC";
		$result = mysqli_query($conn1, $query);
		while ($row = mysqli_fetch_array($result)){
			$kurse_array[]=$row["id_kurse"];
		}
	}
	if (isset ($pointer)){
	//echo "es gibt frische Pointer<br>";
		$php_kurse_pointer=$pointer;
		unset($php_kurse_id);
		unset($php_desired_id);
	} elseif (isset ($php_desired_id)){
	//echo "es gibt frische ID<br>";
		$php_kurse_id=$php_desired_id;
		unset($php_kurse_pointer);
	}
	if (isset($php_kurse_id) && in_array($php_kurse_id, $kurse_array)){
	//echo "id wurde gleich mitgeliefert<br>";
		$php_kurse_pointer=getPointer($kurse_array, $php_kurse_id);
	}  elseif (isset($php_kurse_pointer)){
	//echo "wir sind in der pointer-schleife<br>";
		$php_kurse_id=$kurse_array[$php_kurse_pointer];
	//echo "-- resultierende id = $id<br>";
	} else {
	//echo "setzen wir doch alles NULL...<br>";
		$php_kurse_pointer=0;
		$php_kurse_id=$kurse_array[0];
	}

	$felderIn_kurse = "id_kurse,titel_kurse,beginn_kurse,kursziele_kurse,kosten_kurse,thema_id, daten_kurse, ort_kurse, leitung_kurse, platz_kurse,teilnehmer_kurse";
	$felderIn_thema = "id_thema, thema";
	$tabellenIn_ganglion = "kurse AS A, thema AS B";
	$whereBedingungen = "A.id_kurse = '" . mysqli_real_escape_string($conn1,$php_kurse_id) . "' AND A.thema_id = B.id_thema";
	
	$result = mysqli_query($conn1, "SELECT $felderIn_kurse, $felderIn_thema FROM $tabellenIn_ganglion WHERE $whereBedingungen");
	
	$row = mysqli_fetch_array($result);
	
	$kursbeginn=$row["beginn_kurse"];
	$heute =  date("Y-m-d");
	
	echo "<p>&Kurs_id=".$row["id_kurse"]."&</p>\n";
	echo "<p>&Titel=".stripslashes($row["titel_kurse"])."&</p>\n";
	echo "<p>&Daten=".stripslashes($row["daten_kurse"])."&</p>\n";
	echo "<p>&Kursziele=".stripslashes($row["kursziele_kurse"])."&</p>\n";
	echo "<p>&Kurskosten=".stripslashes($row["kosten_kurse"])."&</p>\n";
	echo "<p>&Thema=".stripslashes($row["thema"])."&</p>\n";
	echo "<p>&Plaetze=".$row["platz_kurse"]."&</p>\n";
	echo "<p>&Teilnehmer=".$row["teilnehmer_kurse"]."&</p>\n";
	echo "<p>&Kursort=".stripslashes($row["ort_kurse"])."&</p>\n";
	echo "<p>&Kursleitung=".stripslashes($row["leitung_kurse"])."&</p>\n";
	echo "<p>&Anmelden=".($kursbeginn > $heute ? 1 : 0)."&</p>\n";
	echo "<p>&pointer=$php_kurse_pointer&</p>\n";
	echo "<p>&anzahl=".sizeof($kurse_array)."&</p>\n";
	
	echo "<p>&eof=true&</p>\n";

	mysqli_free_result($result);
}

if (isset($request) && $request == "print"){
	$felderIn_kurse = "id_kurse,titel_kurse,kursziele_kurse,kosten_kurse,thema_id, daten_kurse, ort_kurse, leitung_kurse, platz_kurse,teilnehmer_kurse";
	$felderIn_thema = "id_thema, thema";
	$tabellenIn_ganglion = "kurse AS A, thema AS B";
	$whereBedingungen = "A.id_kurse = '" . mysqli_real_escape_string($conn1,$id) . "' AND A.thema_id = B.id_thema";
	
	$result = mysqli_query($conn1, "SELECT $felderIn_kurse, $felderIn_thema FROM $tabellenIn_ganglion WHERE $whereBedingungen");
	
	$row = mysqli_fetch_array($result);
	
	echo "<html>
<head>
<title>".stripslashes($row["titel_kurse"])."</title>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
</head>

<body bgcolor='#FFFFFF'>
<table width='760' border='0' cellspacing='10'>
  <tr valign='top'> 
    <td colspan='2'><font face='Arial, Helvetica, sans-serif' size='4'>".urldecode(stripslashes($row["titel_kurse"]))."</font></td>
  </tr>
  <tr> 
    <td colspan='2'>&nbsp;</td>
  </tr>
  <tr valign='top'> 
    <td width='150'><b><font face='Arial, Helvetica, sans-serif'>Thema:</font></b></td>
    <td width='600'><font face='Arial, Helvetica, sans-serif'>".nl2br(urldecode(stripslashes($row["thema"])))."</font></td>
  </tr>
  <tr valign='top'> 
    <td width='150'><b><font face='Arial, Helvetica, sans-serif'>Kursleitung:</font></b></td>
    <td width='600'><font face='Arial, Helvetica, sans-serif'>".nl2br(urldecode(stripslashes($row["leitung_kurse"])))."</font></td>
  </tr>
  <tr valign='top'> 
    <td width='150'><b><font face='Arial, Helvetica, sans-serif'>Kursort:</font></b></td>
    <td width='600'><font face='Arial, Helvetica, sans-serif'>".nl2br(urldecode(stripslashes($row["ort_kurse"])))."</font></td>
  </tr>
  <tr valign='top'> 
    <td width='150'><b><font face='Arial, Helvetica, sans-serif'>Daten:</font></b></td>
    <td width='600'><font face='Arial, Helvetica, sans-serif'>".nl2br(urldecode(stripslashes($row["daten_kurse"])))."</font></td>
  </tr>
  <tr valign='top'> 
    <td width='150'><b><font face='Arial, Helvetica, sans-serif'>Ziele:</font></b></td>
    <td width='600'><font face='Arial, Helvetica, sans-serif'>".nl2br(urldecode(stripslashes($row["kursziele_kurse"])))."</font></td>
  </tr>
  <tr valign='top'> 
    <td width='150'><b><font face='Arial, Helvetica, sans-serif'>Kosten:</font></b></td>
    <td width='600'><font face='Arial, Helvetica, sans-serif'>".nl2br(urldecode(stripslashes($row["kosten_kurse"])))."</font></td>
  </tr>
  <tr valign='top'> 
    <td colspan='2'>&nbsp;</td>
  </tr>
  <tr valign='top'> 
    <td valign='top' colspan='2'><font face='Arial, Helvetica, sans-serif'>Ganglion &#151; Knotenpunkt menschlicher Beziehungen</font></td>
  </tr>
  <trvalign='top'> 
    <td colspan='2'><font face='Arial, Helvetica, sans-serif'>www.ganglion.ch</font></td>
  </tr>
</table>
</body>
</html>
";	

	mysqli_free_result($result);

}

?>

