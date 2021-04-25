<?php
if ($change == "true"){
$result = mysql_query ("SELECT * FROM artikel WHERE id_artikel ='$id'");
	$row = @mysql_fetch_array($result);
		$id_artikel = $row["id_artikel"];
		$titel_artikel = stripslashes(urldecode($row["titel_artikel"]));
		$javatitel = stripslashes($row["titel_artikel"]);
		$datumold = datum_ch($row["erschienen"]);
		$hits = $row["downloads"];
		$file_name = $row["pdf"];
	  $filecheck = $DOCUMENT_ROOT."/pdf/$file_name";
		$Familie = $row["Familie"];      
		$Arbeit = $row["Arbeit"]; 
		$Gesundheit = $row["Gesundheit"];   
		$Erziehung = $row["Erziehung"];
		$erschienen = $row["erschienen"];
		$Zeitschrift = $row["Zeitschrift"];
//	clearstatcache();
//print_r($datumold);
	$titel_artikel = urldecode($titel_artikel);
	$Zeitschrift = urldecode($Zeitschrift);
	$erschienen = urldecode($erschienen);


$datum_artikel = date("Y-m-d");
$datum = datumsplitt($row["erschienen"]);
$datumend = datumsplitt($row["ende_artikel"]);
@mysql_free_result($result);

$msgConf = "Wollen Sie den Eintrag <$javatitel> wirklich l?schen?";
$msgConf_pdf = "Wollen Sie diese Pdf Datei: <$file_name> wirklich l?schen?";
}
elseif ($new == "true") {
$Vdatum = date("Y-m-d");
$datum = datumsplitt($Vdatum);
$datumend = datumsplitt($Vdatum);
$datum_artikel = date("Y-m-d");
}
?>
<form method="post" action="save.php" name="artikel" enctype="multipart/form-data">
 
<table class="TABLEvortrag">
<tr> 
<td>Thema:</td>
<td colspan="2"> <?php
$theme = "all";
include("getmenu.php"); 
?>
</td>
</tr>
<tr>
<td>Erschienen:</td>
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
<tr> 
<td>Titel:</td>
<td colspan="2"> 
<textarea class="INPUTtext" name="titel_artikel" cols="35" wrap="VIRTUAL" rows="2"><?php print $titel_artikel; ?></textarea>
</td>
<tr> 
<td>Zeitschrift:</td>
<td colspan="2"> 
<input class='INPUTtext' type="text" name="Zeitschrift" value="<?php print $Zeitschrift; ?>" size="35" maxlength="100">
</td>
</tr>
  <tr> 
   <td>pdf - Datei:</td>
   <td colspan="2"> 
	<input class='INPUTtext' type="file" name="file" >
   </td>
  </tr>
  <?php
if ($change == "true"){
	echo "<tr>\n";
	echo "<td>&nbsp;</td>\n";
	if (@filetype($filecheck) == "file")	
	{
		echo "<td>Es existiert eine Pdf Datei: $file_name</td>\n"; 
	} 
	else	
	{ 
		echo "<td>Es existiert keine Pdf Datei</td>"; 
	}
	echo "</tr>\n";
}
?> 
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
echo "<input type='hidden' name='datum_artikel' value='$datum_artikel'>\n";
if (isset($new) && $new == "true")
	echo "<input type='hidden' name='new' value='true'>\n";
if (isset($change) && $change == "true"){
	echo "<input type='hidden' name='change' value='true'>\n";
	echo "<input type='hidden' name='id_artikel' value='$id_artikel'>\n";
	echo "<input type='hidden' name='oldfile' value='$file_name'>\n";
}
?> </td>
  <td colspan="2"> <?php SendFormButtons(array("delete", "delete_pdf")); ?> </td>
</td>
</tr>
</table>
</form>
<form method="post" action="save.php" name="entrydelete" enctype="multipart/form-data">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="delete" value="true">
<input type="hidden" name="search" value="<?php echo $search ?>">
<input type="hidden" name="id_artikel" value="<?php echo $id_artikel?>">
<input type="hidden" name="oldfile" value="<?php echo $file_name ?>">
</form>
<form method="post" action="save.php" name="pdfdelete" enctype="multipart/form-data">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="pdfdelete" value="true">
<input type="hidden" name="search" value="<?php echo $search ?>">
<input type="hidden" name="id_artikel" value="<?php echo $id_artikel?>">
<input type="hidden" name="oldfile" value="<?php echo $file_name ?>">
</form>
