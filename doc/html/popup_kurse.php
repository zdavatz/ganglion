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
			<tr><td class='TDbold-big'>Ganglion Anmeldung</td></tr>
			<tr>
			<?php echo "<td colspan='2' class='TDbold'>".stripslashes(trim(urldecode ($values["titel_kurse"])))."</td>"; ?>
			</tr>
			<tr><td class='TDbold'>Adresse Kursteilnehmer</td></tr>
			<FORM METHOD="POST" ACTION="/html/popup_gesendet.php">
<input type="hidden" name="subject" value="Anmeldung: <?php echo stripslashes(urldecode ($values["titel_kurse"]));?>">
<input type="hidden" name="kurs_id" value="<?php echo $id;?>">
			
			</tr>
					<tr>
						<td>Anrede</td>
						<td><INPUT TYPE="text" Name="title" size="50" value="<?php echo @$user_input["title"];?>"></td>
					</tr>
					<tr>
						<td>Name</td>
						<td><INPUT TYPE="text" Name="name" size="50" value="<?php echo	@$user_input["name"];?>"></td>
					</tr>	
					<tr>
						<td>Vorname</td>
						<td><INPUT TYPE="text" Name="firstname" size="50" value="<?php echo @$user_input["firstname"];?>"></td>
					</tr>
					<tr>
						<td>Firma</td>
						<td><INPUT TYPE="text" Name="company" size="50" value="<?php echo @$user_input["company"];?>"></td>
					</tr>
					<tr>
						<td>Adresse</td>
						<td><INPUT TYPE="text" Name="address" size="50" value="<?php echo @$user_input["address"];?>"></td>
					</tr>
					<tr>
						<td>PLZ / Ort</td>
						<td><INPUT TYPE="text" Name="plz_location" size="50" value="<?php echo	@$user_input["plz_location"];?>"></td>
					</tr>
					<tr>
						<td>Telefon Privat</td>
						<td><INPUT TYPE="text" Name="phone_privat" size="50" value="<?php echo @$user_input["phone_privat"];?>"></td>
					</tr>
					<tr>
						<td>Telefon Gesch&auml;ft</td>
						<td><INPUT TYPE="text" Name="phone_geschaeft" size="50" value="<?php echo @$user_input["phone_geschaeft"];?>"></td>
					</tr>
					<tr>
						<td>Telefon Mobile</td>
						<td><INPUT TYPE="text" Name="phone_mobile" size="50" value="<?php echo @$user_input["phone_mobile"];?>"></td>
					</tr>
					<tr>
					<tr>
						<td>Email-Adresse</td>
						<td><INPUT TYPE="text" Name="email" size="50"  value="<?php echo @$user_input["email"];?>"></td>
					</tr>
						<tr>
						<td><b>Anmeldung</b> per <b>Email</b></td>
						<td>
							<INPUT type="submit" value="Abschicken">
							<input type="reset" value="Zur&uuml;cksetzen">
						</td>
					</tr>
			</table>
			</form>
			<tr><td>&nbsp;</td></tr>
<table class="bordertable">
<tr>
<td class="tabltxt-l"><b>Anmeldung</b> per Email an <b>sekretariat@ganglion.ch</b></td>
<td align="left">
<button onClick='javascript:window.print()'>Drucken</button>
</td>
	</tr>
</table>
			<tr><td>&nbsp;</td></tr>
			<?php
			echo "<table class='borderTABLE'>";
			echo "<tr>";
			echo "<tr><td colspan='2' class='TDbold-big'>Ganglion Kursinhalt</td></tr>";
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
