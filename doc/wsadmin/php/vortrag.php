<?php
if ($change == "true"){
$result = mysqli_query($conn1, "SELECT * FROM vortrag WHERE id ='" . mysqli_real_escape_string($conn1,$id) . "'");
	$row = @mysqli_fetch_array($result);
		$id_vortrag = $row["id"];
		$datum = $row["gehalten"];
		$Titel = stripslashes(urldecode($row["Titel"]));
		$javatitel = stripslashes(urldecode($row["Titel"]));
		$Zusammenfassung = stripslashes(urldecode($row["Zusammenfassung"]));
		$Zielpublikum = stripslashes(urldecode($row["Zielpublikum"]));
		$time = $row["zeit"];
		$hour = date("H", $time);
		$minute = date("i", $time);
		$location = stripslashes(urldecode($row["location"]));
		$hits = $row["hits"];
		$file_name = $row["pdf"];
		$audiofile_name = $row["audiofile"];
		$audiofile_size = stripslashes(urldecode($row["audiofile_size"]));
		$google_video_url = $row['google_video_url'];
		$google_video_size = $row['google_video_size'];
		$filecheck = $DOCUMENT_ROOT."/pdf/$file_name";
		$audiofilecheck = $DOCUMENT_ROOT."/audio/$audiofile_name";
		$Familie = $row["Familie"];      
		$Arbeit = $row["Arbeit"]; 
		$Gesundheit = $row["Gesundheit"];   
		$Erziehung = $row["Erziehung"];
		$datumchangeold = $row["datumchange"];
		$datumchangeold = datum_ch($datumchangeold);

		
@mysqli_free_result($result);
$datum = datumsplitt($datum);
$datumchange = date("Y-m-d");
$msgConf = "Wollen Sie den Eintrag: <$javatitel> wirklich l?schen?";
$msgConf_pdf = "Wollen Sie diese Pdf Datei: <$file_name> wirklich l?schen?";
list($google_video_hours, $google_video_minutes, $google_video_seconds) = explode(":", $google_video_size); 
}
elseif ($new == "true") {
		$Titel = '';
		$javatitel = '';
		$Zusammenfassung = '';
		$Zielpublikum = '';
		$time = '';
		$location = '';
		$hits = 0;
		$file_name = '';
		$audiofile_name = '';
		$audiofile_size = '';
		$google_video_url = '';
		$google_video_size = '';
		$filecheck = '';
		$audiofilecheck = '';
		$Familie = 0;
		$Arbeit = 0;
		$Gesundheit = 0;
		$Erziehung = 0;
		$google_video_hours = '';
		$google_video_minutes = '';
		$google_video_seconds = '';

$datumchange = date("Y-m-d");
$datum = datumsplitt($datumchange);
$hour = -1;
$minute = -1;
}
?>

<script type="text/javascript" language="JavaScript" charset="utf-8">
function check_form(formId) {
    var form = document.getElementById(formId);
    var title = form.elements['Titel'];
	if (title.value === '') {
        title.style.borderColor = 'red';
        title.style.backgroundColor = 'red';
		alert('Bitte geben Sie einen Titel an.');
		return false;
	}
	var theme = form.elements['searchnew'];
	if (theme.value === '1') {
		alert('Bitte wälen Sie einen Thema an.');
		return false;
	}
}
</script>
<form method="post" id='lectureForm' action="save.php" name="vortrag" onSubmit='return check_form("lectureForm");' enctype="multipart/form-data">

 
<table class="TABLEvortrag">
<tr> 
   <td>Thema: </td>
   
<td colspan="2"> 
<table border="0" cellspacing="0" cellpadding="0">
<tr> 
<td nowrap>Dieser Vortrag zum Thema&nbsp;</td>
<td><?php
$theme = "all";
include("getmenu.php"); 
?></td>
</tr>
</table>
</td>
  </tr>
  <tr> 
   <td>Datum:</td>
   
<td colspan="2" nowrap> 
<table border="0" cellspacing="0" cellpadding="0">
<tr> 
<td>wird/wurde&nbsp;am&nbsp;</td>
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
echo "<option value='$i' $select>$heute</option>"; 
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
<td>
&nbsp;f&uuml;r
</td>
</tr>
</table>

</td>
  </tr>
  <tr> 
   <td>Zielpublikum:</td>
   <td colspan="2"> 
	
<input class='INPUTtextm' type="text" name="Zielpublikum" value='<?php print $Zielpublikum; ?>' size="35" maxlength="100">&nbsp;gehalten.
   </td>
  </tr>
  <tr> 
   <td>Zeit:</td>
   <td colspan="2"> 
