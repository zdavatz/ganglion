<?php //uebersichtThemen.php
//Hier werden die Variablen gepr?ft
if (empty($request))$request= "uebersicht";
if (empty($search))$search = "all";
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

<!--<tr>
<td >
<form name="newButton" method="post"  action="save.php">
	<input type="button" name="send" value="neues Thema" onClick="closeAll();MM_showHideLayers('newthema','','show');">
</form>
</td>-->
<?php
//
if (empty($Z)) $Z = 0;
if (empty($P)) $P = 1;
//
//
//Paging-Funktion
$sortby = "";
//
if (isset($n) && $n=="next") {$P++;}
if (isset($n) && $n=="last") {$P--;}
//
$url = "$PHP_SELF?$nocache&page=$page&P=$P&search=$search";
//
$Ptot=0;
$all=0;
//
$result = mysql_query("SELECT * FROM thema");
$Ptot = mysql_num_rows($result);
mysql_free_result($result);
//if (empty($disRow))
$disRow = 20;
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
<td>
<table class='TABLEpaging'  align="right">
<tr>
<?php 
echo "<td class='TDvon2'>Seite $P von $Palle</td>\n";
echo "<td class='TDrechtslinks'>\n$Pzurueck</td>\n"; 
echo "<td class='TDrechtslinks'>\n$Pvor</td>\n"; 
?>
</tr>
</table>
</td>
</tr>
<tr> 
<td class='TDSiteTitel' colspan="2"> <?php
//sortieren
//
//
if (empty($sortby)) $sortby="Thema";
if ($sortby == "standart" && $search != "all") $sortby = "Thema";
if ($sortby == "standart" && $search == "all") $sortby = "Thema";
if (isset($sortby) && $sortby=="Thema"){$SortBy="thema ASC";$order[0] = 1;}
//
elseif (isset($sortby) && $sortby=="Thema-"){$SortBy="thema DESC";}
//
//
if($order[0]==1){$SortThema="Thema-";}else { $SortThema="Thema";}
//
$resultLinks = mysql_query("SELECT id_thema, thema, datumchange, count(B.thema_id) as anzahlLinks FROM thema AS A LEFT OUTER JOIN links AS B ON A.id_thema=B.thema_id GROUP BY id_thema ORDER BY $SortBy");
$resultVortrag = mysql_query("SELECT id_thema, thema, count(B.thema_id) as anzahlVortrag FROM thema AS A LEFT OUTER JOIN vortrag AS B ON A.id_thema=B.thema_id GROUP BY id_thema ORDER BY $SortBy");
$resultKurse = mysql_query("SELECT id_thema, thema, count(B.thema_id) as anzahlKurse FROM thema AS A LEFT OUTER JOIN kurse AS B ON A.id_thema=B.thema_id GROUP BY id_thema ORDER BY $SortBy");
$i=1;
echo "<table class='TABLEliste' width='100%' cellspacing='2'>\n";
echo "<tr>\n";
echo "<th class='THnr' nowrap>Nr. <font size='1'>($Ptot)</font></th>\n";
echo "<th class='THtitel' >\n";
echo "<a class='Atitel' href='$url&sortby=$SortThema'\n";?>
onMouseOut="FnormText()" 
onMouseOver="StatusMsg('Sortieren nach Thema');return document.returnValue">Thema</a><?php
echo "</th>\n";
echo "<th  class='THtrash'>&nbsp;</th>\n";
echo "<th class='THzahl'>Datum</th>\n";
echo "<th class='THbzahl'>Links</th>\n";
echo "<th class='THbzahl'>Vortr&auml;ge</th>\n";
echo "<th class='THbzahl'>Kurse</th>\n";
echo "<th class='THbzahl'>Foren</th>\n";
echo "</tr>\n";
$r=0;
while ($rowLinks = mysql_fetch_array($resultLinks)){
	$rowVortrag = mysql_fetch_array($resultVortrag);
	$rowKurse = mysql_fetch_array($resultKurse);
	$row = array_merge($rowLinks, $rowVortrag, $rowKurse);
	$datum = datum_ch($row["datumchange"]);
	if (empty($row["thema"])) $row["thema"] = "***";
	$thema = urldecode($row["thema"]);
	$JSthema = addslashes($thema);
	$idThema = $row["id_thema"];
if ( $i >= $Pstart && $i <= $Pend ){
echo "<tr>\n";
    echo "<td class='TDnr'>".$i."</td>\n";
    echo "<td class='TDtitel'>\n";  ?> 
	<a href="admin.php?page=themen&change=true&id=<?php echo $idThema; ?>"> 
	<?php echo $thema ?> 
	</a> 
	</td>
<?php
    echo "<td class='TDtrash'>\n";include("trash.php"); echo "</td>\n";
	echo "<td class='TDbereich'>".$datum."</td>\n";
    echo "<td class='TDzahl'>".$row["anzahlLinks"]."</td>\n";
    echo "<td class='TDzahl'>".$row["anzahlVortrag"]."</td>\n";
    echo "<td class='TDzahl'>".$row["anzahlKurse"]."</td>\n";
    echo "</tr>\n";
    $nummerThema[$r] = $row["id_thema"];
    $Thema[$r] = $thema;
    //echo $nummerThema[$r];
    $r++;
    }
$i++;
}
echo "</table></td></tr></table>\n";
//hier ist die schlaufe um die l?schen und ?ndern forms zu schreiben
$r = 0;
while ($r < 15){
include("changeThema.php");
$r++;
}
mysql_free_result($resultLinks);
mysql_free_result($resultVortrag);
mysql_free_result($resultKurse);
?> 
<div id="newthema"> 
<table class="TABLEthema" bgcolor="#f7a65a" cellpadding="0" cellspacing="0" border="0">
<tr> 
<td nowrap> 
<p>&nbsp;Bitte Thema eingeben.</p>
</td>
<td align="right" nowrap><a href="#" onClick="closeAll()"> <img name="end" border="0" src="../images/endx.gif" width="20" height="20" alt="schliessen"> 
</a> </td>
</tr>
<tr valign="bottom"> 
<td nowrap colspan="2"> 
<form method="post" action="save.php">
<input type="hidden" name="search" value="<?php print $search ?>">
<input type="hidden" name="datumchange" value="<?php $datumchange = date("Y-m-d"); echo $datumchange?>">
<input type="hidden" name="page" value="<?php print $page ?>">
<input type="hidden" name="new" value="true">
<table>
<tr>
<td>
<input class='INPUTtexts' type="text" name="Thema">
</td>
<td> 
<input type="submit" name="send2" value="Abschicken">
</td>
</tr>
</table>
</form>
</td>
</tr>
</table>
</div>

