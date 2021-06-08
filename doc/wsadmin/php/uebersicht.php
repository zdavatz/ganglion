

<?php //uebersichtVortrag.php
//Hier werden die Variablen geprüft
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
error_reporting(E_ALL ^ E_NOTICE);
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
	if (!empty($searchterm))
	{
		$query = "	SELECT * 
					FROM $table
					WHERE Titel LIKE '%$searchterm%'";
		$all = mysqli_query($conn1, $query);
	}
	elseif (isset($search) &&  $search == "all") {
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
		$Pzurueck .= "<img class='IMGpaging' src='../images/links.gif' border='0' width='20' height='20' alt=''>\n";
		$Pzurueck .= "</a>\n";
	} else {
		$Pzurueck = "<img class='IMGpaging' src='../images/links_na.gif' border='0' width='20' height='20' alt=''>\n";
	}
	if ( $P < $Palle ) {
		$Pvor = "<a href='$url&sortby=@$sortby&n=next'>\n";
		$Pvor .= "<img class='IMGpaging' src='../images/rechts.gif' border='0' width='20' height='20' alt=''>\n";
		$Pvor .= "</a>\n";
	} else {
		$Pvor = "<img class='IMGpaging' src='../images/rechts_na.gif' border='0' width='20' height='20' alt=''>\n";
	}

if($Palle>0)
{
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
<?php 
}
else
{
echo "<td>&nbsp;</td>";
}
?>
</tr>
<tr>
<td class='TDSiteTitel' colspan="2">
<?php
//sortieren
//
//
if (empty($sortby)) $sortby="datum";
if ($sortby == "standart" && $search != "all") $sortby = "Titel";
if ($sortby == "standart" && $search == "all") $sortby = "Thema";

	$order = array(0,0,0,0,0,0,0,0,0,0,0,0);
	if 	(isset($sortby) && $sortby=="Titel")			{	$SortBy="Titel ASC";		$order[0] = 1;	}
	elseif	(isset($sortby) && $sortby=="datum")		{	$SortBy="gehalten DESC"; 	$order[1] = 1;	}
	elseif	(isset($sortby) && $sortby=="Thema")		{	$SortBy="thema  ASC";		$order[2] = 1;	}
	elseif	(isset($sortby) && $sortby=="Familie")		{	$SortBy="Familie DESC";		$order[3] = 1;	}
	elseif	(isset($sortby) && $sortby=="Arbeit")		{	$SortBy="Arbeit DESC";$order[4] = 1;	}
	elseif	(isset($sortby) && $sortby=="Gesundheit")	{	$SortBy="Gesundheit DESC";	$order[5] = 1;	}
	elseif	(isset($sortby) && $sortby=="Erziehung")		{	$SortBy="Erziehung DESC";	$order[6] = 1;	}
	elseif	(isset($sortby) && $sortby=="hits")			{	$SortBy="hits DESC";		$order[7] = 1;	}
	elseif	(isset($sortby) && $sortby=="downloads"	)	{	$SortBy="downloads DESC";	$order[8] = 1;	}
	elseif	(isset($sortby) && $sortby=="audiofile_downloads"	)	{	$SortBy="audiofile_downloads DESC";	$order[9] = 1;	}
	elseif	(isset($sortby) && $sortby=="pdf")			{	$SortBy="pdf DESC";			$order[10] = 1;	}
	elseif	(isset($sortby) && $sortby=="audiofile")			{	$SortBy="audiofile DESC";			$order[11] = 1;	}
//
	elseif(isset($sortby) && $sortby=="Titel-")		{	$SortBy="Titel DESC";		}
	elseif(isset($sortby) && $sortby=="datum-")	{	$SortBy="gehalten ASC";		}
	elseif(isset($sortby) && $sortby=="Thema-")	{	$SortBy="thema  DESC";		}
	elseif	(isset($sortby) && $sortby=="Familie-")		{	$SortBy="Familie ASC";		}
	elseif	(isset($sortby) && $sortby=="Arbeit-")		{	$SortBy="Arbeit ASC";	}
	elseif	(isset($sortby) && $sortby=="Gesundheit-")	{	$SortBy="Gesundheit ASC";	}
	elseif	(isset($sortby) && $sortby=="Erziehung-")		{	$SortBy="Erziehung ASC";	}
	elseif	(isset($sortby) && $sortby=="hits-")			{	$SortBy="hits ASC";			}
	elseif	(isset($sortby) && $sortby=="downloads-")			{	$SortBy="downloads ASC";			}
	elseif	(isset($sortby) && $sortby=="audiofile_downloads-")			{	$SortBy="audiofile_downloads ASC";			}
	elseif	(isset($sortby) && $sortby=="pdf-")			{	$SortBy="pdf ASC";			}
	elseif	(isset($sortby) && $sortby=="audiofile-")			{	$SortBy="audiofile ASC";			}
