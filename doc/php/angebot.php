<?php //angebot.php

if (empty($bereich)) $bereich="Familie";

if (isset($request) && $request == "text"){
	
	$felderIn_text="bereich_text, inhalt_text, datum_text";
	$tabellenIn_ganglion="text";
	$whereBedingungen="bereich_text = '" . mysqli_real_escape_string($conn1,$bereich) . "'";
	$sortierung="datum_text DESC";
	
	$result = mysqli_query($conn1, "SELECT $felderIn_text FROM $tabellenIn_ganglion WHERE $whereBedingungen ORDER BY $sortierung");
	
	$row=mysqli_fetch_array($result);
	
	echo "<p>&text=Frau Dr. med. Ursula Davatz\n\n".stripslashes($row["inhalt_text"])."&</p>\n";
	echo "<p>&eof=true&</p>\n";

}

if (isset($request) && $request == "print"){
	
	$felderIn_text="bereich_text, inhalt_text, datum_text";
	$tabellenIn_ganglion="text";
	$whereBedingungen="bereich_text = '" . mysqli_real_escape_string($conn1,$bereich) . "'";
	$sortierung="datum_text DESC";
	
	$result = mysqli_query($conn1, "SELECT $felderIn_text FROM $tabellenIn_ganglion WHERE $whereBedingungen ORDER BY $sortierung");
	
	$row=mysqli_fetch_array($result);
	if($bereich="Zur Person"){
		$img = "<td><img src='/images/drdavatz.jpg' width='236' height='252' alt='' /></td>";
		$colspan = "colspan='2'";
	} else {
		$img = "";
		$colspan = "";
	}
	
	
	echo "<html>
<head>
<title>Ganglion - Knotenpunkt menschlicher Beziehungen - $bereich</title>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
</head>

<body bgcolor='#FFFFFF'>
<table width='95%' border='0' cellspacing='10'>
  <tr valign='top'> 
    <td $colspan><font face='Arial, Helvetica, sans-serif'>Frau Dr. med. Ursula Davatz</font></td>
  </tr>
  <tr valign='top'> 
    <td $colspan><b><font face='Arial, Helvetica, sans-serif'>$bereich</font></b></td>
  </tr>
  <tr valign='top'> 
    $img<td><font face='Arial, Helvetica, sans-serif'>".nl2br(urldecode(stripslashes($row["inhalt_text"])))."</font></td>
  </tr>
  <tr valign='top'> 
    <td $colspan>&nbsp;</td>
  </tr>
  <tr valign='top'> 
    <td $colspan><font face='Arial, Helvetica, sans-serif'>Ganglion &#151; Knotenpunkt menschlicher Beziehungen</font></td>
  </tr>
  <tr valign='top'> 
    <td $colspan><font face='Arial, Helvetica, sans-serif'>www.ganglion.ch</font></td>
  </tr>
</table>
</body>
</html>
";	

	mysqli_free_result($result);

}

?>

