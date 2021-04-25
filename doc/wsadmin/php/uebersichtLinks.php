<?php //uebersichtLinks.php


//Hier werden die Variablen gepr?ft


if (empty($request))$request	= "uebersicht";


if (empty($search))	$search 	= "all";


//


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


$i=0;


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


		$all = mysql_query("SELECT * FROM $table"); 


	} else {


		$all = mysql_query("SELECT * FROM $table WHERE thema_id=$search");


	}





	$Ptot = mysql_num_rows($all);


	mysql_free_result($all);


	


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


if (empty($sortby)) $sortby="url";


if (isset($sortby) && $sortby == "standart") $sortby = "url";








	if 		(isset($sortby) && $sortby=="url")			{	$SortBy="url ASC";			$order[0] = 1;	}


	elseif	(isset($sortby) && $sortby=="datum")		{	$SortBy="datum DESC"; 		$order[1] = 1;	}


	elseif	(isset($sortby) && $sortby=="Thema")		{	$SortBy="thema  ASC";		$order[2] = 1;	}


	elseif	(isset($sortby) && $sortby=="Familie")		{	$SortBy="Familie DESC";		$order[3] = 1;	}


	elseif	(isset($sortby) && $sortby=="Arbeit")	{	$SortBy="Arbeit DESC";$order[4] = 1;	}


	elseif	(isset($sortby) && $sortby=="Gesundheit")	{	$SortBy="Gesundheit DESC";	$order[5] = 1;	}


	elseif	(isset($sortby) && $sortby=="Erziehung")	{	$SortBy="Erziehung DESC";	$order[6] = 1;	}


//	


	elseif 	(isset($sortby) && $sortby=="url-")			{	$SortBy="url DESC";		}


	elseif 	(isset($sortby) && $sortby=="datum-")		{	$SortBy="datum ASC";		}


	elseif 	(isset($sortby) && $sortby=="Thema-")		{	$SortBy="thema  DESC";		}


	elseif	(isset($sortby) && $sortby=="Familie-")		{	$SortBy="Familie ASC";		}


	elseif	(isset($sortby) && $sortby=="Arbeit-"){	$SortBy="Arbeit ASC";	}


	elseif	(isset($sortby) && $sortby=="Gesundheit-")	{	$SortBy="Gesundheit ASC";	}	


	elseif	(isset($sortby) && $sortby=="Erziehung-")	{	$SortBy="Erziehung ASC";	}


//


//


	if	($order[0]==1){$lurl="url-";					}	else 	{ $lurl="url";					}


	if	($order[1]==1){$datum="datum-";					} 	else 	{ $datum="datum";				}


	if	($order[2]==1){$Thema="Thema-";					} 	else 	{ $Thema="Thema";				}


	if	($order[3]==1){$Familie="Familie-";				} 	else 	{ $Familie="Familie";			}


	if	($order[4]==1){$Arbeit="Arbeit-";	}	else 	{ $Arbeit="Arbeit";	}


	if	($order[5]==1){$Gesundheit="Gesundheit-";		} 	else 	{ $Gesundheit="Gesundheit";		}


	if	($order[6]==1){$Erziehung="Erziehung-";			}	else 	{ $Erziehung="Erziehung";		}


//








	echo "<table class='TABLEliste' width='100%' cellspacing='2'>\n";


	echo "<tr>\n";


	echo "<th class='THnr' nowrap>Nr. <font size='1'>($Ptot)</font></th>\n";


	echo "<th class='THtitel'>\n";


	echo "	<a class='Atitel' href='$url&sortby=$lurl'\n";	?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Url');return document.returnValue">Url</a><?php


	echo "</th>\n";


	echo "<th class='THdatum'>\n";


	echo "	<a class='Atitel' href='$url&sortby=$datum'\n";	?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Datum');return document.returnValue">Datum</a><?php


	echo "</th>\n";


	echo "<th class='THthema'>"; include("getmenu.php"); echo"</th>\n";


	echo "<th class='THbereich'>\n";


	echo "	<a class='Atitel' href='$url&sortby=$Familie' 	\n";?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Familie');return document.returnValue">F</a>	<?php


	echo "</th>\n";


	echo "<th class='Atitel' class='THbereich'>\n";


	echo "	<a class='Atitel' href='$url&sortby=$Arbeit'\n";?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Arbeit');return document.returnValue">A</a></th><?php


	echo "<th class='THbereich'>\n";


	echo "<a class='Atitel' href='$url&sortby=$Gesundheit' 	\n";?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Gesundheit');return document.returnValue">G</a></th><?php


	echo "<th class='THbereich'>\n";


	echo "	<a class='Atitel' href='$url&sortby=$Erziehung'	\n";?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Erziehung');return document.returnValue">E</a></th><?php


	echo "</tr>\n";


	$i++;








//


if (isset($request) && $request=="uebersicht"){





	if (isset($search) &&  $search == "all") {


			$result = mysql_query ("SELECT * FROM $table AS A, thema AS B WHERE A.thema_id=B.id_thema ORDER BY $SortBy");


			$isresult = mysql_num_rows($result);


	}


	else


	{


			$result = mysql_query ("SELECT * FROM $table AS A, thema AS B WHERE A.thema_id=B.id_thema AND thema_id=$search ORDER BY $SortBy");


			$isresult = mysql_num_rows($result);


			if ($isresult == 0)	$result = mysql_query ("SELECT * FROM $table AS A, thema AS B WHERE A.thema_id=B.id_thema ORDER BY $SortBy");


			





	}


				$ok = "<img id='ok' src='../images/OK.gif'>";


				$i=1;	


				$ok = "<img class='IMGok' src='../images/OK.gif' alt=''>";


			$i=1;	


			while ($row = mysql_fetch_array($result)){


				if ( $i >= $Pstart && $i <= $Pend ){


					$gehalten = datum_ch($row["datum"]);


					$id = $row["id_links"];


					$thema_id = $row["thema_id"];


					$Titel = urldecode($row["url"]);


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


					echo "<tr>\n";


					echo "<td class='TDnr'>$i</td>\n";


					echo "	<td class='TDtitel'>\n";


					echo "		<a href='$url&change=true&id=$id&thema=$thema_id'";?> onMouseOut="FnormText()" onMouseOver="StatusMsg('<?php echo "Detaileintrag: $statusTitel";?>');return document.returnValue"> <?php echo"$Titel</a></td>\n";


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





}


?>


</table>


</td>


</tr>


</table>