//
    
//
	$order[0]==1?$Titel="Titel-"				: $Titel="Titel";
	$order[1]==1?$datum="datum-"			: $datum="datum";
	$order[2]==1?$Thema="Thema-"			: $Thema="Thema";
	$order[3]==1?$Familie="Familie-"			: $Familie="Familie";
	$order[4]==1?$Arbeit="Arbeit-"			: $Arbeit="Arbeit";
	$order[5]==1?$Gesundheit="Gesundheit-"	: $Gesundheit="Gesundheit";
	$order[6]==1?$Erziehung="Erziehung-"		: $Erziehung="Erziehung";
	$order[7]==1?$hits="hits-"					: $hits="hits";
	$order[8]==1?$downloads="downloads-"	: $downloads="downloads";
	$order[9]==1?$audiofile_downloads="audiofile_downloads-"	: $audiofile_downloads="audiofile_downloads";
	$order[10]==1?$pdf="pdf-"				: $pdf="pdf";
	$order[11]==1?$audiofile="audiofile-"				: $audiofile="audiofile";
//

	echo "<table class='TABLEliste' width='100%' cellspacing='2'>\n";
	echo "<tr>\n";

	echo "<th class='THnr' nowrap>Nr. <font size='1'>($Ptot)</font></th>\n";

	echo "<th class='THtitel'>\n";
	echo "	<a class='Atitel' href='$url&sortby=$Titel'\n";	?>>Titel</a><?php
	echo "</th>\n";

	echo "<th class='THdatum'>\n";
    echo "	<a class='Atitel' href='$url&sortby=$datum'\n";	?>>Datum</a><?php
	echo "</th>\n";

	echo "<th class='THzahl'>\n";
	echo "	<a class='Atitel' href='$url&sortby=$pdf'\n";	?>>PDF</a><?php
	echo "</th>\n";

	echo "<th class='THzahl'>\n";
	echo "	<a class='Atitel' href='$url&sortby=$audiofile'\n";	?>>Audiofile</a><?php
	echo "</th>\n";

	echo "<th class='THzahl'>\n";
	echo "	<a class='Atitel' href='$url&sortby=$hits'\n";	?>>Gelesen</a><?php
	echo "</th>\n";

	echo "<th class='THzahl'>\n";
	echo "	<a class='Atitel' href='$url&sortby=$downloads'\n";	?>>PDF Downloads</a><?php
	echo "</th>\n";

	echo "<th class='THzahl'>\n";
	echo "	<a class='Atitel' href='$url&sortby=$audiofile_downloads'\n";	?>>Audio Downloads</a><?php
	echo "</th>\n";

	echo "<th class='THthema'>"; include("getmenu.php"); echo"</th>\n";

	echo "<th class='THbereich'>\n";
	echo "	<a class='Atitel' href='$url&sortby=$Familie' 	\n";?>>F</a>	<?php
	echo "</th>\n";

	echo "<th class='THbereich'>\n";
	echo "	<a class='Atitel' href='$url&sortby=$Arbeit'\n";?>>A</a></th><?php

	echo "<th class='THbereich'>\n";
	echo "<a class='Atitel' href='$url&sortby=$Gesundheit' 	\n";?>>G</a></th><?php

	echo "<th class='THbereich'>\n";
	echo "	<a class='Atitel' href='$url&sortby=$Erziehung'	\n";?>>E</a></th><?php

	echo "</tr>\n";

	$i++;


