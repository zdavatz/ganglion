<?php
if ($change == "true"){
$result = mysql_query ("SELECT * FROM profil WHERE id_profil = '$id'");
	$row = @mysql_fetch_array($result);
		$id_profil = $row["id_profil"];
		$login = $row["login"];
		$JSlogin = addslashes($row["login"]);
		$passwort = $row["pass"];
		$email = $row["email"];
		$url = $row["url"];
		$publikationen = $row["publikationen"];
		$fachgebiet = $row["fachgebiet"];
		$biographie = $row["biographie"];
		$signatur = $row["signatur"];
		
		
	$publikationen = urldecode($publikationen);
	$fachgebiet = urldecode($fachgebiet);
	$biographie = urldecode($biographie);
	$signatur = urldecode($signatur);
		
	
$row["notification"] == 1 	? $notification="checked" 	: $notification="";
$row["newsletter"] == 1 	? $newsletter="checked" 	: $newsletter="";
	
@mysql_free_result($result);

$msgConf = "Wollen Sie den Benutzer $JSlogin wirklich l?schen?";
}
?>
<form method="post" action="save.php" name="vortrag" enctype="multipart/form-data">
 
<table class="TABLEvortrag">
<tr> 
<td>Login:</td>
<td> 
<input class='INPUTtext' type="text" name="login" value="<?php print $login; ?>" size="10">
</td>
</tr>
<tr> 
<td>passwort:</td>
<td> 
<input class='INPUTtext' type="password" name="passwort" value="<?php print $passwort; ?>" size="10">
</td>
</tr>
<tr> 
<td>Email:</td>
<td> 
<input class='INPUTtext' type="text" name="email" value='<?php print $email; ?>' size="35">
</td>
</tr>
<tr> 
<td>Url:</td>
<td> 
<input class='INPUTtext' type="text" name="urlprofil"value='<?php print $url; ?>' size="35">
</td>
</tr>
<tr> 
<td>Publikationen:</td>
<td> 
<textarea class='INPUTtext' name="publikationen" rows="4" wrap="VIRTUAL" cols="36"><?php print $publikationen; ?></textarea>
</td>
</tr>
<tr> 
<td>Fachgebiet:</td>
<td> 
<textarea name="fachgebiet" rows="2" wrap="VIRTUAL" cols="36"><?php print $fachgebiet; ?></textarea>
</td>
</tr>
<tr> 
<td>Biographie:</td>
<td>
<textarea name="biographie" rows="4" wrap="VIRTUAL" cols="36"><?php print $biographie; ?></textarea>
</td>
</tr>
<tr>
<td>Signatur:</td>
<td>
<textarea name="signatur" rows="2" wrap="VIRTUAL" cols="36"><?php print $signatur; ?></textarea>
</td>
</tr>
<tr> 
<td>Benachrichtigung :</td>
<td>
<input type="checkbox" name="notifikation" value="1" <?php print $notification; ?>>
</td>
</tr>
<tr> 
<td>Newsletter:</td>
<td>
<input type="checkbox" name="newsletter" value="1" <?php print $newsletter; ?>>
</td>
</tr>
<tr>
<td> <?php 
echo "<input type='hidden' name='page' value='$page'>\n";
echo "<input type='hidden' name='searchold' value='$search'>\n";
if (isset($new) && $new == "true")
	echo "<input type='hidden' name='new' value='true'>\n";
if (isset($change) && $change == "true"){
	echo "<input type='hidden' name='change' value='true'>\n";
	echo "<input type='hidden' name='id_profil' value='$id_profil'>\n";
}
?> </td>
<td> 
<?php
if ($change == "true" && $del != "ok") $change = "false";
SendFormButtons(array("delete")); ?> </td>
</tr>
</table>
</form>
<form method="post" action="save.php" name="entrydelete" enctype="multipart/form-data">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="delete" value="true">
<input type="hidden" name="search" value="<?php echo $search ?>">
<input type="hidden" name="id_profil" value="<?php echo $id_profil ?>">
</form>
