<?php //uebersichtartikel.php
//Hier werden die Variablen gepr?ft
if (empty($search))	$search 	= "all";
if (empty($sortby))	$sortby   = "standart";
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
	if (isset($search) &&  $search == "all") {
		$all = mysqli_query($conn1, "SELECT * FROM $table"); 
	} else {
		$all = mysqli_query($conn1, "SELECT * FROM $table WHERE thema_id=$search");
	}
	$Ptot = mysqli_num_rows($all);
	mysqli_free_result($all);
	if (empty($disRow)) $disRow = 10;
	$Pend = $P * $disRow;
	$Pstart = $Pend - ($disRow-1);
	$Palle = ceil($Ptot / $disRow);
	if ( $P > 1 ){
		$Pzurueck = "<a href='$url&sortby=$sortby&n=last'>\n";
		$Pzurueck .= "<img src='../images/links.gif' border='0' width='20' height='20' alt=''>\n";
		$Pzurueck .= "</a>\n";
	} else {
		$Pzurueck = "<img src='../images/links_na.gif' border='0' width='20' height='20' alt=''>\n";
	}
	if ( $P < $Palle ) { 
		$Pvor = "<a href='$url&sortby=$sortby&n=next'>\n";
		$Pvor .= "<img src='../images/rechts.gif' border='0' width='20' height='20' alt=''>\n";
		$Pvor .= "</a>\n";
	} else {
		$Pvor = "<img src='../images/rechts_na.gif' border='0' width='20' height='20' alt=''>\n";
	}
?>
<td class='TDSiteNav'>
<table class='TABLEpaging'  align="right">
<tr>
<?php 
	echo "	<td class='TDvon2'>Seite $P von $Palle</td>\n";
	echo "	<td class='TDrechtslinks'>\n $Pzurueck</td>\n"; 
	echo "	<td class='TDrechtslinks'>\n	$Pvor	</td>\n"; 
?>
</tr>
</table>
</td>
<tr>
<td class='TDSiteTitel' colspan="2">
<?php
//
	echo "<table class='TABLEliste' width='100%' cellspacing='2'>\n";
	echo "<tr>\n";
	echo "<th class='THnr' nowrap>Nr. <font size='1'>($Ptot)</font></th>\n";
	echo "<th class='THtitel'>\n";
	echo "	<a class='Atitel' href='$url&sortby=titel_artikel'\n";	?>>Titel</a><?php
	echo "</th>\n";
	echo "<th class='THdatum'>\n";
	echo "	<a class='Atitel' href='$url&sortby=erschienen'\n";?>>Erschienen</a><?php
	echo "</th>\n";
	echo "<th class='THzahl'>\n";
	echo "	<a class='Atitel' href='$url&sortby=$pdf'\n";	?>>PDF</a><?php
	echo "</th>\n";
	echo "<th class='THthema'>"; include("getmenu.php"); echo"</th>\n";
	echo "<th class='THbereich'>\n";
	echo "	<a class='Atitel' href='$url&sortby=Familie' 	\n";?>>F</a>	<?php
	echo "</th>\n";
	echo "<th class='THbereich'>\n";
	echo "	<a class='Atitel' href='$url&sortby=Arbeit'\n";?>>A</a></th><?php
	echo "<th class='THbereich'>\n";
	echo "<a class='Atitel' href='$url&sortby=Gesundheit' 	\n";?>>G</a></th><?php
	echo "<th class='THbereich'>\n";
	echo "	<a class='Atitel' href='$url&sortby=Erziehung'	\n";?>>E</a></th><?php
	echo "</tr>\n";
	$i++;

	if ($search=="all"){
		$precision="";
	}	else	{
		$precision="WHERE thema_id = $search";
	}
	if ($sortby=="standart"){
		$sort="erschienen";
	} else {
		$sort=$sortby;
	}
//echo $sortby;
$sql = "SELECT * FROM artikel $precision ORDER BY $sort";
$result = mysqli_query($conn1, $sql) or die (mysqli_error($conn1));

			$ok = "<img class='IMGok' src='../images/OK.gif' alt=''>";
			$i=1;	
			while ($row = mysqli_fetch_array($result)){
				if ( $i >= $Pstart && $i <= $Pend ){
					$thema_id = $row["thema_id"];
					$result_thema = mysqli_query($conn1, "SELECT * FROM thema WHERE id_thema=$thema_id");
					while ($thema_row = mysqli_fetch_array($result_thema)){
					$thema_title = urldecode($thema_row["thema"]); 
					}
					$article_id = $row["id_artikel"];
					$title = stripslashes(urldecode($row["titel_artikel"]));
					$erschienen = datum_ch($row["erschienen"]);
					$pdf_file = $row["pdf"];
					$pdf_path = "../../pdf/".$pdf_file;
					if (@filetype($pdf_path) != "file"){
						$pdf_file ="";
						}		$Familie = $row["Familie"];
					$Arbeit = $row["Arbeit"];
					$Gesundheit = $row["Gesundheit"];
					$Erziehung = $row["Erziehung"];
					$Familie == 1 ? $Familie = $ok : $Familie = "&nbsp;";
					$Arbeit == 1 ? $Arbeit = $ok : $Arbeit = "&nbsp;";
					$Gesundheit == 1 ? $Gesundheit = $ok : $Gesundheit = "&nbsp;";
					$Erziehung == 1 ? $Erziehung = $ok : $Erziehung = "&nbsp;";
					if (empty($article_id))  	$article_id		= "&nbsp;";
					if (empty($title)) 	$title	= "---";
					echo "<tr>\n";
					echo "<td class='TDnr'>$i</td>\n";
					echo "	<td class='TDtitel'>\n";
					echo "	<a href='$url&change=true&id=$article_id&thema=$thema_id'>$title</a></td>\n";					
					echo "	<td class='TDdatum'>$erschienen</td>\n";					
					echo "	<td class='TDtitel'>$pdf_file</td>\n";
					echo "	<td class='TDtitel'>$thema_title</td>\n";
					echo "	<td class='TDbereich'>$Familie</td>\n";
					echo "	<td class='TDbereich'>$Arbeit</td>\n";
					echo "	<td class='TDbereich'>$Gesundheit</td>\n";
					echo "	<td class='TDbereich'>$Erziehung</td>\n";
					echo "</tr>\n";
				}
				$i++;
			}
		@mysqli_free_result($result);
?>
</table>
</td>
</tr>
</table>
