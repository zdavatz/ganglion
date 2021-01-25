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
<body>
<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/html/php/navbar.php");
?>
<br>	
<table>
<tr>
<td ID= "SiteTitel">Ganglion - Links&nbsp;
	</td>
	</tr>
</table>
<?php 
$url = $_SERVER["PHP_SELF"];
$valid = array
(
	"Titel"			=>	"text",
	"Thema"			=>	"thema",
	"Datum"			=>	"datum",
);
if(isset($_GET["orderby"]) && isset($valid[$_GET["orderby"]]))
{
	$orderby = $valid[$_GET["orderby"]];
}
else
{
	$orderby = "datum";
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
	"Thema"			=>	"asc",
	"Datum"			=>	"asc",
);
if($orderdir == "asc")
{
	$directions[$orderby] = "desc";
}
?>
<table>
	<tr>
	<th><a class="th" href="<?php	echo
			$url."?orderby=Titel&amp;orderdir=".$directions["text"];?>">Link</a><br></th>
	<th><a class="th" href="<?php echo $url."?orderby=Thema&amp;orderdir=".$directions["thema"];?>">Thema</a><br></th>
	<th><a class="th" href="<?php echo $url."?orderby=Datum&amp;orderdir=".$directions["datum"];?>">Datum</a><br></th>
	</tr>
<?php
$query = "select thema, text, url, date_format(datum,'%d.%m.%Y')
					as linkdate_formatted
					from links, thema 
					where id_thema=thema_id 
					order by ".$orderby." ".$orderdir;
		$links_result = mysql_query($query);

		while($values = mysql_fetch_assoc($links_result))
		{
		
			echo "<tr>";
			if(substr($values['url'],0 ,7) == "http://")
			{
				$http_url = $values['url'];
			}
			else
			{
				$http_url = "http://".$values['url'];
			}	
			echo "<td class='tabltxt-l".@$suffix."'><a class='links".@$suffix;
			echo "' href='".urldecode($http_url)."' target='_blank'>".($values["text"])."</a></td>";
			echo "<td class='tabltxt-l".@$suffix."'>".urldecode ($values["thema"])."</td>";
			echo "<td class='tabltxt-c".@$suffix."'>".$values["linkdate_formatted"]."</td>";
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
