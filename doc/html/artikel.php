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
<div colspan="4" class="tabltxt-dl-art">Downloads Artikel:&nbsp;
<?php
	($result = mysqli_query($conn1, "select sum(downloads) as sumd from artikel"));
 	$values = mysqli_fetch_array($result);
	$total_downloads = $values['sumd'];
	echo number_format($total_downloads,0,".","'");
?>
</div>
<table>
<tr>
<td ID= "SiteTitel">Ganglion - Zeitschriften&nbsp;
	</td>
	</tr>
</table>
<?php 
$url = $_SERVER["PHP_SELF"];
$valid = array
(
	"Titel"			=>	"titel_artikel",
	"Zeitschrift"			=>	"Zeitschrift",
	"Downloads"	=>	"downloads",
	"Erschienen"	=>	"erschienen",
);
if(isset($_GET["orderby"]) && isset($valid[$_GET["orderby"]]))
{
	$orderby = $valid[$_GET["orderby"]];
}
else
{
	$orderby = "erschienen";
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
	"Titel"						=>	"asc",
	"Zeitschrift"	=>	"asc",
	"downloads"				=>	"asc",
	"erschienen"				=>	"asc",
);
if($orderdir == "asc")
{
	$directions[$orderby] = "desc";
}
?>
<table class= "100proTABLE">
	<tr>
	<th><a class="th" href="<?php	echo $url."?orderby=Titel&amp;orderdir=".$directions["titel_artikel"];?>">Titel</a><br>
	</th>
	<th><a class="th" href="<?php echo	$url."?orderby=Zeitschrift&amp;orderdir=".$directions["Zeitschrift"];?>">Zeitschriften / Magazine</a><br>
	</th>
	<th>Pdf<br>
	</th>
	<th><a class="th" href="<?php echo	$url."?orderby=Downloads&amp;orderdir=".$directions["downloads"];?>">Downloads</a><br>
	</th>
	<th><a class="th" href="<?php echo	$url."?orderby=Erschienen&amp;orderdir=".$directions["erschienen"];?>">Erschienen</a><br>
	</th>
	</tr>
	<tr>
<?php
		$query = "select titel_artikel, Zeitschrift, id_artikel, thema_id, pdf, downloads, date_format(erschienen,'%d.%m.%Y')
							as erschienen_formatted 
							from artikel 
							order by ".$orderby." ".$orderdir;
		$vortrag_result = mysqli_query($conn1, $query);
		$result = mysqli_query($conn1, $query);
		$values = mysqli_fetch_assoc($result);
		$open_row = false;
		
		while($values = mysqli_fetch_assoc($vortrag_result))
		{
			if($open_row)
			{
				echo "<tr class='tabltxt-l".$suffix."'>";
			}
			else
			{
				$open_row = true;
			}
			echo "<td><a class='links".@$suffix."'href='/html/php/download_artikel.php?id=".$values["id_artikel"]."'target='_blank'>".urldecode ($values["titel_artikel"])."</a></td>";
			echo "<td class='tabltxt-l".@$suffix."'>".stripslashes(urldecode($values["Zeitschrift"]))."</td>";	
			echo "<td class='tabltxt-c".@$suffix."'>";
			if(empty($values["pdf"]))
			{
				echo "&nbsp;";
			}
			else
			{
				echo "<a class='tabltxt-c".@$suffix."'	href='/html/php/download_artikel.php?id=".$values["id_artikel"]."'
				target='_blank'><img src='../html/images/adobe.gif' alt='PDF File'></a>";
			}
			echo "<td class='tabltxt-c".@$suffix."'>".urldecode ($values["downloads"])."</td>";	
			echo "<td class='tabltxt-c".@$suffix."'>".$values["erschienen_formatted"]."</td>";
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