<table border="0" cellspacing="0" cellpadding="0">
<tr> 
<td>Die&nbsp;Veranstaltung&nbsp;findet&nbsp;um&nbsp;</td>
<td>
<select name="hour" size="1">
<option value="notime"></option>
<?php
for($i=7; $i <= 22; $i++){
	$select = "";
	if ($i == $hour) $select = "selected";
	echo "<option value='$i' $select>".sprintf("%02d", $i)."</option>\n";
}
?> 
</select>
</td>
<td> 
<select name="minute" size="1">
<option value="notime"></option>
<?php
for($i=0; $i < 60; $i+=15){
	$select = "";
	if ($i == $minute) $select = "selected";
	echo "<option value='$i' $select>".sprintf("%02d", $i)."</option>\n";
}
?> 
</select>
</td>
<td>
&nbsp;Uhr
</td>
</tr>
</table>
   </td>
  </tr>
 <tr> 
   <td>Ort:</td>
   <td colspan="2"> 
	
<input class='INPUTtextm' type="text" name="location" value='<?php print $location; ?>' size="35" maxlength="100">&nbsp;statt.
   </td>
  </tr>
  <tr> 
   <td id='title'>Titel:</td>
   <td colspan="2"> 
	
<input class='INPUTtext' type="text" name="Titel"  value='<?php print $Titel ?>' size="35" maxlength="100">
   </td>
  </tr>
  <tr> 
   <td>Zusammenfassung:</td>
   <td colspan="2"> 
	
<textarea class='INPUTtext' name="Zusammenfassung" rows="10" wrap="VIRTUAL" cols="36"><?php print $Zusammenfassung; ?></textarea>
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
   <td id='title'>Audiofile:</td>
   <td colspan="2"> 
	
<input class='INPUTtext' type="text" name="audiofile_name"  value='<?php print $audiofile_name ?>' size="35" maxlength="100">
   </td>
  </tr>
  <tr> 
   <td id='title'>Audiofile Gr&ouml;sse (in Bytes):</td>
   <td colspan="2"> 
	
<input class='INPUTtext' type="text" name="audiofile_size"  value='<?php print $audiofile_size ?>' size="35" maxlength="100">
   </td>
  </tr>
  <tr> 
   <td id='title'>Google Video-Link:</td>
   <td colspan="2"> 
	
<input class='INPUTtext' type="text" name="google_video_url" value='<?php print $google_video_url ?>' size="35" maxlength="100">
   </td>
  </tr>
  <tr> 
   <td id='title'>Goolge Video Gr&ouml;sse:</td>
   <td colspan="2"> 
<input type="text" name="google_video_hours"  value='<?php print $google_video_hours ?>' size="2" maxlength="2">&nbsp;Stunden&nbsp;
<input type="text" name="google_video_minutes"  value='<?php print $google_video_minutes ?>' size="2" maxlength="2">&nbsp;Minuten&nbsp;
<input type="text" name="google_video_seconds"  value='<?php print $google_video_seconds ?>' size="2" maxlength="2">&nbsp;Sekunden
   </td>
   </td>
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
	echo "<td colspan='2'>Dieser Eintrag wurde am $datumchangeold zuletzt ge&auml;ndert.</td>\n";
	echo "</tr>\n";
}
?> 
  <td> <?php 
echo "<input type='hidden' name='page' value='$page'>\n";
echo "<input type='hidden' name='searchold' value='$search'>\n";
echo "<input type='hidden' name='datumchange' value='$datumchange'>\n";
if (isset($new) && $new == "true")
	echo "<input type='hidden' name='new' value='true'>\n";
if (isset($change) && $change == "true"){
	echo "<input type='hidden' name='change' value='true'>\n";
	echo "<input type='hidden' name='id' value='$id'>\n";
	echo "<input type='hidden' name='oldfile' value='$file_name'>\n";
	echo "<input type='hidden' name='oldaudiofile' value='$audiofile_name'>\n";

}
?> </td>
  <td colspan="2"> <?php SendFormButtons(array("delete", "delete_pdf", "delete_audiofile")); ?> </td>
  </tr>
 </table>
</form>
<form method="post" action="save.php" name="entrydelete" enctype="multipart/form-data">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="delete" value="true">
<input type="hidden" name="search" value="<?php echo $search ?>">
<input type="hidden" name="id" value="<?php echo $id ?>">
<input type="hidden" name="oldfile" value="<?php echo $file_name ?>">
<input type="hidden" name="oldaudiofile" value="<?php echo $audiofile_name ?>">
</form>
<form method="post" action="save.php" name="pdfdelete" enctype="multipart/form-data">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="pdfdelete" value="true">
<input type="hidden" name="search" value="<?php echo $search ?>">
<input type="hidden" name="id" value="<?php echo $id ?>">
<input type="hidden" name="oldfile" value="<?php echo $file_name ?>">
</form>
<form method="post" action="save.php" name="audiofiledelete" enctype="multipart/form-data">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="audiofiledelete" value="true">
<input type="hidden" name="search" value="<?php echo $search ?>">
<input type="hidden" name="id" value="<?php echo $id ?>">
<input type="hidden" name="oldaudiofile" value="<?php echo $audiofile_name ?>">
</form>
