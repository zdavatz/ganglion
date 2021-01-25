<?php //uebersichtVortrag.php
//
//Hier werden die Variablen gepr�ft
if (empty($request))$request	= "uebersicht";
if (empty($search))	$search 	= "all";
//
$i=0;
//der neuer eintrag buttom
?>
<tr>
<td class='TDSiteTitel'>
<?php
include("new.php");
?>
</td>

<?php
//
if (empty($Z)) $Z = 0;
if (empty($P)) $P = 1;
//
//
//Paging-Funktion
//
if (isset($n) && $n=="next") {$P++;}
if (isset($n) && $n=="last") {$P--;}
//
$url = "$PHP_SELF?$nocache&page=$page&P=$P&search=$search";
//
$Ptot=0;
$all=0;
//
	$result = mysql_query("SELECT id_text,bereich_text,inhalt_text,datum_text from text");
	$Ptot = mysql_num_rows($result);
	if (empty($disRow)) $disRow = 10;
	$Pend = $P * $disRow;
	$Pstart = $Pend - ($disRow-1);
	$Palle = ceil($Ptot / $disRow);
	if ( $P > 1 ){
		$Pzur…k = "<a href='$url&sortby=$sortby&n=last'>\n";
		$Pzur…k .= "<img class='IMGpaging' src='../images/links.gif' border='0' width='20' height='20' alt=''>\n";
		$Pzur…k .= "</a>\n";
	} else {
		$Pzur…k = "<img class='IMGpaging' src='../images/links_na.gif' border='0' width='20' height='20' alt=''>\n";
	}
	if ( $P < $Palle ) {
		$Pvor = "<a href='$url&sortby=$sortby&n=next'>\n";
		$Pvor .= "<img class='IMGpaging' src='../images/rechts.gif' border='0' width='20' height='20' alt=''>\n";
		$Pvor .= "</a>\n";
	} else {
		$Pvor = "<img class='IMGpaging' src='../images/rechts_na.gif' border='0' width='20' height='20' alt=''>\n";
	}

?>

<td class='TDSiteNav'>
<table class='TABLEpaging'  align="right">
<tr>
<?php
	echo "	<td class='TDvon2'>Seite $P von $Palle</td>\n";
	echo "	<td class='TDrechtslinks'>\n $Pzur…k</td>\n";
	echo "	<td class='TDrechtslinks'>\n	$Pvor	</td>\n";
?>
</tr>
</table>
</td>
<tr>
<td class='TDSiteTitel' colspan="2">
<?php
//sortieren
//
//
if (empty($sortby)) $sortby="Titel";
if ($sortby == "standart" && $search != "all") $sortby = "Titel";
if ($sortby == "standart" && $search == "all") $sortby = "Thema";

//id_text,bereich_text,inhalt_text,datum_text
	if 		(isset($sortby) && $sortby=="bereich_text")	{	$SortBy="bereich_text ASC";	$order[0] = 1;	}
	elseif	(isset($sortby) && $sortby=="inhalt_text")	{	$SortBy="inhalt_text ASC"; 	$order[1] = 1;	}
	elseif	(isset($sortby) && $sortby=="datum_text")	{	$SortBy="datum_text  DESC";	$order[2] = 1;	}

//
	elseif 	(isset($sortby) && $sortby=="bereich_text-"){	$SortBy="bereich_text DESC";}
	elseif 	(isset($sortby) && $sortby=="inhalt_text-")	{	$SortBy="inhalt_text DESC";	}
	elseif 	(isset($sortby) && $sortby=="datum_text-")	{	$SortBy="datum_text  ASC";	}

//
	$order[0]==1 ? $bereich_text="bereich_text-" : $bereich_text="bereich_text";
	$order[1]==1 ? $inhalt_text="inhalt_text-"	 : $inhalt_text="inhalt_text";
	$order[2]==1 ? $datum_text="datum_text-"	 : $datum_text="datum_text";

//

	echo "<table class='TABLEliste' width='100%' cellspacing='2'>\n";
	echo "<tr>\n";

	echo "<th class='THnr' nowrap>Nr. <font size='1'>($Ptot)</font></th>\n";
	
	echo "<th class='THtitel'>\n";
	echo "	<a class='Atitel' href='$url&sortby=$inhalt_text'\n";	?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Text');return document.returnValue">Text</a><?php
	echo "</th>\n";
	
	echo "<th class='THzahl'>\n";
	echo "	<a class='Atitel' href='$url&sortby=$bereich_text'\n";	?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Bereich');return document.returnValue">Bereich</a><?php
	echo "</th>\n";
	
	echo "<th class='THdatum'>\n";
	echo "	<a class='Atitel' href='$url&sortby=$datum_text'\n";	?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Datum');return document.returnValue">Datum</a><?php
	echo "</th>\n";

	echo "</tr>\n";

	$q = $Panfang;
	$q++;
	$i++;


//SELECT id_text,bereich_text,inhalt_text,datum_text from text 

			$i=1;
		$result = mysql_query("SELECT id_text,bereich_text,inhalt_text,datum_text from text");
			while ($row = mysql_fetch_array($result)){
				if ( $i >= $Pstart && $i <= $Pend ){
					$id_text = $row["id_text"];
					$bereich_text = urldecode($row["bereich_text"]);
					$inhalt_text = urldecode($row["inhalt_text"]);
					
					$inhalt_text = firstchar($inhalt_text,120);
					$datum_text = deStampDate($row["datum_text"]);
					
					$inhalt_text = $inhalt_text."...";

					if ($gehalten == "01.01.1970") $gehalten = "&nbsp;";
					echo "<tr>\n";
					echo "<td class='TDnr'>$i</td>\n";
					echo "	<td class='TDtitel'>\n";
					echo "		<a href='$url&change=true&id_text=$id_text'";?> onMouseOut="FnormText()" onMouseOver="StatusMsg('<?php echo "Detaileintrag bearbeiten";?>');return document.returnValue"> <?php echo"$inhalt_text</a></td>\n";
					echo "	<td class='TDbereich'>".$bereich_text."</td>\n";
					echo "	<td class='TDdatum'>".$datum_text."</td>\n";
					echo "</tr>\n";
				}
				$i++;

			}

		@mysql_free_result($result);
?>
</table>
</td>
</tr>
</table>