<?php
$trashgif = "<img  class='IMGtrash' src='../images/trash.gif' width='16' height='16' align='right' border='0' alt=''>\n";
$notraschgif = "<img  class='IMGtrash' src='../images/notrash.gif' width='16' height='16' align='right' border='0' alt=''>\n";
$datumchange = date("Y-m-d");
if ($row["anzahlLinks"] == 0 
	&& $row["anzahlVortrag"] == 0 
	&& $row["anzahlKurse"] == 0){


?> 
<a href="<?php echo "save.php?search=$search&datumchange=$datumchange&page=$page&idThema=$idThema&delete=true";?>"
	return document.returnValue">

<?php 	
	echo "$trashgif</a>\n"; 
}
else
{
	echo "$notraschgif\n";
}

?>
