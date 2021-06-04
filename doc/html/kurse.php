<?php	
	require_once($_SERVER['DOCUMENT_ROOT']."/html/php/mysql_header.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type"
content="text/html; charset=utf-8">
<link rel="stylesheet" href="../html/css/browser5.css"
type="text/css">
	<title>Ganglion - Knotenpunkt menschlicher Beziehungen</title>
</head>
<body>
<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/html/php/navbar.php");
?>
<div>&nbsp;</div>
<table>
<tr>
<td ID= "SiteTitel">Ganglion - Kurse und Gruppen</td>
</tr>
<tr>
<td class="TDbold">Folgende Kurse und Gruppen finden statt unter der Leitung von Frau Dr. med. U. Davatz<br>
FMH Psychiatrie und Psychotherapie und Familiensystemtherapie nach Murray Bowen:</td>
</tr>
<tr>
<td class="smalltxt">F&uuml;r eine Anmeldung klicken Sie bitten auf den entsprechenden Kurstitel</td>
	</tr>
</table>
<?php 
$url = $_SERVER["PHP_SELF"];
$valid = array
(
	"Titel"				=>	"titel_kurse",
	"Kursbeginn"	=>	"beginn_kurse",
);
if(isset($_GET["orderby"]) && isset($valid[$_GET["orderby"]]))
{
	$orderby = $valid[$_GET["orderby"]];
}
else
{
	$orderby = "titel_kurse";
}
if(isset($_GET["orderdir"]) && $_GET["orderdir"] == "desc")
{
	$orderdir = "desc";
}
else
{
	$orderdir = "asc";
}
$directions = array
(
	"titel_kurse"						=>	"asc",
	"beginn_kurse"					=>	"asc",
);
if($orderdir == "asc")
{
	$directions[$orderby] = "desc";
}
?>
		<table>
		<tr>
		<td width='100%' class="nohover">Regelm&auml;ssige Kurse:</td>
		<td class="nohover">Kursbeginn:</td>
		</tr>
	<?php
		$query = "SELECT titel_kurse, id_kurse, kurs_art, date_format(beginn_kurse,'%d.%m.%Y')
							as beginn_formatted
							FROM kurse 
							WHERE kurs_art = 'regkurse' 
							ORDER BY ".$orderby." ".$orderdir;
	$kurse_result = mysqli_query($conn1, $query);
	$result = mysqli_query($conn1, $query);
	$values = mysqli_fetch_assoc($result);
	while($values = mysqli_fetch_assoc($kurse_result))
		{		
		echo "<tr>";
		echo "<td>";
		$popurl = "popup_kurse.php?kurs_id=".$values["id_kurse"];
		$script = 'window.open("'.$popurl.'", "popup", "menubar=no,resizable=no,scrollbars=yes,height=650,locationbar=no,toolbar=yes,width=650").focus(); return false';
		echo "<a class='TDbold' href='$popurl' onClick='".$script."'>".stripslashes(urldecode ($values["titel_kurse"]))."</a>";
		echo "<td class='tabltxt-l'>".($values["beginn_formatted"])."</td>";
		echo "</td>";
		echo "</tr>";
		}
?>
<table>
		<tr>
		<td width='100%' class="nohover">Spezielle Kurse:</td>
		<td class="nohover">Kursbeginn:</td>
		</tr>
	<?php
		$query = "SELECT titel_kurse, id_kurse, kurs_art, date_format(beginn_kurse,'%d.%m.%Y')
							as beginn_formatted
							FROM kurse 
							WHERE kurs_art = 'spezkurse' 
							ORDER BY ".$orderby." ".$orderdir;
	$kurse_result = mysqli_query($conn1, $query);
	$result = mysqli_query($conn1, $query);
	$values = mysqli_fetch_assoc($result);
	while($values = mysqli_fetch_assoc($kurse_result))
		{		
		echo "<tr>";
		echo "<td>";
		$popurl = "popup_kurse.php?kurs_id=".$values["id_kurse"];
		$script = 'window.open("'.$popurl.'", "popup", "menubar=no,resizable=no,scrollbars=yes,height=560,locationbar=no,toolbar=yes,width=650").focus(); return false';
		echo "<a class='TDbold' href='$popurl' onClick='".$script."'>".stripslashes(urldecode ($values["titel_kurse"]))."</a>";
		echo "<td class='tabltxt-l'>".($values["beginn_formatted"])."</td>";
		echo "</td>";
		echo "</tr>";
		}
?>
</table>
</table>
	<table>
		<tr>
		<td width="100%" class="nohover">Gruppen:</td>
		<td class="nohover">Kursbeginn:</td>
		</tr>
	<?php
		$query = "SELECT titel_kurse, id_kurse, kurs_art, date_format(beginn_kurse,'%d.%m.%Y')
							as beginn_formatted
							FROM kurse 
							WHERE kurs_art = 'gruppe' 
							ORDER BY ".$orderby." ".$orderdir;
	$kurse_result = mysqli_query($conn1, $query);
	$result = mysqli_query($conn1, $query);
	$values = mysqli_fetch_assoc($result);
	while($values = mysqli_fetch_assoc($kurse_result))
		{		
		echo "<tr>";
		echo "<td>";
		$popurl = "popup_kurse.php?kurs_id=".$values["id_kurse"];
		$script = 'window.open("'.$popurl.'", "popup", "menubar=no,resizable=no,scrollbars=yes,height=560,locationbar=no,toolbar=yes,width=650").focus(); return false';
		echo "<a class='TDbold' href='$popurl' onClick='".$script."'>".stripslashes(urldecode ($values["titel_kurse"]))."</a>";
		echo "<td class='tabltxt-l'>".($values["beginn_formatted"])."</td>";
		echo "</td>";
		echo "</tr>";
		}
?>
</table>
</body>
</html>
