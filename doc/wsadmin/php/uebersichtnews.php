<?php //uebersichtnews.php


//Hier werden die Variablen gepr?ft


if (empty($request))$request	= "uebersicht";


if (empty($search))	$search 	= "all";


//


$i=0;


//der neuer eintrag buttom


$url_new = "$PHP_SELF?page=$page&Pdis=$Pdis&search=$search&new=true&id_news=$id_news";


?>


<tr>


<td class='TDSiteTitel'>


<table id='new' class ='TABLEnew' width="180" >


 <tr>


  <td>


   <form name="new" method="get"  action="admin.php">


	<input type="hidden" name="search" value="<?php print $search ?>">


	<input type="hidden" name="page" value="<?php print $page ?>">


	<input type="hidden" name="new" value="true">


	<input type="submit" name="send" value="Neuer Newsletter">


   </form>


  </td>


 </tr>


</table>


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


$url = "$PHP_SELF?$nocache&page=$page&Pdis=$Pdis&search=$search&news=true&id=$id";


//


$Ptot=0;


$all=0;	


$mysqlquery = "SELECT * FROM newsletter";





	$result = mysql_query ($mysqlquery);


	$Ptot = mysql_num_rows($result);








	if (empty($disRow))$disRow = 10;


	$Pend = $Pdis * $disRow;


	$Pstart = $Pend - ($disRow-1);


	$Palle = ceil($Ptot / $disRow);


	if ( $Pdis > 1 ){


		$Pzurueck = "<a href='$url&news=true&id=$id&sortby=$sortby&n=last'>\n";


		$Pzurueck .= "<img src='../images/links.gif' border='0' width='20' height='20' alt=''>\n";


		$Pzurueck .= "</a>\n";


	} else {


		$Pzurueck = "<img src='../images/links_na.gif' border='0' width='20' height='20' alt=''>\n";


	}


	if ( $Pdis < $Palle ) { 


		$Pvor = "<a href='$url&news=true&id=$id&sortby=$sortby&n=next'>\n";


		$Pvor .= "<img src='../images/rechts.gif' border='0' width='20' height='20' alt=''>\n";


		$Pvor .= "</a>\n";


	} else {


		$Pvor = "<img src='../images/rechts_na.gif' border='0' width='20' height='20' alt=''>\n";


	}


	if ($Palle == 0) $Palle = 1;





?>





<td class='TDSiteNav'>


<table class='TABLEpaging'  align="right">


<tr>


<?php 


	echo "	<td class='TDvon2'>Seite $Pdis von $Palle</td>\n";


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


if (empty($sortby)) $sortby="s1";


if ($sortby == "standart" && $search != "all") $sortby = "s1";


if ($sortby == "standart" && $search == "all") $sortby = "s1";





//SELECT id_news,titel_news,text_news,send_news,change_news from newsletter 


	if 		(isset($sortby) && $sortby=="s0")		{	$SortBy="titel_news ASC"; 	$order[0] = 1;	}


	elseif	(isset($sortby) && $sortby=="s1")		{	$SortBy="text_news ASC"; 	$order[1] = 1;	}


	elseif	(isset($sortby) && $sortby=="s2")		{	$SortBy="send_news  DESC";	$order[2] = 1;	}


	elseif	(isset($sortby) && $sortby=="s3")		{	$SortBy="change_news DESC";	$order[3] = 1;	}








//	


	elseif 	(isset($sortby) && $sortby=="s0-")		{	$SortBy="titel_news DESC"; 	}


	elseif 	(isset($sortby) && $sortby=="s1-")		{	$SortBy="text_news DESC";		}


	elseif 	(isset($sortby) && $sortby=="s2-")		{	$SortBy="send_news  ASC";		}


	elseif	(isset($sortby) && $sortby=="s3-")		{	$SortBy="change_news ASC";			}





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


	echo "	<a class='Atitel' href='$url&sortby=$sort0'\n";	?>><?php echo"Titel</a>";


	echo "</th>\n";





	echo "<th class='THnr'>\n";


	echo "	<a class='Atitel' href='$url&sortby=$sort1'\n";	?>>Text</a><?php


	echo "</th>\n";


	


	echo "<th class='THnr'>Absenden</th>\n";


		


	echo "<th class='THnr'>\n";


	echo "	<a class='Atitel' href='$url&sortby=$sort2'\n";	?>>Gesendet</a><?php


	echo "</th>\n";


	


	echo "<th class='THdatum'>\n";


	echo "	<a class='Atitel' href='$url&sortby=$sort3'\n";	?>>Datum</a><?php


	echo "</th>\n";


	


	echo "</tr>\n";

	$i++;





//





$mysqlquery = "SELECT * FROM newsletter ORDER BY $SortBy";





$result = mysql_query ($mysqlquery);


  //echo $mysqlquery;


  $img_brief = "<img src=\"../images/brief.jpg\" width=\"17\" height=\"12\" alt=\"absenden\">"; 


			$i=1;	


			while ($row = mysql_fetch_array($result)){


				if ( $i >= $Pstart && $i <= $Pend ){


					$change_news = deStampDate($row["change_news"]);


					$send_news = deStampDate($row["send_news"]);


					$id_news = $row["id_news"];


					$titel_news = htmlflashde($row["titel_news"]);


					$JStitel = addslashes($titel_news);


					$text_news = htmlflashde($row["text_news"]);


					$text_news = firstchar($text_news,100);


					if (empty($titel_news)) $titel_news	= "&nbsp;";


					if (empty($text_news))  $text_news	= "&nbsp;";


					if ($change_news == "01.01.1970") $change_news = "&nbsp;";


					if ($send_news == "01.01.1970") $send_news = "Nie";


					$url_entry = "$PHP_SELF?page=$page&Pdis=$Pdis&search=$search&change=true&id_news=$id_news";


					echo "<tr>\n";


					echo "<td class='TDnr'>$i</td>\n";


					echo "	<td class='TDtitel'><a href='$url_entry' $statusText>$titel_news</a></td>\n";


					echo "	<td class='TDtitel'><a href='$url_entry' $statusText>".$text_news."</a></td>\n";


					echo "	<td class='TDzahl'><a href='#' onClick=\"popSendNewsletter('$id_news')\">".$img_brief ."</a></td>\n";


					echo "	<td class='TDdatum'>".$send_news."</td>\n";


					echo "	<td class='TDdatum'>".$change_news."</td>\n";





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
