<?php
if ($change == "true"){
$result = mysqli_query($conn1, "SELECT * FROM thema WHERE id_thema ='$id'");
	$row = @mysqli_fetch_array($result);
		$id_thema = $row["id"];
		$Thema = urldecode($row["thema"]);
		$datum = $row["datumchange"];
		$datumchangeold = $row["datumchange"];
@mysqli_free_result($result);
$datum = datum_ch($datum);
$datumchange = date("Y-m-d");
}
elseif ($new == "true") {
$datumchange = date("Y-m-d");
}
?>
<form method="post" action="save.php" name="Thema">
 <table id="id_thema">
  <?php
if ($change == "true"){
	echo "
  <tr> 
		<td>Thema: </td>
		<td colspan='2'> 
			<input class='INPUTtext' type='text' name='Thema' value='$Thema' size='35'>
		</td>
  </tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan='2'>Dieser Eintrag wurde am $datum zuletzt ge&auml;ndert.</td>
	</tr>
	";
	
} else {
	echo "
  <tr> 
		<td>Thema: </td>
		<td colspan='2'> 
			<input class='INPUTtext' type='text' name='Thema' size='35'>
		</td>
  </tr>
	";
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
	echo "<input type='hidden' name='idThema' value='$id'>\n";
}
?> </td>
<td colspan="2"> <?php SendFormButtons(array()); ?> </td>
  </tr>
 </table>
</form>
