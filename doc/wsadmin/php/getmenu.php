<?php //getmenu.php

if ($new == "true" || $change == "true"){
	$result = mysql_query ("SELECT * FROM thema ORDER BY thema ASC");
	$i=0;
	$lastThema="";
?>

		<input type="hidden" name="page" value="<?php echo $page ?>">
		<input type="hidden" name="sortby" value="standart">
		<select name="searchnew" size="1">
<?php
	if ($new == "true"){
		echo "<option value='1' selected>Bitte w&auml;hlen...</option>\n";
		$thema = "";
	}
	$thema_id = $thema;
	while ($row = mysql_fetch_array($result)){
	 		$idWWW = $row["id_thema"];
	 		$thema = urldecode($row["thema"]);
	 		$select = "";
	 		if ($idWWW == $thema_id) $select = "selected";
	 		echo "<option value='$idWWW' $select>$thema</option>\n";
		  	$i++;
	}
	echo "</select>\n";

} 
else 
{
	if(!isset($table)) $table = "vortrag";
	$result = mysql_query ("SELECT id_thema, thema, thema_id FROM thema AS A, $table AS B WHERE A.id_thema=B.thema_id GROUP BY id_thema ORDER BY thema ASC");
	$lastThema="";
?>
<form method="get" action="admin.php" name="themen">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="sortby" value="standart">
<input type="hidden" name="searchterm" value="">
<select name="search" size="1" onChange=themen.submit() onMouseOut="" onMouseOver="">		
<?php
if ($search == "all"){ $select = "selected"; }
	echo"<option value='all' $select>alle Themen</option>";
	
	while ($row = mysql_fetch_array($result)){
	 		$id = $row["id_thema"];
	 		$thema = urldecode($row["thema"]);
	 		$select = "";
	 		if ($id == $search){ $select = "selected"; }
	 			echo "<option value='$id' $select>$thema</option>\n";
			$lastThema=$row["thema"];
	}
	echo "</select>\n";
	echo "</form>\n";
}
mysql_free_result($result);
?>
