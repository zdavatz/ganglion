<?php //uebersichtKurse.php
//Hier werden die Variablen gepr?ft
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
//sortieren
//
//
if (empty($sortby)) $sortby="beginn";
if ($sortby == "standart" && $search != "all") $sortby = "titel";
if ($sortby == "standart" && $search == "all") $sortby = "Thema";
	$order = array(0,0,0,0,0,0,0,0,0,0,0);
	if 		(isset($sortby) && $sortby=="titel")		{	$SortBy="titel_kurse ASC";		$order[0] = 1;	}
	elseif	(isset($sortby) && $sortby=="kosten")		{	$SortBy="kosten_kurse ASC"; 	$order[1] = 1;	}
	elseif	(isset($sortby) && $sortby=="Thema")		{	$SortBy="thema  ASC";			$order[2] = 1;	}
	elseif	(isset($sortby) && $sortby=="Familie")		{	$SortBy="Familie DESC";			$order[3] = 1;	}
	elseif	(isset($sortby) && $sortby=="Arbeit")	{	$SortBy="Arbeit DESC";	$order[4] = 1;	}
	elseif	(isset($sortby) && $sortby=="Gesundheit")	{	$SortBy="Gesundheit DESC";		$order[5] = 1;	}
	elseif	(isset($sortby) && $sortby=="Erziehung")	{	$SortBy="Erziehung DESC";		$order[6] = 1;	}
	elseif	(isset($sortby) && $sortby=="datum")		{	$SortBy="datum_kurse DESC";		$order[7] = 1;	}
	elseif	(isset($sortby) && $sortby=="beginn")		{	$SortBy="beginn_kurse DESC";	$order[8] = 1;	}
	elseif	(isset($sortby) && $sortby=="ende")			{	$SortBy="ende_kurse DESC";		$order[9] = 1;	}
//	
	elseif 	(isset($sortby) && $sortby=="titel-")		{	$SortBy="titel_kurse DESC";	}
	elseif 	(isset($sortby) && $sortby=="kosten-")		{	$SortBy="kosten_kurse DESC";}
	elseif 	(isset($sortby) && $sortby=="Thema-")		{	$SortBy="thema  DESC";		}
	elseif	(isset($sortby) && $sortby=="Familie-")		{	$SortBy="Familie ASC";		}
	elseif	(isset($sortby) && $sortby=="Arbeit-"){	$SortBy="Arbeit ASC";	}
	elseif	(isset($sortby) && $sortby=="Gesundheit-")	{	$SortBy="Gesundheit ASC";	}	
	elseif	(isset($sortby) && $sortby=="Erziehung-")	{	$SortBy="Erziehung ASC";	}
	elseif	(isset($sortby) && $sortby=="datum-")		{	$SortBy="datum_kurse ASC";	}
	elseif	(isset($sortby) && $sortby=="ende-")		{	$SortBy="ende_kurse ASC";	}
//
//
	$order[0]==1?$titel="titel-" 				: $titel="titel";			
	$order[1]==1?$kosten="kosten-" 				: $kosten="kosten";				
	$order[2]==1?$Thema="Thema-"				: $Thema="Thema";			
	$order[3]==1?$Familie="Familie-" 			: $Familie="Familie";		
	$order[4]==1?$Arbeit="Arbeit-" 	: $Arbeit="Arbeit";
	$order[5]==1?$Gesundheit="Gesundheit-" 		: $Gesundheit="Gesundheit";		
	$order[6]==1?$Erziehung="Erziehung-" 		: $Erziehung="Erziehung";
	$order[7]==1?$datum="datum-" 				: $datum="datum";
	$order[8]==1?$beginn="beginn-" 				: $beginn="beginn";
	$order[8]==1?$ende="ende-" 					: $ende="ende";
