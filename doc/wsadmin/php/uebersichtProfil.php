<?php //uebersichtProfil.php


//Hier werden die Variablen gepr�ft


if (empty($request))$request	= "uebersicht";


if (empty($search))	$search 	= "all";


if (empty($disRow)) $disRow = 10;


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


	$all = mysql_query("SELECT * FROM $table"); 








	$Ptot = mysql_num_rows($all);


	mysql_free_result($all);


	


	


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


if (empty($sortby) || $sortby == "standart") $sortby="login";








	if 		(isset($sortby) && $sortby=="login")		{	$SortBy="login ASC";			$order[0] = 1;	}


	elseif	(isset($sortby) && $sortby=="email")		{	$SortBy="email DESC"; 			$order[1] = 1;	}


	elseif	(isset($sortby) && $sortby=="notification")	{	$SortBy="notification  ASC";	$order[2] = 1;	}


	elseif	(isset($sortby) && $sortby=="newsletter")	{	$SortBy="newsletter DESC";		$order[3] = 1;	}


	elseif	(isset($sortby) && $sortby=="thread")		{	$SortBy="anzahlThread DESC";	$order[4] = 1;	}


//	


	elseif 	(isset($sortby) && $sortby=="login-")		{	$SortBy="login DESC";			}


	elseif 	(isset($sortby) && $sortby=="email-")		{	$SortBy="email ASC";			}


	elseif 	(isset($sortby) && $sortby=="notification-"){	$SortBy="notification  DESC";	}


	elseif	(isset($sortby) && $sortby=="newsletter-")	{	$SortBy="newsletter ASC";		}


	elseif	(isset($sortby) && $sortby=="thread-")		{	$SortBy="anzahlThread ASC";		}


//


//


	if	($order[0]==1){$login="login-";					}	else 	{ $login="login";				}


	if	($order[1]==1){$email="email-";					} 	else 	{ $email="email";				}


	if	($order[2]==1){$notification="notification-";	} 	else 	{ $notification="notification";	}


	if	($order[3]==1){$newsletter="newsletter-";		} 	else 	{ $newsletter="newsletter";		}


	if	($order[4]==1){$thread="thread-";				}	else 	{ $thread="thread";				}


//


	echo "<table class='TABLEliste' width='100%' cellspacing='2'>\n";


	echo "<tr>\n";


	echo "<th class='THnr' nowrap>Nr. <font size='1'>($Ptot)</font></th>\n";


	


	echo "<th class='THtitel'>\n";


	echo "	<a class='Atitel' href='$url&sortby=$login'\n";	?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Login');return document.returnValue">Login</a><?php


	echo "</th>\n";


	


	echo "<th class='THzahl'>&nbsp;Diskussionen</th>\n";


	


	echo "<th class='THzahl'>&nbsp;Antworten</th>\n";


	


	echo "<th class='THzahl'>&nbsp;Downloads</th>\n";


	


	echo "<th class='THemail'>\n";


	echo "	<a class='Atitel' href='$url&sortby=$email'\n";	?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Email');return document.returnValue">Email</a><?php


	echo "</th>\n";


	


	echo "<th id='notification' class='THnotification'>\n";


	echo "<a class='Atitel' href='$url&sortby=$notification' 	\n";?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Benachrichtigung');return document.returnValue">&nbsp;Benachrichtigung</a></th><?php


	


	echo "<th class='THbereich'>\n";


	echo "	<a class='Atitel' href='$url&sortby=$newsletter'	\n";?>	onMouseOut="FnormText()" onMouseOver="StatusMsg('Sortieren nach Newsletter');return document.returnValue">&nbsp;Newsletter</a></th><?php





	echo "</tr>\n";





	$q = $Panfang;


	$q++;


	$i++;





//


		$result_thread = mysql_query ("SELECT id_profil, login, email, notification, newsletter, downloads, count(profil_id_thread) AS anzahlThread FROM profil AS A LEFT OUTER JOIN forum_thread AS B ON A.id_profil=B.profil_id_thread GROUP BY A.id_profil ORDER BY $SortBy");


		$result_inhalt = mysql_query ("SELECT id_profil, login, email, notification, newsletter, downloads, count(profil_id) AS anzahlPost FROM profil AS A LEFT OUTER JOIN forum_inhalt AS B ON A.id_profil=B.profil_id GROUP BY A.id_profil ORDER BY $SortBy");


		


			$ok = "<img class='IMGok' src='../images/OK.gif' alt=''>";


			$i=1;	


			while ($row_thread = mysql_fetch_array($result_thread)){


				if ( $i >= $Pstart && $i <= $Pend ){


					$row_inhalt = mysql_fetch_array($result_inhalt);


					$row = array_merge($row_thread, $row_inhalt);


					$downloads = $row["downloads"];


					$id_profil = $row["id_profil"];


					$login = $row["login"];


					$JSlogin = addslashes($login);


					$email = $row["email"];


					$notification = $row["notification"];


					$newsletter = $row["newsletter"];


					$anzTread = $row["anzahlThread"];


					$anzPost = $row["anzahlPost"];





					$notification == 1	?	$notification = $ok	:	$notification = "&nbsp;";


					$newsletter == 1	?	$newsletter = $ok		:	$newsletter = "&nbsp;";





					if (empty($id_profil))  $id_profil	= "&nbsp;";


					if (empty($login)) 		$login	= "kein Name vorhanden";


					if (empty($email))  	$email	= "&nbsp;";


					if ($anzTread == 0 && $anzPost == 0){ $del = "ok"; } else { $del = ""; }





					echo "<tr>\n";


					echo "<td class='TDnr'>$i</td>\n";


					echo "<td class='TDtitel'>\n";


					echo "<a href='$url&change=true&id=$id_profil&del=$del'";?> onMouseOut="FnormText()" onMouseOver="StatusMsg('<?php echo "Detaileintrag: $JSlogin";?>');return document.returnValue"> <?php echo $login."</a></td>\n";


					echo "<td class='TDzahl'>$anzTread</td>\n";


					echo "<td class='TDzahl'>$anzPost</td>\n";


					echo "<td class='TDzahl'>$downloads</td>\n";


					echo "<td class='TDemail'>\n";


					echo "<a href='mailto:$email'";?> onMouseOut="FnormText()" onMouseOver="StatusMsg('<?php echo "Sende ein mail an $email";?>');return document.returnValue"> <?php echo $email."</a></td>\n";


					echo "<td class='TDnotification'>$notification</td>\n";


					echo "<td class='TDnotification'>$newsletter</td>\n";


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
