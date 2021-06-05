<?php
if ($change == "true"){
$result = mysqli_query($conn1, "SELECT * FROM links WHERE id_links ='$id'");
	$row = @mysqli_fetch_array($result);
		$id_vortrag = $row["id_links"];
		$datum = $row["datum"];
		$beschreibung = $row["text"];
		$url = urldecode($row["url"]);
		$Familie = $row["Familie"];      
		$Arbeit = $row["Arbeit"]; 
		$Gesundheit = $row["Gesundheit"];   
		$Erziehung = $row["Erziehung"];
		$datumchangeold = $row["datumchange"];
		$datumchangeold = datum_ch($datumchangeold);


	
	$beschreibung = urldecode($beschreibung);
	$javatitel = addslashes($url);
	
	
@mysqli_free_result($result);
$datum = datum_ch($datum);
$datumchange = date("Y-m-d");
$msgConf = "Wollen Sie den Eintrag $javatitel wirklich l?schen?";
}
elseif ($new == "true") {
$datumchange = date("Y-m-d");
}
?>
<form method="post" action="save.php" name="vortrag">
 <table id="vortrag">
  <tr> 
   <td>Thema: </td>
   <td colspan="2"> <?php
$theme = "all";
include("getmenu.php"); 
?> </td>
  </tr>
  <tr> 
   <td>Url:</td>
   <td colspan="2"> 
	
<input class='INPUTtext' type="text" name="url" value='<?php print $url; ?>' size="35">
   </td>
  </tr>
  <tr> 
   <td>Beschreibung:</td>
   <td colspan="2"> 
	
<textarea class='INPUTtext' name="beschreibung" rows="10" wrap="VIRTUAL" cols="36"><?php print $beschreibung; ?></textarea>
   </td>
  </tr>
  <tr> 
   <td rowspan="4">Bereich:</td>
   <td> 
	<input type="checkbox" value="1" name="Familie" <?php if ($Familie == 1) echo"checked"?>>
	Familie </td>
   <td> 
	<input type="checkbox" name="Gesundheit" value="1" <?php if ($Gesundheit == 1) echo"checked"?>>
	Gesundheit </td>
  </tr>
  <tr> 
   <td rowspan="3"> 
	<input type="checkbox" value="1" name="Arbeit" <?php if ($Arbeit == 1) echo"checked"?>>
	Arbeit </td>
   <td rowspan="3"> 
	<input type="checkbox" name="Erziehung" value="1" <?php if ($Erziehung == 1) echo"checked"?>>
	Erziehung </td>
  </tr>
  <tr> 
  <tr></tr>
  <?php
if ($change == "true"){
	echo "<tr>\n";
	echo "<td>&nbsp;</td>\n";
	echo "<td colspan='2'>Dieser Eintrag wurde am $datum zuletzt ge&auml;ndert.</td>\n";
	echo "</tr>\n";
}
?> 
  <td> <?php 
echo "<input type='hidden' name='page' value='$page'>\n";
echo "<input type='hidden' name='searchold' value='$search'>\n";
echo "<input type='hidden' name='datum' value='$datumchange'>\n";
if (isset($new) && $new == "true")
	echo "<input type='hidden' name='new' value='true'>\n";
if (isset($change) && $change == "true"){
	echo "<input type='hidden' name='change' value='true'>\n";
	echo "<input type='hidden' name='id' value='$id'>\n";
}
?> </td>
  <td colspan="2"> <?php SendFormButtons(array("delete")); ?> </td>
  </tr>
 </table>
</form>
<form method="post" action="save.php" name="entrydelete">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="delete" value="true">
<input type="hidden" name="search" value="<?php echo $search ?>">
<input type="hidden" name="id" value="<?php echo $id ?>">
</form>
