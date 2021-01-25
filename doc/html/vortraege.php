<?php 
	require_once($_SERVER['DOCUMENT_ROOT']."/html/php/mysql_header.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>									
	<meta http-equiv="Content-Type"
 content="text/html; charset=utf-8">
	<link rel="stylesheet" href="../html/css/browser5.css"
 type="text/css">
	<title>Ganglion - Knotenpunkt menschlicher Beziehungen</title>
</head>
<body>
<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/html/php/navbar.php");
?>
<div class="tabltxt-dl">
<a id='podcast' href='/html/podcast.php'><img src='/images/pod.gif' /> Abonnieren Sie die Vortr&auml;ge als Podcast</a><br>
Downloads Vortr&auml;ge:&nbsp;
<?php
	($result = mysql_query("select sum(downloads) as sumd from vortrag"));
 	$values = mysql_fetch_array($result);
	$total_downloads = $values['sumd'];
	echo number_format($total_downloads,0,".","'");
?>
&nbsp;(als PDF)&nbsp;
<?php
	($result = mysql_query("select sum(audiofile_downloads) as audiosumd from vortrag"));
 	$values = mysql_fetch_array($result);
	$total_audio_downloads = $values['audiosumd'];
	echo number_format($total_audio_downloads,0,".","'");
?>
&nbsp;(als Audio-File)&nbsp;
<?php
	($result = mysql_query("select sum(google_video_downloads) as googlevideosumd from vortrag"));
 	$values = mysql_fetch_array($result);
	$total_audio_downloads = $values['googlevideosumd'];
	echo number_format($total_audio_downloads,0,".","'");
?>
&nbsp;(als Video-File)
</div>
<table>
<?php 
$url = $_SERVER["PHP_SELF"];
$valid = array
(
"Titel"			=>	"Titel",
"Thema"			=>	"thema",
"Gelesen"		=>	"hits",
"Downloads"	=>	"downloads",
"AudioFileDownloads"	=>	"audiofile_downloads",
"Gehalten"	=>	"gehalten",
);
if(isset($_GET["orderby"]) && isset($valid[$_GET["orderby"]]))
{
$orderby = $valid[$_GET["orderby"]];
}
else
{
$orderby = "Gehalten";
}
if(isset($_GET["orderdir"]) && $_GET["orderdir"] == "asc")
{
$orderdir = "asc";
}
else
{
$orderdir = "desc";
}
$directions = array
(
"Titel"			=>	"asc",
"thema"			=>	"asc",
"hits"			=>	"asc",
"downloads"	=>	"asc",
"gehalten"	=>	"asc",
);
if($orderdir == "asc")
{
$directions[$orderby] = "desc";
}
?>
<table>
<tr>
<!--	<td class="tabltxt-r-bg" colspan="6">&Uuml;bersicht Themen:</td>-->
<td ID= "SiteTitel">Ursula Davatz - Vortr&auml;ge&nbsp;</td>
<td colspan="8" class="tabltxt-r">
<?php //getmenu.php

if (@$new == "true" || @$change == "true"){
	$result = mysql_query ("SELECT * FROM thema ORDER BY thema ASC");
	$i=0;
	$lastThema="";
?>

		<input type="hidden" name="page" value="<?php echo $page ?>">
		<input type="hidden" name="sortby" value="standart">
		<select name="searchnew" size="1">
<?php
	if ($new == "true"){
		echo "<option value='1' selected>Bitte w&auml;hlen...</option>\n";
		$thema = "";
	}
	$thema_id = $thema;
	while ($row = mysql_fetch_array($result)){
	 		$idWWW = $row["id_thema"];
	 		$thema = urldecode($row["thema"]);
	 		$select = "";
	 		if ($idWWW == $thema_id) $select = "selected";
	 		echo "<option value='$idWWW' $select>$thema</option>\n";
		  	$i++;
	}
	echo "</select>\n";

} 
else 
{
	if(!isset($table)) $table = "vortrag";
	$result = mysql_query ("SELECT id_thema, thema, thema_id FROM thema AS A, $table AS B WHERE A.id_thema=B.thema_id GROUP BY id_thema ORDER BY thema ASC");
	$lastThema="";
?>
<form method="get" action="vortraege.php" name="themen">
<select name="search" size="1" onChange='this.form.submit()'>		
<?php
if ($search == "all"){ $select = "selected"; }
	echo"<option value='all' $select>alle Themen</option>";
	
	while ($row = mysql_fetch_array($result)){
	 		$id = $row["id_thema"];
	 		$thema = urldecode($row["thema"]);
	 		$select = "";
	 		if ($id == $search){ $select = "selected"; }
	 			echo "<option value='$id' $select>$thema</option>\n";
			$lastThema=$row["thema"];
	}
	echo "</select>\n";
	echo "</form>\n";
}
mysql_free_result($result);
?>
	</td>
</tr>
	<tr>
	<th>N&auml;chster Vortrag<br>
	</th>
	<th><a class="th" href="<?php	echo $url."?orderby=Titel&amp;orderdir=".$directions["Titel"];?>">Titel sortieren</a><br>
	</th>
	<th><a class="th" href="<?php echo	$url."?orderby=Thema&amp;orderdir=".$directions["thema"];?>">Themen sortieren</a><br>
	</th>
	<th>Info<br>
	</th>
	<th>PDF / Video<br>
	</th>
	<th>Audio-File<br>
	</th>
	<th><a class="th" href="<?php echo	$url."?orderby=Downloads&amp;orderdir=".$directions["downloads"];?>">PDF Downloads</a><br>
	</th>
	<th><a class="th" href="<?php echo	$url."?orderby=AudioFileDownloads&amp;orderdir=".$directions["audiofile_downloads"];?>">Audio / Video File Downloads</a><br>
	</th>
	<th><a class="th" href="<?php echo	$url."?orderby=Gehalten&amp;orderdir=".$directions["gehalten"];?>">Gehalten</a><br>
	</th>
	</tr>
	<tr>
<?php
		
		if(!empty($search) && $search != "all")
		{
			$thema_condition = "thema_id=$search";
		}
		else
		{
			$thema_condition = "thema_id!=255";
		}
		$query = "select Titel, thema, pdf, audiofile, audiofile_size, audiofile_downloads, id, google_video_url, google_video_size, google_video_downloads, downloads, zeit, Zielpublikum, location, date_format(gehalten,'%d.%m.%Y') 
							as gehalten_formatted 
							from vortrag, thema
							where $thema_condition and id_thema=thema_id
							order by ".$orderby." ".$orderdir;
		$vortrag_result = mysql_query($query);
		echo	'<td valign="top" rowspan="'.(mysql_num_rows($vortrag_result)+1).'" colspan="1" width="25%">';
		
		$query = "select Titel, thema, Zusammenfassung, zeit, Zielpublikum, location, id, date_format(gehalten,'%d.%m.%Y') 
							as gehalten_formatted, unix_timestamp(gehalten) as gehalten_unix,
							google_video_url
							from vortrag, thema 
							where thema_id!=255 and id_thema=thema_id
							and gehalten >= now()
							order by gehalten ASC limit 1";
							
		$result = mysql_query($query);
		$values = mysql_fetch_assoc($result);
		echo "<table class='nopaddingTABLE'>";
		echo "<tr>";
		echo "<td colspan='2' class='TDbold-big'>";
		echo urldecode ($values["Titel"]);
		echo "</td>\n";
		echo "</tr>";
		echo "<tr>\n";
		if (!empty($values["gehalten_formatted"]))
			{
				echo '<td>Datum:</td><td class="TDbold">'.stripslashes(urldecode($values["gehalten_formatted"].'</td>'));
			}
		echo "</tr>";
		echo "<tr>";
		$time_H = time("%H",$values["zeit"]);
		$time_M = time("%M",$values["zeit"]);
		if (!empty($values["zeit"]))
			{
				echo '<td>Zeit:</td><td class="TDbold">'.strftime('%H:%M' ,$values["zeit"]).'</td>';
			}
		echo "</tr>";
		echo "<tr>";
		if (!empty($values["location"]))
			{
				echo '<td>Ort:</td><td class="TDbold">'.stripslashes(urldecode($values["location"])).'</td>';
			}
		echo "</tr>";
		if (!empty($values["thema"]))
			{
				echo '<tr><td class="nopaddingTABLE" colspan="2">Ein Vortrag zum Thema:</td></tr>';
				echo '<tr><td class="nopaddingTABLE" colspan="2">'.stripslashes(urldecode($values["thema"])).'</td></tr>';
			}
		echo "</table>";
		echo "</td>";
		$open_row = false;
		
		while($values = mysql_fetch_assoc($vortrag_result))
		{
			if($open_row)
			{
				echo "<tr class='tabltxt-l".$suffix."'>";
			}
			else
			{
				$open_row = true;
			}
			$umfeld = array();
			if (!empty($values["Zielpublikum"]))
			{
				$umfeld[] = 'Zielpublikum: '.urldecode($values["Zielpublikum"]);
			}
			if (!empty($values["location"]))
			{
				$umfeld[] = 'Ort: '.urldecode($values["location"]);
			}
			$zieltext = implode(', ', $umfeld);
			echo "<td>";
			if(empty($values["google_video_url"]))
			{
				echo "".stripslashes(urldecode ($values["Titel"]))."";
			}	
			else
			{
 				list($google_video_hours, $google_video_minutes, $google_video_seconds) = split(":", $values["google_video_size"]); 
 				$videoLength = $google_video_hours."h&nbsp;".$google_video_minutes."m&nbsp;".$google_video_seconds."s";
 				echo "<a class='links".$suffix."'	href='/html/php/download_vortrag.php?id=".$values["id"]."&download=google_video' alt='Google Video: ".$videoLength."' title='Google Video: ".$videoLength."' target='_blank'>
 						".stripslashes(urldecode ($values["Titel"]))."
				</a>";
			}	
			echo "</td>";
			
			echo "<td class='tabltxt-l"."'>".stripslashes(urldecode ($values["thema"]))."</td>";
			echo "<td>";
			$popurl = "popup_vortrag.php?id=".$values["id"];
			$script = 'window.open("'.$popurl.'", "popup", "menubar=no,resizable=no,scrollbars=yes,height=400,locationbar=no,toolbar=yes,width=500").focus(); return false';
			echo "<a class='big-dot' href='$popurl' onClick='".$script."'>?</a>";
			echo "</td>";
			echo "<td class='tabltxt-c"."'>";
			if(empty($values["pdf"]))
			{
				echo "";
			}
			else
			{
				echo "<a class='pdf-ico".$suffix."'	href='/html/php/download_vortrag.php?id=".$values["id"]."&download=pdf'
				target='_blank'><img src='../html/images/adobe.gif' alt='PDF File'></a>";
				if(empty($values["google_video_url"])) {
					echo "";
				} else {
					echo "&nbsp";
				}
			}
			if(empty($values["google_video_url"])) {
				echo "";
			} else {
				echo "<a class='pdf-ico".$suffix."'	href='/html/php/download_vortrag.php?id=".$values["id"]."&download=google_video'
				target='_blank'><img src='../html/images/google_video.gif' alt='Google Video: ".$videoLength."' title='Google Video: ".$videoLength."'></a>";
			}
			echo "</td>";
			echo "<td class='tabltxt-l"."'>";
			if(empty($values["audiofile"])) {
				echo "&nbsp;";
			} else {
				$sizeMb = strval(round($values["audiofile_size"]/1024/1024, 2))."M";
				echo "<audio controls='pdf-ico"."'	src='/html/php/download_vortrag.php?id=".$values["id"]."&download=audiofile'
				target='_blank'><img src='../html/images/audiofile.gif' alt='Audio File'>".$sizeMb."</audio>";
			}
			echo "</td>";
			echo "<td class='tabltxt-c"."'>".urldecode ($values["downloads"])."</td>";	
			echo "<td class='tabltxt-c"."'>".urldecode ($values["audiofile_downloads"])." / ".urldecode ($values["google_video_downloads"])."</td>";	
			echo "<td class='tabltxt-c"."'>".$values["gehalten_formatted"]."</td>";
			echo "</tr>\n";
			if(empty($suffix))
			{
				$suffix = "-bg";
			}
			else
			{
				$suffix = "";
			}

		}
?>
</table>
</body>
</html>
