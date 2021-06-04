<?php
if ($change == "true"){
$result = mysqli_query($conn1, "SELECT * FROM kurse WHERE id_kurse ='$id'");
	$row = @mysqli_fetch_array($result);
		$id_kurse = $row["id_kurse"];
		$thema_id = $row["thema_id"];
		$titel_kurse = stripslashes(urldecode($row["titel_kurse"]));
		$JStitel_kurse = $row["titel_kurse"];
		$kurs_art = $row["kurs_art"];
		$kursziele_kurse = stripslashes(urldecode($row["kursziele_kurse"]));
		$koo_kurse = $row["koo_kurse"];
		$kosten_kurse = $row["kosten_kurse"];
		$datumold = datum_ch($row["datum_kurse"]);
		$Familie = $row["Familie"];      
		$Arbeit = $row["Arbeit"]; 
		$Gesundheit = $row["Gesundheit"];   
		$Erziehung = $row["Erziehung"];
		$platz_kurse = $row["platz_kurse"];
		$teilnehmer_kurse = $row["teilnehmer_kurse"]; 
		$leitung_kurse = $row["leitung_kurse"];
		$daten_kurse = $row["daten_kurse"];
		$ort_kurse = $row["ort_kurse"];

	$titel_kurse = urldecode($titel_kurse);
	$kursziele_kurse = urldecode($kursziele_kurse);
	$ort_kurse = urldecode($ort_kurse);
	$kosten_kurse = urldecode($kosten_kurse);
	$leitung_kurse = urldecode($leitung_kurse);
	$daten_kurse = urldecode($daten_kurse);


$datum_kurse = date("Y-m-d");
$datum = datumsplitt($row["beginn_kurse"]);
$datumend = datumsplitt($row["ende_kurse"]);
@mysqli_free_result($result);

$msgConf = "Wollen Sie den Eintrag $javatitel wirklich l?schen?";
}
elseif ($new == "true") {
$Vdatum = date("Y-m-d");
$datum = datumsplitt($Vdatum);
$datumend = datumsplitt($Vdatum);
$datum_kurse = date("Y-m-d");
}
?>
<form method="post" action="save.php" name="vortrag" enctype="multipart/form-data">
 
<table class="TABLEvortrag">
<tr> 
<td>Thema:</td>
<td colspan="2"> <?php
$theme = "all";
include("getmenu.php"); 
?> </td>
</tr>
<tr>
<td>Kurse oder Gruppe</td>
<td colspan="2"> 
<select name="kurs_art">
<?php
	if ($kurs_art == "regkurs")
	{
	echo "<option value='regkurse' selected>regelm&auml;ssige Kurse</option>\n";
	echo "<option value='spezkurse'>spezielle Kurse</option>\n";
	echo "<option value='gruppe'>Gruppe</option>\n";
	}
	else
	{
	echo "<option value='regkurse'>regelm&auml;ssige Kurse</option>\n";
	echo "<option value='spezkurse'>spezielle Kurse</option>\n";
	echo "<option value='gruppe'>Gruppe</option>\n";
	};
