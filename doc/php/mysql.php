<?php //mysql.php
session_name("ganglion");
session_start();
require("function.php");
//
//Bitte alle Werte hier eintragen!
//
$server	=	"localhost";		//MySQL-Server
$user	=	"******";		//MySQL-User
$pass	=	"******";		//MySQL-Passwort
$db		=	"ganglion";		//MySQL-Datenbank
//$table	=	"";		//MySQL-Tabelle
//
//
//Hier sind alle Felder der MySQL-Tabelle einzutragen.
//
$felder_mysql	=	"Titel, Zusammenfassung, Zielpublikum, gehalten, pdf, Arbeit, Erziehung, Gesundheit, Familie, thema_id";
//
//Hier sind alle dazugehoerigen Variablen vom html-file einzutragen.
//
@$felder_html	=	"'$Titel', '$Zusammenfassung', '$Zielpublikum','$gehalten', '$pdf', '$Arbeit', '$Erziehung', '$Gesundheit', '$Familie', '$thema_id'";
//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//
//
$conn1	=	mysql_connect($server, $user, $pass);
$select	=	mysql_select_db($db,$conn1);
mysql_query("SET NAMES 'utf8'"); mysql_query("SET CHARACTER SET utf8"); 
//
//
if(!isset($request)||$request!="print") include("head.php");
//
if (isset($command) && $command == "new"){
	$gehalten = input2date($datum);
	if ($file){
		$path = $DOCUMENT_ROOT .dirname($PHP_SELF). "/pdf/" .$file_name;
		if (!copy($file,$path)) {
		echo "Fehler - kann Datei nicht ablegen<BR>\n";
		exit;
		}
	}	
	mysql_query("INSERT INTO $table ($felder_mysql) VALUES ('$Titel', '$Zusammenfassung', '$Zielpublikum','$gehalten', '$file_name', '$Arbeit', '$Erziehung', '$Gesundheit', '$Familie', '$thema_id')");
}
//
if (isset($command) && $command=="getmenu"){
	$result = mysql_query ("SELECT id_thema, thema, Arbeit, Erziehung, Gesundheit, Familie, thema_id FROM thema AS A, $table AS B WHERE A.id_thema=B.thema_id AND $bereich=1 GROUP BY id_thema ");
		$i=0;
		$lastThema="";
			while ($row = mysql_fetch_array($result)){
				echo "<p>&menu_thema_id$i="; echo $row["id_thema"];echo "&</p>\n";
				echo "<p>&menu_thema$i="; echo stripslashes($row["thema"]);echo "&</p>\n";
				$i++;
				$lastThema=stripslashes($row["thema"]);
			}
		echo "<p>&menu_anzahl=$i&</p>\n";
		echo "<p>&eof=true&</p>\n";
		mysql_free_result($result);
}	
//
if (isset($command) && $command=="list"){ 
	include("list_vortrag.php");
}
//
if (isset($command) && $command=="del"){
	mysql_query ("DELETE FROM $table WHERE id = '$id'");
}
//
if (isset($command) && $command=="forum"){
	include("forum.php");
}
if (isset($command) && $command=="init"){
	$datum = date("j.n.Y");
	echo "&heute=$datum";
}

if (isset($command) && $command=="mailPage") {
	include("mailserver.php");
}

if (isset($command) && $command=="zeitfenster") {
	include("zeitfenster.php");
}
if (isset($command) && $command=="hotTopic") {
	include("hottopic.php");
}
if (isset($command) && $command=="links"){
	include("links.php");
}
if (isset($command) && $command=="kurse"){
	include("kurse.php");
}
if (isset($command) && $command=="angebot"){
	include("angebot.php");
}
if (isset($command) && $command=="navigate"){
	session_register("navigation_open");
	session_register("php_desired_action");
	session_register("php_desired_id");
	session_register("php_desired_page");
	session_register("last_page");
	$navigation_open=$offen;
	$last_page=$currentPage;
	if (!empty($desiredAction)) $php_desired_action=$desiredAction;
	if (!empty($desiredId)) $php_desired_id=$desiredId;
	if (!empty($desiredPage)) $php_desired_page=$desiredPage;
	//echo "input: $desiredPage<br>";
	//echo "session: $php_desired_page";
	echo "<p>&eof=true</p>\n";
}
if (isset($command) && $command=="kontaktmail"){
	include("kontaktmail.php");
}
//
mysql_close($conn1);
if(!isset($request)||$request!="print") include("end.php");
?>
