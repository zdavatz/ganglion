<?php
if ($change == "true"){
	
	$felder = "A.*, B.id_profil, B.login";

	$result = mysql_query ("SELECT * FROM forum_thread AS A, profil AS B, forum_inhalt AS C WHERE A.profil_id_thread=B.id_profil  AND A.profil_id_thread=C.profil_id AND id_thread='$id' ORDER BY C.datum ASC");

//Mysql - Abfrage
//SELECT thread_id, profil_id, titel, text, datum, id_profil, login, email, url, signatur, Arbeit,Erziehung,Gesundheit,Familie,profil_id_thread FROM forum_inhalt AS A, profil AS B, forum_thread AS C WHERE A.thread_id=5 AND A.profil_id=B.id_profil AND A.thread_id=C.id_thread

	$row = @mysql_fetch_array($result);
		$id_thread = $row["id_thread"];
		$id_profil = $row["id_profil"];
		$datum = $row["datum_thread"];
		$first_text = urldecode($row["text"]);
		$titel_thread = urldecode($row["titel_thread"]);
		$JStitel_thread = urldecode($row["titel_thread"]);
		$author = urldecode($row["login"]);
		$email = $row["email"];
		$Familie = $row["Familie"];
		$Arbeit = $row["Arbeit"]; 
		$Gesundheit = $row["Gesundheit"]; 
		$Erziehung = $row["Erziehung"];

$url_profil = "$PHP_SELF?page=profil&search=$search&change=true&id=$id_profil";

@mysql_free_result($result);
$datum = deStampDate($datum);

$msgConf = "Wollen Sie die Diskussion: $JStitel_thread wirklich löschen?";

$datumchange = date("Y-m-d");
}

?>
<script type="text/javascript" language="JavaScript" charset="utf-8">
<!--
<?php
echo "var titel = '$msgConf';\n";
?>
//-->
</script>
<form method="post" action="save.php" name="vortrag" enctype="multipart/form-data">
<table id="vortrag">
<tr> 
<td>Thema:</td>
<td colspan="2"><?php
$theme = "all";
include("getmenu.php");
?> </td>
</tr>
<tr> 
<td>Diskussion:</td>
<td colspan="2"> <?php print $titel_thread; ?> </td>
</tr>
<tr>
<td>Author:</td>
<td colspan="2"><?php echo"<a href='$url_profil'>".$author."</a>"; ?></td>
</tr>
<tr> 
<td>Email:</td>
<td colspan="2"><?php echo"<a href='mailto: $email'>".$email."</a>"; ?></td>
</tr>
<tr> 
<td>Text:</td>
<td colspan="2"><?php print $first_text; ?></td>
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

<td> <?php 
echo "<input type='hidden' name='page' value='$page'>\n";
echo "<input type='hidden' name='searchold' value='$search'>\n";
echo "<input type='hidden' name='datumchange' value='$datumchange'>\n";
if (isset($new) && $new == "true")
	echo "<input type='hidden' name='new' value='true'>\n";
if (isset($change) && $change == "true"){
	echo "<input type='hidden' name='change' value='true'>\n";
	echo "<input type='hidden' name='id_thread' value='$id_thread'>\n";
}
?> </td>
  <td colspan="2"> <?php SendFormButtons(array("delete", "delete_pdf")); ?> </td>
</tr>
</table>
</form>
<form method="post" action="save.php" name="entrydelete" enctype="multipart/form-data">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="delete" value="true">
<input type="hidden" name="comment" value="complete">
<input type="hidden" name="search" value="<?php echo $search ?>">
<input type="hidden" name="id_thread" value="<?php echo $id_thread ?>">
</form>