//
if (isset($request) && $request=="uebersicht"){

	if (!empty($searchterm))
	{
		$query = "	SELECT * 
					FROM $table AS A, thema AS B 
					WHERE A.thema_id=B.id_thema 
					AND Titel LIKE '%$searchterm%'
					ORDER BY $SortBy";
		$result = mysqli_query($conn1, $query);
	}
	elseif (isset($search) &&  $search == "all") {
		$result = mysqli_query($conn1, "SELECT * FROM $table AS A, thema AS B WHERE A.thema_id=B.id_thema ORDER BY $SortBy");
	}
	else
	{
		$result = mysqli_query($conn1, "SELECT * FROM $table AS A, thema AS B WHERE A.thema_id=B.id_thema AND thema_id=$search ORDER BY $SortBy");
		$isresult = mysqli_num_rows($result);
		if ($isresult == 0) $result = mysqli_query($conn1, "SELECT * FROM $table AS A, thema AS B WHERE A.thema_id=B.id_thema ORDER BY $SortBy");
	}
	
	if(mysqli_num_rows($result)>0)
	{	
			$ok = "<img class='IMGok' src='../images/OK.gif' alt=''>";
			$i=1;
			while ($row = mysqli_fetch_array($result)){
				if ( $i >= $Pstart && $i <= $Pend ){
					$gehalten = datum_ch($row["gehalten"]);
					$id = $row["id"];
					$thema_id = $row["thema_id"];
					$Titel = stripslashes(urldecode($row["Titel"]));
					if (empty($Titel)) $Titel = "***";
					$statusTitel = addslashes($Titel);
					//$statusTitel = $Titel;
					$pdf_file = $row["pdf"];
					$pdf_path = "../../pdf/".$pdf_file;
					if (@filetype($pdf_path) == "file"){
						$pdf_file = $ok;
					}
					else{
						$pdf_file ="";
					}
					$thema = stripslashes(urldecode($row["thema"]));
					//$thema = htmlentities($thema);
					$audiofile = $row["audiofile"];
					$hits = $row["hits"];
					$fam = $row["Familie"];
					$arb = $row["Arbeit"];
					$ges = $row["Gesundheit"];
					$erz = $row["Erziehung"];
					if ($fam == 1) { $fam = $ok; }	else 	{ $fam = "&nbsp;"; 	}
					if ($arb == 1) { $arb = $ok; }	else 	{ $arb = "&nbsp;"; 	}
					if ($ges == 1) { $ges = $ok; }	else 	{ $ges = "&nbsp;"; 	}
					if ($erz == 1) { $erz = $ok; }	else	{ $erz = "&nbsp;"; 	}
					if (empty($id))  	$id		= "&nbsp;";
					if (empty($Titel)) 	$Titel	= "&nbsp;";
					if (empty($thema))  $thema	= "&nbsp;";
					if ($gehalten == "01.01.1970") $gehalten = "&nbsp;";
					echo "<tr>\n";
					echo "<td class='TDnr'>$i</td>\n";
					echo "	<td class='TDtitel'>\n";
					echo "		<a href='$url&change=true&id=$id&thema=$thema_id'";?>> <?php echo"$Titel</a></td>\n";
					echo "	<td class='TDdatum'>".$gehalten."</td>\n";
					echo "	<td class='TDzahl'>".$pdf_file."</td>\n";
					echo "	<td class='TDzahl'>".$audiofile."</td>\n";
					echo "	<td class='TDzahl'>".$row["hits"]."</td>\n";
					echo "	<td class='TDzahl'>".$row["downloads"]."</td>\n";
					echo "	<td class='TDzahl'>".$row["audiofile_downloads"]."</td>\n";
					echo "	<td class='TDthema'>$thema</td>\n";
					echo "	<td class='TDbereich'>$fam</td>\n";
					echo "	<td class='TDbereich'>$arb</td>\n";
					echo "	<td class='TDbereich'>$ges</td>\n";
					echo "	<td class='TDbereich'>$erz</td>\n";
					echo "</tr>\n";
				}
				$i++;

			}
		}
		else
		{
			echo "<td colspan='11'>Es wurden keine Vortr&auml;ge gefunden</td>";
		}
		@mysqli_free_result($result);
			

}
?>
</table>
</td>
</tr>
</table>

<form>
   <input type="button" name="print" value="Übersicht Vorträge drucken" onClick="print_lecture();">
</form>
