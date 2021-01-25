<?php
if ($change == "true"){
$result = mysql_query ("SELECT * FROM newsletter WHERE id_news ='$id_news'");
	$row = @mysql_fetch_array($result);
		$id_news = $row["id_news"];
		$titel_news = $row["titel_news"];
		$JStitel_news = $row["titel_news"];
		$text_news = $row["text_news"];
		$send_news = datum_ch($row["send_news"]);
		$change_news = datum_ch($row["change_news"]);



	$titel_news = htmlflashde($titel_news);
	$text_news = htmlflashde($text_news);
	$JStitel_news = addslashes($JStitel_news);
	$send_news = deStampDate($row["send_news"]);
	$change_news = deStampDate($row["change_news"]);
@mysql_free_result($result);

$msgConf = "Wollen Sie den Eintrag $titel_news wirklich löschen?";
}

?>
<script type="text/javascript" language="JavaScript" charset="utf-8">
<!--
<?php
echo "var titel = '$msgConf';\n";
?>
//-->
</script>
<form method="post" action="save.php" name="news">
 
  <table class="TABLEvortrag">
	<tr> 
	  <td>Betreff:</td>
	  <td colspan="2"> 
		<input type="text" class="INPUTtext" name="titel_news" size="35" value="<?php print $titel_news; ?>">
	  </td>
	</tr>
	<tr> 
	  <td>Text:</td>
	  <td colspan="2"> 
		<textarea class='INPUTtext' name="text_news" rows="15" wrap="VIRTUAL" cols="36"><?php print $text_news; ?></textarea>
	  </td>
	</tr>
	<?php
if ($change == "true"){
	echo "<tr>\n";
	echo "<td>&nbsp;</td>\n";
	echo "<td colspan='2'>Dieser Eintrag wurde am $change_news zuletzt ge&auml;ndert.</td>\n";
	echo "</tr>\n";
}
?> 

	<tr> 
	  <td><?php 
echo "<input type='hidden' name='page' value='$page'>\n";
echo "<input type='hidden' name='searchold' value='$search'>\n";
echo "<input type='hidden' name='datum_news' value='$datum_news'>\n";
if (isset($new) && $new == "true")
	echo "<input type='hidden' name='new' value='true'>\n";
if (isset($change) && $change == "true"){
	echo "<input type='hidden' name='change' value='true'>\n";
	echo "<input type='hidden' name='id_news' value='$id_news'>\n";
}
?></td>
  <td colspan="2"> <?php SendFormButtons(array("delete")); ?> </td>
	</tr>

  </table>
</form>
<form method="post" action="save.php" name="entrydelete">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="delete" value="true">
<input type="hidden" name="search" value="<?php echo $search ?>">
<input type="hidden" name="id_news" value="<?php echo $id_news?>">
<input type='hidden' name='datum_news' value='<?php print $datum_news ?>'>
</form>
