<?php //uebersichtForen.php


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


		$all = mysql_query("SELECT * FROM forum_thread"); 


	} else {


		$all = mysql_query("SELECT * FROM forum_thread WHERE thema_id=$search");


	}





	$Ptot = mysql_num_rows($all);


	mysql_free_result($all);


	


	if (empty($disRow)) $disRow = 10;


	$Pend = $P * $disRow;


	$Pstart = $Pend - ($disRow-1);


	$Palle = ceil($Ptot / $disRow);


	if ( $P > 1 ){


		$Pzur…k = "<a href='$url&sortby=$sortby&n=last'>\n";


		$Pzur…k .= "<img src='../images/links.gif' border='0' width='20' height='20' alt=''>\n";


		$Pzur…k .= "</a>\n";


	} else {


		$Pzur…k = "<img src='../images/links_na.gif' border='0' width='20' height='20' alt=''>\n";


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








	if 		(isset($sortby) && $sortby=="Titel")		{	$SortBy="titel_thread ASC";	 $order[0] = 1;	}


	elseif	(isset($sortby) && $sortby=="datum")		{	$SortBy="datum_thread DESC"; $order[1] = 1;	}


	elseif	(isset($sortby) && $sortby=="Thema")		{	$SortBy="thema_id  ASC";	 $order[2] = 1;	}


	elseif	(isset($sortby) && $sortby=="Familie")		{	$SortBy="Familie DESC";		 $order[3] = 1;	}


	elseif	(isset($sortby) && $sortby=="Arbeit")	{	$SortBy="Arbeit DESC"; $order[4] = 1;	}


	elseif	(isset($sortby) && $sortby=="Gesundheit")	{	$SortBy="Gesundheit DESC";	 $order[5] = 1;	}


	elseif	(isset($sortby) && $sortby=="Erziehung")	{	$SortBy="Erziehung DESC";	 $order[6] = 1;	}


	elseif	(isset($sortby) && $sortby=="hits")			{	$SortBy="hits DESC";		 $order[7] = 1;	}





//	


	elseif 	(isset($sortby) && $sortby=="Titel-")		{	$SortBy="titel_thread DESC";		}


	elseif 	(isset($sortby) && $sortby=="datum-")		{	$SortBy="datum_thread ASC";		}


	elseif 	(isset($sortby) && $sortby=="Thema-")		{	$SortBy="thema_id  DESC";		}


	elseif	(isset($sortby) && $sortby=="Familie-")		{	$SortBy="Familie ASC";		}


	elseif	(isset($sortby) && $sortby=="Arbeit-"){	$SortBy="Arbeit ASC";	}


	elseif	(isset($sortby) && $sortby=="Gesundheit-")	{	$SortBy="Gesundheit ASC";	}	


	elseif	(isset($sortby) && $sortby=="Erziehung-")	{	$SortBy="Erziehung ASC";	}


	elseif	(isset($sortby) && $sortby=="hits-")		{	$SortBy="hits ASC";	}


//


//


	$order[0] == 1 ? $Titel="Titel-"				: $Titel="Titel";


	$order[1] == 1 ? $datum="datum-"				: $datum="datum";


	$order[2] == 1 ? $Thema="Thema-"				: $Thema="Thema";


	$order[3] == 1 ? $Familie="Familie-"			: $Familie="Familie";


	$order[4] == 1 ? $Arbeit="Arbeit-"	: $Arbeit="Arbeit";


	$order[5] == 1 ? $Gesundheit="Gesundheit-"		: $Gesundheit="Gesundheit";


	$order[6] == 1 ? $Erziehung="Erziehung-"		: $Erziehung="Erziehung";


	$order[7] == 1 ? $hits = "hits-" 				: $hits = "hits";


//





	echo "<table class='TABLEliste' width='100%' cellspacing='2'>\n";


	echo "<tr>\n";


	echo "<th class='THnr' nowrap>Nr. <font size='1'>($Ptot)</font></th>\n";


	echo "<th class='THtitel'>\n";


	echo "	<a class='Atitel' href='$url&sortby=$Titel'\n";	?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Diskussion');return document.returnValue">Diskussion</a><?php


	echo "</th>\n";


	


	echo "<th class='THnr'>\n";


	echo "	<a class='Atitel' href='$url&sortby=$hits'\n";	?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Gelesen');return document.returnValue">Gelesen</a><?php


	echo "</th>\n";


	


	echo "<th class='THnr'>\n";


	echo "	<a class='Atitel' href='$url&sortby=$hits'\n";	?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Gelesen');return document.returnValue">Antworten</a><?php


	echo "</th>\n";


	


	echo "<th class='THdatum'>\n";


	echo "	<a class='Atitel' href='$url&sortby=$datum'\n";	?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Datum');return document.returnValue">Datum</a><?php


	echo "</th>\n";





	echo "<th class='THthema'>"; include("getmenu.php"); echo"</th>\n";


	echo "<th class='THbereich'>\n";


	echo "	<a class='Atitel' href='$url&sortby=$Familie' 	\n";?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Familie');return document.returnValue">F</a>	<?php


	echo "</th>\n";





	echo "<th class='THbereich'>\n";


	echo "	<a class='Atitel' href='$url&sortby=$Arbeit'\n";?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Arbeit');return document.returnValue">A</a></th><?php


	echo "<th class='THbereich'>\n";


	echo "<a class='Atitel' href='$url&sortby=$Gesundheit' 	\n";?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Gesundheit');return document.returnValue">G</a></th><?php


	echo "<th class='THbereich'>\n";


	echo "	<a class='Atitel' href='$url&sortby=$Erziehung'	\n";?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Erziehung');return document.returnValue">E</a></th><?php


	echo "</tr>\n";





	$q = $Panfang;


	$q++;


	$i++;








//


	$felderIn_forum_thread	=	"id_thread, titel_thread, Arbeit, Erziehung, Gesundheit, Familie, datum_thread, profil_id_thread, thema_id, hits";


	$felderIn_thema			=	"id_thema, thema";


	$felderIn_profil		=	"id_profil, login";


	$felderIn_forum_inhalt	=	"MAX(datum) AS datum, COUNT(thread_id) AS anzahlEintraege";


	$tabellenIn_ganglion	=	"forum_thread AS A, thema AS B, profil AS C, forum_inhalt AS D";


	$whereBedingungen		=	"A.thema_id=B.id_thema AND A.profil_id_thread=C.id_profil AND A.id_thread=D.thread_id";


	$gruppierung			=	"A.id_thread";


	if ($search=="all"){


		$precision="";


	}	else	{


		$precision="A.thema_id=$search AND";


	}





	


	$result = mysql_query ("SELECT $felderIn_forum_thread, $felderIn_thema, $felderIn_profil, $felderIn_forum_inhalt FROM $tabellenIn_ganglion WHERE $precision $whereBedingungen GROUP BY $gruppierung ORDER BY $SortBy");


  //echo"SELECT $felderIn_forum_thread, $felderIn_thema, $felderIn_profil, $felderIn_forum_inhalt FROM $tabellenIn_ganglion WHERE $precision $whereBedingungen $epoche GROUP BY $gruppierung ORDER BY $SortBy";


			$ok = "<img class='IMGok' src='../images/OK.gif' alt=''>";


			$i=1;	


			while ($row = mysql_fetch_array($result)){


				if ( $i >= $Pstart && $i <= $Pend ){


					$gehalten = deStampDate($row["datum_thread"]);


					$id = $row["id_thread"];


					$thema_id = $row["thema_id"];


					$Titel = $row["titel_thread"];


					$anzahlEintraege = $row["anzahlEintraege"];


					$statusTitel = addslashes($Titel);


					$thema = urldecode($row["thema"]);


					//$thema = htmlentities($thema);


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


					$url_diskussion = "$url&diskussion=true&id=$id";


					echo "<tr>\n";


					echo "<td class='TDnr'>$i</td>\n";


					echo "	<td class='TDtitel'>\n";			


					echo "		<a href='$url&change=true&id=$id&thema=$thema_id'";?> onMouseOut="FnormText()" onMouseOver="StatusMsg('<?php echo "Detaileintrag: $statusTitel";?>');return document.returnValue"> <?php echo"$Titel</a></td>\n";


					echo "	<td class='TDnr'>".$row["hits"]."</td>\n";


					echo "	<td class='TDnr'><a href='$url_diskussion'";?> onMouseOut="FnormText()" onMouseOver="StatusMsg('<?php echo "Detaileintrag: $statusTitel";?>');return document.returnValue"> <?php echo"$anzahlEintraege</a></td>\n";


					echo "	<td class='TDdatum'>$gehalten</td>\n";


					echo "	<td class='TDthema'>$thema</td>\n";


					echo "	<td class='TDbereich'>$fam</td>\n";


					echo "	<td class='TDbereich'>$arb</td>\n";


					echo "	<td class='TDbereich'>$ges</td>\n";


					echo "	<td class='TDbereich'>$erz</td>\n";


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
