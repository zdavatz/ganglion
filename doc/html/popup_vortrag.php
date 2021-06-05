<?php	
$_SESSION['user_input'] = @$$user_input;
$_SESSION['missing'] = @$$missing;
	require_once($_SERVER['DOCUMENT_ROOT']."/html/php/mysql_header.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../html/css/popup.css"
type="text/css">
	<title>Vortrag - Info</title>
</head>
<body>
<?php 
$url = $_SERVER["PHP_SELF"];
?>
		<table>
<?php
		$query = "select Titel, thema, id, Zusammenfassung, zeit, Zielpublikum, location, date_format(gehalten,'%d.%m.%Y') 
							as gehalten_formatted 
							from vortrag, thema
							where id_thema=thema_id
							and id=$_GET[id]";
		$vortrag_result = mysqli_query($conn1, $query);
		$result = mysqli_query($conn1, $query);
		$values = mysqli_fetch_assoc($result);
			echo "<table class='borderTABLE'>";
			echo "<tr><td colspan='2' class='TDbold-big'>Ganglion Vortrag Kurzinformationen</td></tr>";
			echo "<tr><td colspan='2' class='TDbold-big'>".stripslashes(trim(urldecode ($values["Titel"])))."</td></tr>";
			echo "<tr><td colspan='2' class='tabltxt-l'>".stripslashes(trim(urldecode ($values["Zusammenfassung"])))."</td></tr>";
			echo "<tr><td colspan='2' class='TDbold'>".stripslashes(trim(urldecode ($values["location"])))."</td></tr>";
			echo "<tr><td class='TDbold'>".stripslashes(trim(urldecode ($values["gehalten_formatted"])))."</td>";
			echo "<td class='TDbold'>".strftime('%H:%M' ,$values["zeit"])."</td></tr>";
			echo "</table>";
			echo "<tr><td>&nbsp;</td></tr>";
			?>
			<br>
<button onClick='javascript:window.print()'>Drucken</button>

</table>
</body>
</html>
