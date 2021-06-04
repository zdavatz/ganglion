<?php
if ($change == "true"){
$result = mysqli_query($conn1, "SELECT * FROM text WHERE id_text ='$id_text'");
	$row = @mysqli_fetch_array($result);
		$id_text = $row["id_text"];
		$inhalt_text = urldecode($row["inhalt_text"]);
		$bereich_text = urldecode($row["bereich_text"]);
		$datumchangeold = deStampDate($row["datum_text"]);
		

@mysqli_free_result($result);
$msgConf = "Wollen Sie den Eintrag wirklich l?schen?";
}
$datum_text = date("YmdGis");
?>
<form method="post" action="save.php" name="vortrag" enctype="multipart/form-data">
 
<table class="TABLEvortrag">
<tr> 
<td>Bereich:</td>
<td colspan="2"> 
<select name="bereich_text">
<?php
while ($bereich = array_shift($bereich_array)){
		$select = "";
	 	if ($bereich_text == $bereich) $select = "selected";
		echo "<option value='$bereich' $select>$bereich</option>";
}
?> 
</select>
</td>
</tr>
<tr> 
<td>Text:</td>
<td colspan="2"> 
<textarea class='INPUTtext' name="inhalt_text" rows="20" wrap="VIRTUAL" cols="36"><?php print $inhalt_text; ?></textarea>
</td>
</tr>
<?php
if ($change == "true"){
	echo "<tr>\n";
	echo "<td>&nbsp;</td>\n";
	echo "<td colspan='2'>Dieser Eintrag wurde am $datumchangeold zuletzt ge&auml;ndert.</td>\n";
	echo "</tr>\n";
}
?> 
<td> <?php 
echo "<input type='hidden' name='page' value='$page'>\n";
echo "<input type='hidden' name='searchold' value='$search'>\n";
echo "<input type='hidden' name='datum_text' value='$datum_text'>\n";
if (isset($new) && $new == "true")
	echo "<input type='hidden' name='new' value='true'>\n";
if (isset($change) && $change == "true"){
	echo "<input type='hidden' name='change' value='true'>\n";
	echo "<input type='hidden' name='id_text' value='$id_text'>\n";

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
<input type="hidden" name="id_text" value="<?php echo $id_text ?>">
</form>