?>
</td>
</tr>
</select>
<tr> 
<td>Kursbeginn:</td>
<td colspan="2"> 
<table border="0" cellspacing="0" cellpadding="0">
<tr> 
<td> 
<select name="day" size="1">
<?php
for($i=1; $i <= 31; $i++){
	$select = "";
	if ($i == $datum["d"]) $select = "selected";
	echo "<option value='$i' $select>$i</option>\n";
}
?> 
</select>
</td>
<td> 
<select name="month" size="1">
<?php
for($i=1; $i <= 12; $i++){
$heute = month_array();
$heute = $heute[$i];
	$select = "";
	if ($i == $datum["m"]) $select = "selected";
echo "<option value='$i' $select>$heute</option>\n"; 
}
?> 
</select>
</td>
<td> 
<select name="year" size="1">
<?php
for($i=1980; $i <= 2025; $i++){
	$select = "";
	if ($i == $datum["y"]) $select = "selected";
	echo "<option value='$i' $select>$i</option>\n";
}
?> 
</select>
</td>
</tr>
</table>
</td>
</tr>
<tr> 
<td>Kursende:</td>
<td colspan="2"> 
<table border="0" cellspacing="0" cellpadding="0">
<tr> 
<td> 
<select name="dayend" size="1">
<?php
for($i=1; $i <= 31; $i++){
	$select = "";
	if ($i == $datumend["d"]) $select = "selected";
	echo "<option value='$i' $select>$i</option>\n";
}
?> 
</select>
</td>
<td> 
<select name="monthend" size="1">
<?php
for($i=1; $i <= 12; $i++){
$heute = month_array();
$heute = $heute[$i];
	$select = "";
	if ($i == $datumend["m"]) $select = "selected";
echo "<option value='$i' $select>$heute</option>\n"; 
}
?> 
</select>
</td>
<td> 
<select name="yearend" size="1">
<?php
for($i=1980; $i <= 2025; $i++){
	$select = "";
	if ($i == $datumend["y"]) $select = "selected";
	echo "<option value='$i' $select>$i</option>\n";
}
?> 
</select>
</td>
</tr>
</table>
</td>
</tr>
<tr> 
<td>Titel:</td>
<td colspan="2"> 
<textarea class="INPUTtext" name="titel_kurse" cols="35" wrap="VIRTUAL" rows="2"><?php print $titel_kurse; ?></textarea>
</td>
</tr>
<tr> 
<td>Leitung:</td>
<td colspan="2"> 
<input class='INPUTtext' type="text" name="leitung_kurse" value="<?php print $leitung_kurse; ?>" size="35" maxlength="100">
</td>
</tr>
<tr> 
<td>Kursziele:</td>
<td colspan="2"> 
<textarea class='INPUTtext' name="kursziele_kurse" rows="8" wrap="VIRTUAL" cols="36">
<?php print $kursziele_kurse; ?>
</textarea>
</td>
</tr>
<tr>
<td>Kursdaten:</td>
<td colspan="2">
<textarea class="INPUTtext" name="daten_kurse" cols="36" rows="4" wrap="VIRTUAL"><?php print $daten_kurse; ?></textarea>
</td>
</tr>
<tr> 
<td>Kursort:</td>
<td colspan="2"> 
<input class='INPUTtext' type="text" name="ort_kurse" value="<?php print $ort_kurse; ?>" size="35" maxlength="100">
</td>
</tr>
<tr> 
<td>Pl&auml;tze:</td>
<td colspan="2"> 
<input class='INPUTtext' type="text" name="platz_kurse" size="35" value="<?php print $platz_kurse; ?>">
</td>
</tr>
<tr> 
<td>Teilnehmer:</td>
<td colspan="2"> 
<input class='INPUTtext' type="text" name="teilnehmer_kurse" size="35" value="<?php print $teilnehmer_kurse; ?>">
</td>
</tr>
<tr> 
<td>Kosten:</td>
<td colspan="2"> 
<input class='INPUTtext' type="text" name="kosten_kurse" size="35" value="<?php print $kosten_kurse; ?>">
</td>
</tr>
<tr> 
<td rowspan="2">Bereich:</td>
<td class="TABLEvortrag"> 
<input type="checkbox" value="1" name="Familie" <?php if ($Familie == 1) echo"checked"?>>
Familie </td>
<td class="TABLEvortrag"> 
<input type="checkbox" name="Gesundheit" value="1" <?php if ($Gesundheit == 1) echo"checked"?>>
Gesundheit </td>
</tr>
<tr> 
<td> 
<input type="checkbox" value="1" name="Arbeit" <?php if ($Arbeit == 1) echo"checked"?>>
Arbeit </td>
<td> 
<input type="checkbox" name="Erziehung" value="1" <?php if ($Erziehung == 1) echo"checked"?>>
Erziehung </td>
</tr>
<?php
if ($change == "true"){
	echo "<tr>\n";
	echo "<td>&nbsp;</td>\n";
	echo "<td colspan='2'>Dieser Eintrag wurde am $datumold zuletzt ge&auml;ndert.</td>\n";
	echo "</tr>\n";
}
?> 
<tr> 
<td> <?php 
echo "<input type='hidden' name='page' value='$page'>\n";
echo "<input type='hidden' name='searchold' value='$search'>\n";
echo "<input type='hidden' name='datum_kurse' value='$datum_kurse'>\n";
if (isset($new) && $new == "true")
	echo "<input type='hidden' name='new' value='true'>\n";
if (isset($change) && $change == "true"){
	echo "<input type='hidden' name='change' value='true'>\n";
	echo "<input type='hidden' name='id_kurse' value='$id_kurse'>\n";
}
?> </td>
  <td colspan="2"> <?php SendFormButtons(array("delete")); ?> </td>
</tr>
</table>
</form>
<form method="post" action="save.php" name="entrydelete" enctype="multipart/form-data">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="delete" value="true">
<input type="hidden" name="search" value="<?php echo $search ?>">
<input type="hidden" name="id_kurse" value="<?php echo $id_kurse?>">
<input type='hidden' name='datum_kurse' value='<?php print $datum_kurse ?>'>
</form>