//

	$Titel = isset($Titel) ? $Titel : "";
	$beginn = isset($beginn) ? $beginn : "";
	$ende = isset($ende) ? $ende : "";
	$platz = isset($platz) ? $platz : "";
	$teilnehmer = isset($teilnehmer) ? $teilnehmer : "";
	$datum = isset($datum) ? $datum : "";
	$Familie = isset($Familie) ? $Familie : "";
	$Arbeit = isset($Arbeit) ? $Arbeit : "";
	$Gesundheit = isset($Gesundheit) ? $Gesundheit : "";
	$Erziehung = isset($Erziehung) ? $Erziehung : "";
	$gehalten = isset($gehalten) ? $gehalten : "";

	echo "<table class='TABLEliste' width='100%' cellspacing='2'>\n";
	echo "<tr>\n";
	echo "<th class='THnr' nowrap>Nr. <font size='1'>($Ptot)</font></th>\n";
	echo "<th class='THtitel'>\n";
	echo "	<a class='Atitel' href='$url&sortby=$Titel'\n";	?>>Titel</a><?php
	echo "</th>\n";
	echo "<th class='THdatum'>\n";
	echo "	<a class='Atitel' href='$url&sortby=$beginn'\n";?>>Kursbeginn</a><?php
	echo "</th>\n";
	echo "<th class='THdatum'>\n";
	echo "	<a class='Atitel' href='$url&sortby=$ende'\n";?>>Kursende</a><?php
	echo "</th>\n";	
	echo "<th class='THzahl'>\n";
	echo "	<a class='Atitel' href='$url&sortby=$platz'\n";?>>Zeit</a><?php
	echo "</th>\n";
	echo "<th class='THzahl'>\n";
	echo "	<a class='Atitel' href='$url&sortby=$teilnehmer'\n";?>>Teilnehmer</a><?php
	echo "</th>\n";
	echo "<th class='THdatum'>\n";
	echo "	<a class='Atitel' href='$url&sortby=$datum'\n";?>>letzte &Auml;nderung</a><?php
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
$tabellen			=	"kurse AS A LEFT OUTER JOIN thema AS B ON(A.thema_id=B.id_thema)";
$whereBedingungen	=	"TRUE";
	if ($search=="all"){
		$precision="";
	}	else	{
		$precision="A.thema_id=$search AND";
	}
$mysqlquery = "SELECT * FROM $tabellen WHERE $precision $whereBedingungen ORDER BY $SortBy";
//echo $mysqlquery;
$result = mysqli_query($conn1, $mysqlquery);
			$ok = "<img class='IMGok' src='../images/OK.gif' alt=''>";
			$i=1;	
			while ($row = mysqli_fetch_array($result)){
				if ( $i >= $Pstart && $i <= $Pend ){
					$datum = datum_ch($row["datum_kurse"]);
					$beginn = datum_ch($row["beginn_kurse"]);
					$ende = datum_ch($row["ende_kurse"]);
					$id = $row["id_kurse"];
					$thema_id = $row["thema_id"];
					$Titel = stripslashes(urldecode($row["titel_kurse"]));
					$statusTitel = addslashes($Titel);
					$thema = stripslashes(urldecode($row["thema"]));
					//$thema = htmlentities($thema);
					$fam = $row["Familie"];
					$arb = $row["Arbeit"];
					$ges = $row["Gesundheit"];
					$erz = $row["Erziehung"];
					$fam == 1 ? $fam = $ok : $fam = "&nbsp;";
					$arb == 1 ? $arb = $ok : $arb = "&nbsp;";
					$ges == 1 ? $ges = $ok : $ges = "&nbsp;";
					$erz == 1 ? $erz = $ok : $erz = "&nbsp;";
					if (empty($id))  	$id		= "&nbsp;";
					if (empty($Titel)) 	$Titel	= "---";
					if (empty($thema))  $thema	= "&nbsp;";
					if ($gehalten == "01.01.1970") $gehalten = "&nbsp;";
					echo "<tr>\n";
					echo "<td class='TDnr'>$i</td>\n";
					echo "	<td class='TDtitel'>\n";
					echo "		<a href='$url&change=true&id=$id&thema=$thema_id'";?>> <?php echo"$Titel</a></td>\n";					
					echo "	<td class='TDdatum'>$beginn</td>\n";
					echo "	<td class='TDdatum'>$ende</td>\n";					
					echo "	<td class='TDzahl'>".$row["platz_kurse"]."</td>\n";
					echo "	<td class='TDzahl'>".$row["teilnehmer_kurse"]."</td>\n";
					echo "	<td class='TDdatum'>$datum</td>\n";					
					echo "	<td class='TDthema'>$thema</td>\n";
					echo "	<td class='TDbereich'>$fam</td>\n";
					echo "	<td class='TDbereich'>$arb</td>\n";
					echo "	<td class='TDbereich'>$ges</td>\n";
					echo "	<td class='TDbereich'>$erz</td>\n";
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
