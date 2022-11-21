<?php	
$_SESSION['user_input'] = @$$user_input;
$_SESSION['missing'] = @$$missing;
  require_once($_SERVER['DOCUMENT_ROOT']."/html/php/mysql_header.php");
$id = $_GET["kurs_id"];
if(empty($id) && is_array($user_input)) $id = $user_input['kurs_id']
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../html/css/popup.css"
type="text/css">
	<title>Kurse - Inhalt</title>
</head>
<body>
		<table>
		<tr>
<?php
if(@$missing)
	{
		echo "<td class='missing-email'>Bitte f&uuml;llen Sie alle Felder des Email Formulares aus.</td>";
	}
if($missing = false)
	{
		echo "<td>&nbsp;</td>";
	}
?>
			</tr>
			</table>
<?php 
$url = $_SERVER["PHP_SELF"];
?>
		<table>
<?php
		$query = "	SELECT thema, titel_kurse, id_kurse, teilnehmer_kurse, leitung_kurse,	
								platz_kurse, kosten_kurse, kursziele_kurse, ort_kurse, daten_kurse, date_format(beginn_kurse,'%d.%m.%Y')
								as beginn_formatted
								FROM kurse, thema 
								WHERE id_kurse = '". mysqli_real_escape_string($conn1,$id)."'"; 
		$kurse_result = mysqli_query($conn1, $query);
		$result = mysqli_query($conn1, $query);
  	$values = mysqli_fetch_assoc($result);
		?>
			<table class="bordertable">
			<tr><td class='TDbold-big'>Anmeldung</td></tr>
			<tr>
			<?php echo "<td colspan='2' class='TDbold'>".stripslashes(trim(urldecode ($values["titel_kurse"])))."</td>"; ?>
			</tr>
			<tr><td class='TDbold'>Anmeldeformular<a href="https://forms.gle/q6Da1cFhF5jvQHA89">hier klicken</a></td></tr>
			</table>
			</form>
			<tr><td>&nbsp;</td></tr>
<table class="bordertable">
<tr>
<td class="tabltxt-l"><b>Fragen</b> per Email an <b><a href="mailto:sekretariat@ganglion.ch">sekretariat@ganglion.ch</a></b></td>
	</tr>
</table>
			<tr><td>&nbsp;</td></tr>
			<?php
			echo "<table class='borderTABLE'>";
			echo "<tr>";
			echo "<tr><td colspan='2' class='TDbold-big'>Inhalt der Veranstaltung</td></tr>";
			echo "<td colspan='2' class='TDbold-big'>".stripslashes(trim(urldecode ($values["titel_kurse"])))."</td>";
			echo "<td>&nbsp;</td>";
			echo "</tr>";
			echo "<td colspan='6'>".nl2br(stripslashes(trim(urldecode ($values["kursziele_kurse"]))))."</td>";
			echo "</tr>";
			echo "<tr><td class='tabltxt-l'>Zeit:</td><td>". ($values["platz_kurse"])."</td></tr>";
			echo "<tr><td class='tabltxt-l'>Beginn:</td><td>". ($values["beginn_formatted"])."</td></tr>";
			echo "<tr><td class='tabltxt-l'>Daten:</td><td>".urldecode ($values["daten_kurse"])."</td></tr>";
			echo "<tr><td class='tabltxt-l'>Kosten:</td><td>".urldecode ($values["kosten_kurse"])."</td></tr>";
			echo "<tr><td class='tabltxt-l'>Ort:</td><td>".urldecode ($values["ort_kurse"])."</td></tr>";
			echo "<tr><td class='tabltxt-l'>Leitung:</td><td>".urldecode ($values["leitung_kurse"])."</td></tr>";
			echo "</table>";
			echo "<tr><td>&nbsp;</td></tr>";
			?>

</table>
</body>
</html>
