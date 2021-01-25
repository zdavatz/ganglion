<?php //uebersichtDiskussion.php
//Hier werden die Variablen gepr�ft
if (empty($request))$request	= "uebersicht";
if (empty($search))	$search 	= "all";
//
$i=0;
//der neuer eintrag buttom
?>
<tr>
<td class='TDSiteTitel'>
&nbsp;
</td>

<?php
//
if (empty($Z)) $Z = 0;
if (empty($Pdis)) $Pdis = 1;
//
//
//Paging-Funktion
//
if (isset($n) && $n=="next") {$Pdis++;}
if (isset($n) && $n=="last") {$Pdis--;}
//
$url = "$PHP_SELF?$nocache&page=$page&Pdis=$Pdis&search=$search&diskussion=true&id=$id";
//
$Ptot=0;
$all=0;	
//
$felder_forum_inhalt =	"id_inhalt, thread_id, profil_id, titel, datum";
$felder_profil		=	"id_profil, login, email";
$tabellen			=	"forum_inhalt AS A, profil AS B";
$whereBedingungen	=	"A.profil_id=B.id_profil AND A.thread_id='$id'";


$mysqlquery = "SELECT $felder_forum_inhalt, $felder_profil FROM $tabellen WHERE $whereBedingungen";

	$result = mysql_query ($mysqlquery);
	$Ptot = mysql_num_rows($result);


	if (empty($disRow))$disRow = 10;
	$Pend = $Pdis * $disRow;
	$Pstart = $Pend - ($disRow-1);
	$Palle = ceil($Ptot / $disRow);
	if ( $Pdis > 1 ){
		$Pzur…k = "<a href='$url&diskussion=true&id=$id&sortby=$sortby&n=last'>\n";
		$Pzur…k .= "<img src='../images/links.gif' border='0' width='20' height='20' alt=''>\n";
		$Pzur…k .= "</a>\n";
	} else {
		$Pzur…k = "<img src='../images/links_na.gif' border='0' width='20' height='20' alt=''>\n";
	}
	if ( $Pdis < $Palle ) { 
		$Pvor = "<a href='$url&diskussion=true&id=$id&sortby=$sortby&n=next'>\n";
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
if (empty($sortby)) $sortby="s1";
if ($sortby == "standart" && $search != "all") $sortby = "s1";
if ($sortby == "standart" && $search == "all") $sortby = "s1";


	if 		(isset($sortby) && $sortby=="s0")		{	$SortBy="titel ASC"; 	$order[0] = 1;	}
	elseif	(isset($sortby) && $sortby=="s1")		{	$SortBy="datum DESC"; 	$order[1] = 1;	}
	elseif	(isset($sortby) && $sortby=="s2")		{	$SortBy="login  ASC";	$order[2] = 1;	}
	elseif	(isset($sortby) && $sortby=="s3")		{	$SortBy="email DESC";	$order[3] = 1;	}


//	
	elseif 	(isset($sortby) && $sortby=="s0-")		{	$SortBy="titel DESC"; 	}
	elseif 	(isset($sortby) && $sortby=="s1-")		{	$SortBy="datum ASC";		}
	elseif 	(isset($sortby) && $sortby=="s2-")		{	$SortBy="login  DESC";		}
	elseif	(isset($sortby) && $sortby=="s3-")		{	$SortBy="email ASC";			}

//
//
	$order[0] == 1 ? $sort0="s0-" : $sort0="s0";
	$order[1] == 1 ? $sort1="s1-" : $sort1="s1";
	$order[2] == 1 ? $sort2="s2-" : $sort2="s2";
	$order[3] == 1 ? $sort3="s3-" : $sort3="s3";

//




	echo "<table class='TABLEliste' width='100%' cellspacing='2'>\n";
	echo "<tr>\n";
	echo "<th class='THnr' nowrap>Nr. <font size='1'>($Ptot)</font></th>\n";
	echo "<th class='THtitel'>\n";
	echo "	<a class='Atitel' href='$url&sortby=$sort0'\n";	?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Diskussion');return document.returnValue"><?php echo"Titel</a>";
	echo "</th>\n";

	echo "<th class='THnr'>\n";
	echo "	<a class='Atitel' href='$url&sortby=$sort1'\n";	?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Datum');return document.returnValue">Datum</a><?php
	echo "</th>\n";
		
	echo "<th class='THnr'>\n";
	echo "	<a class='Atitel' href='$url&sortby=$sort2'\n";	?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Author');return document.returnValue">Author</a><?php
	echo "</th>\n";
	
	echo "<th class='THdatum'>\n";
	echo "	<a class='Atitel' href='$url&sortby=$sort3'\n";	?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Email');return document.returnValue">Email</a><?php
	echo "</th>\n";
	
	echo "</tr>\n";

	$q = $Panfang;
	$q++;
	$i++;

//

$felder_forum_inhalt =	"id_inhalt, thread_id, profil_id, titel, datum";
$felder_profil		=	"id_profil, login, email";
$tabellen			=	"forum_inhalt AS A, profil AS B";
$whereBedingungen	=	"A.profil_id=B.id_profil AND A.thread_id='$id'";


$mysqlquery = "SELECT $felder_forum_inhalt, $felder_profil FROM $tabellen WHERE $whereBedingungen ORDER BY $SortBy";

$result = mysql_query ($mysqlquery);
  //echo $mysqlquery;
			$i=1;	
			while ($row = mysql_fetch_array($result)){
				if ( $i >= $Pstart && $i <= $Pend ){
					$datum = deStampDate($row["datum"]);
					$id_inhalt = $row["id_inhalt"];
					$titel = urldecode($row["titel"]);
					$JStitel = addslashes($titel);
					$login = $row["login"];
					$email = $row["email"];
					if (empty($titel)) $titel	= "&nbsp;";
					if (empty($text))  $text	= "&nbsp;";
					if ($gehalten == "01.01.1970") $gehalten = "&nbsp;";
					$url_entry = "$PHP_SELF?page=$page&Pdis=$Pdis&search=$search&id=$id&entry=true&id=$id&id_inhalt=$id_inhalt";
					echo "<tr>\n";
					echo "<td class='TDnr'>$i</td>\n";
					echo "	<td class='TDtitel'>\n";			
					echo "		<a href='$url_entry'";?> onMouseOut="FnormText()" onMouseOver="StatusMsg('<?php echo "Detaileintrag: $JStitel";?>');return document.returnValue"> <?php echo"$titel</a></td>\n";
					echo "	<td class='TDdatum'>$datum</td>\n";
					echo "	<td class='TDnr'>".$login."</td>\n";
					echo "	<td class='TDthema'>$email</td>\n";

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
