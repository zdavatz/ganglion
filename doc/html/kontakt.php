<?php	
  $_SESSION['user_input'] = @$$user_input;
  $_SESSION['missing'] = @$$missing;
  require_once($_SERVER['DOCUMENT_ROOT']."/html/php/mysql_header.php");
  $subject = @$user_input["subject"];
	if(empty($subject))
	{
		$subject = "feedback";
	}
	$subjects = array
	(
		"feedback"	=>	"Feedback",
		"counsel"		=>	"Beratungsanfrage",
		"lecture"		=>	"Vortragsanfrage",
		"apply"			=>	"Kursanmeldung",
	);

if(isset($_GET["id"]))
{
		$query =	"select titel_kurse, date_format(beginn_kurse,'%d.%m.%Y') as
						beginn_formatted from kurse
						where id_kurse = ".$_GET["id"];
		$result = mysqli_query($conn1, $query);
  	$values = mysqli_fetch_assoc($result);
		$textvalue = "Anmeldung f&uuml;r den Kurs:\n".urldecode($values["titel_kurse"]);
		$subject = "apply";
}
elseif(isset($user_input["textfield"]))
{
		$textvalue = $user_input["textfield"];
}
else
{
		$textvalue = "";	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" href="../html/css/browser5.css" type="text/css">
		<title>Ganglion - Knotenpunkt menschlicher Beziehungen</title>
	</head>
<body>
<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/html/php/navbar.php");
?>
<br>
<table>
	<tr>
		<td ID= "SiteTitel">Ganglion - Kontakt</td>
	</tr>
</table><br>
<FORM METHOD="POST" ACTION="/html/mail_gesendet.php">
<table class="nopaddingTable">
		<tr>
			<td rowspan="2">
	<table>	
		<tr>
			<tr>
				<td>
				<td class="missing-email">
<?php				
if(@$missing_email)
	{
		echo "&nbsp;Bitte geben Sie eine E-Mail Adresse an!";
	}
if($missing_email = false)
	{
		echo "&nbsp;";
	}
	?>
				</td>
			</td>
		</tr>
		</tr>
			<tr>
				<td>Ihre E-Mail Adresse (wird ben&ouml;tigt)</td>
				<td><INPUT class="med-textinput" TYPE="text" Name="email"></td>
			</tr>
			<tr>
				<td class="TDbold">B&uuml;cher bestellen</td>
			</tr>
			<tr>
				<td class="TDbold">Wie bewahren wir unsere Kinder<br>vor der Drogensucht?</td>
				<td><INPUT class="small-textinput" TYPE="text"	Name="book_bewahren" value="<?php echo @$user_input["book_bewahren"];?>">&nbsp;Anzahl</td>
			</tr>
			<tr>
				<td class="TDbold">Fusion and Differentiation</td>
				<td><INPUT class="small-textinput" TYPE="text" Name="book_fusion"	value="<?php echo @$user_input["book_fusion"];?>">&nbsp;Anzahl</td>
			</tr>
					<tr>
						<td>Anrede</td>
						<td><INPUT TYPE="text" Name="title"value="<?php echo @$user_input["title"];?>"></td>
					</tr>
					<tr>
						<td>Name</td>
						<td><INPUT TYPE="text" Name="name"value="<?php echo	@$user_input["name"];?>"></td>
					</tr>	
					<tr>
						<td>Vorname</td>
						<td><INPUT TYPE="text" Name="firstname"value="<?php echo @$user_input["firstname"];?>"></td>
					</tr>
					<tr>
						<td>Firma</td>
						<td><INPUT TYPE="text" Name="company"value="<?php echo @$user_input["company"];?>"></td>
					</tr>
					<tr>
						<td>Adresse</td>
						<td><INPUT TYPE="text" Name="address"value="<?php echo @$user_input["address"];?>"></td>
					</tr>
					<tr>
						<td>PLZ / Ort</td>
						<td><INPUT TYPE="text" Name="plz_location"value="<?php echo	@$user_input["plz_location"];?>"></td>
					</tr>
					<tr>
						<td>Telefon</td>
						<td><INPUT TYPE="text" Name="phone"value="<?php echo @$user_input["phone"];?>"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
							<INPUT type="submit" value="Email senden">
							<input type="reset" value="Zur&uuml;cksetzen">
						</td>
					</tr>
			</table>
			</td>
		<td>
				<table>
					<tr>
<?php
	$i = 0;
	foreach($subjects as $key => $value)
	{
		echo "<td><INPUT TYPE='radio' Name='subject' Value='".$key."'";
		if($subject == $key)
		{
				echo " Checked";
		}
			echo ">".$value."</td>";
		$i++;
		if($i > 1)
		{
			echo "</tr>\n<tr>";
			$i = 0;
		}
	}
	?>
					</tr>
			<tr>
				<td colspan="3"><TEXTAREA wrap="hard" rows="20" cols="72" class="TEXTAREA" Name="textfield"><?php	echo $textvalue;?></TEXTAREA></td>
			</tr>
		</table>
			</td>
		</tr>
</table>
</form>
</body>
</html>



