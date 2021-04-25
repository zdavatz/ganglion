<?php //save.php
include("function.php");
include("property.php");

//error_reporting(E_ALL);

// Emulate register_globals on
if (!ini_get('register_globals')) {
    $superglobals = array($_SERVER, $_ENV,
        $_FILES, $_COOKIE, $_POST, $_GET);
    if (isset($_SESSION)) {
        array_unshift($superglobals, $_SESSION);
    }
    foreach ($superglobals as $superglobal) {
        extract($superglobal, EXTR_SKIP);
    }
}

// set mysql-encoding
mysql_query("SET NAMES 'utf8'"); mysql_query("SET CHARACTER SET utf8"); 

//hier werden die daten codiert
if ($page == "themen"){
	$Thema = htmlflashen($Thema);
}
//neu
if ($page == "themen" && $new == "true"){
	$mysql = "thema, datumchange";
	$form = "'$Thema', '$datum'";

	//echo "$Thema, $datumchange";

	mysql_query("INSERT INTO thema ($mysql) VALUES ($form)");

	@header("Location: admin.php?page=$page&search=$search");
}

//aendern

if ($page == "themen" && $change == "true"){

//	echo"'$idThema','$Thema', '$datum'";

	$query = "UPDATE thema SET thema='$Thema', datumchange='$datum' WHERE id_thema=$idThema";
	//echo $query;

	mysql_query($query);

	

	@header("Location: admin.php?page=$page&search=$search");

}

//loeschen

if ($page == "themen" && $delete == "true"){

	mysql_query("DELETE FROM thema WHERE id_thema = '$idThema'");

	@header("Location: admin.php?page=$page&search=$search");

}

//

//hier werden die vortraege gespeichert

//

//hier werden die daten codiert

if ($page == "vortrag"){

	$Zusammenfassung = htmlflashen($Zusammenfassung);

	$Zielpublikum = htmlflashen($Zielpublikum);
	
	$location = htmlflashen($location);
	
	if($hour == 'notime')
	{
		$time = -1;
	}
	else
	{
		if($minute == 'notime') $minute = 0;
		$time = mktime($hour, $minute);
	}
}

//neu

if ($page == "vortrag" && $new == "true"){

	$datum = "$day.$month.$year";
	

	$gehalten = input2date($datum);

// with php 5.6 this has to be before the sql query otherwiese
  // the pdf will not be shown/found 
  if( $_FILES['file']['name'] != "" ) {
    $file_name=$_FILES['file']['name'];
    $pathto="../../pdf/".$file_name;
    move_uploaded_file( $_FILES['file']['tmp_name'],$pathto) or die( "Could not copy file!");
}
//now comes the query
	$felder_mysql = "Titel, Zusammenfassung, Zielpublikum, gehalten, zeit, location, pdf, audiofile, audiofile_size, google_video_url, google_video_size, Arbeit, Erziehung, Gesundheit, Familie, thema_id, datumchange";

	$google_video_size = $google_video_hours.":".$google_video_minutes.":".$google_video_seconds;
	$felder_form = "'$Titel', '$Zusammenfassung', '$Zielpublikum', '$gehalten', '$time', '$location', '$file_name', '$audiofile_name', '$audiofile_size', '$google_video_url', '$google_video_size', '$Arbeit', '$Erziehung', '$Gesundheit', '$Familie', '$searchnew', '$datumchange'";


	$sql = "INSERT INTO vortrag ($felder_mysql) VALUES ($felder_form)";
	mysql_query($sql);
//echo nl2br($query);

echo mysql_error();

	if($audiofile_name != '') {
		system('ruby /var/www/ganglion.ch/create_xml_from_db.rb');
	}

	@header("Location: admin.php?page=$page&search=$searchnew");

}

//aendern

if ($page == "vortrag" && $change == "true"){
	$audiofile_size = round(str_replace(" ", "", $audiofile_size));
	$google_video_size = round(str_replace(" ", "", $google_video_size));
	$datum = "$day.$month.$year";
	$gehalten = input2date($datum);

	$google_video_size = $google_video_hours.":".$google_video_minutes.":".$google_video_seconds;
	$fields = "	Titel='$Titel', 
				Zusammenfassung='$Zusammenfassung', 
				Zielpublikum='$Zielpublikum', 
				gehalten='$gehalten',
				zeit='$time', 
				location='$location', 
				audiofile='$audiofile_name',
				audiofile_size='$audiofile_size',
				google_video_url='$google_video_url',
				google_video_size='$google_video_size',
				Arbeit='$Arbeit', 
				Erziehung='$Erziehung', 
				Gesundheit='$Gesundheit', 
				Familie='$Familie', 
				thema_id='$searchnew', 
				datumchange='$datumchange'";

if( $_FILES['file']['name'] != "" ) {
    $file_name=$_FILES['file']['name'];
    $pathto="../../pdf/".$file_name;
    move_uploaded_file( $_FILES['file']['tmp_name'],$pathto) or die( "Could not copy file!");
}
else {
    $delfile = "../../pdf/$oldfile";
      if ($file_name != $oldfile)
    @unlink($delfile);
}

	$query="UPDATE vortrag SET $fields WHERE id='$id'";
	mysql_query($query);

 	if($audiofile_name != '') {
 		system('ruby /var/www/ganglion.ch/create_xml_from_db.rb');
 	}

	header("Location: admin.php?page=$page&search=$searchnew");
}

//loeschen

if ($page == "vortrag" && $delete == "true"){

	$delfile = "../../pdf/$oldfile";

	mysql_query("DELETE FROM vortrag WHERE id = '$id'");

	@unlink($delfile);
		
 	system('ruby /var/www/ganglion.ch/create_xml_from_db.rb');

	@header("Location: admin.php?page=$page&search=$search");

}

//Pdf L?schen
if ($page == "vortrag" && $pdfdelete == "true"){

	mysql_query("UPDATE vortrag SET pdf = '' WHERE id = '$id'");
	$delfile = "../../pdf/$oldfile";
	@unlink($delfile);
	@header("Location: admin.php?page=$page&search=$search");

}

//

//hier werden die Links behandelt

//

//hier werden die daten codiert

if ($page == "links"){

	$url = htmlflashen($url);

	$text = htmlflashen($text);

}

//neu

if ($page == "links" && $new == "true"){

	$felder_mysql = "url, text, datum, Arbeit, Erziehung, Gesundheit, Familie, thema_id";

	$felder_form = "'$url', '$beschreibung', '$datum','$Arbeit','$Erziehung','$Gesundheit', '$Familie', '$searchnew'";



	mysql_query("INSERT INTO links ($felder_mysql) VALUES ($felder_form)");

	@header("Location: admin.php?page=$page&search=$searchnew");

}

//aendern

if ($page == "links" && $change == "true"){

	$felder_mysql = "id_links, url, text, datum, Arbeit, Erziehung, Gesundheit, Familie, thema_id";

	$felder_form = "'$id','$url', '$beschreibung', '$datum','$Arbeit','$Erziehung','$Gesundheit', '$Familie', '$searchnew'";

	mysql_query("REPLACE INTO links ($felder_mysql) VALUES ($felder_form)");



	@header("Location: admin.php?page=$page&search=$searchnew");

}

//loeschen

if ($page == "links" && $delete == "true"){

	mysql_query("DELETE FROM links WHERE id_links = '$id'");

	@header("Location: admin.php?page=$page&search=$search");

}

//
//hier werden die kurse behandelt
//hier werden die daten codiert
if ($page == "kurse"){
	$titel_kurse = htmlflashen($titel_kurse);
	$kursziele_kurse = htmlflashen($kursziele_kurse);
	$ort_kurse = htmlflashen($ort_kurse);
	$kosten_kurse = htmlflashen($kosten_kurse);
	$leitung_kurse = htmlflashen($leitung_kurse);
	$daten_kurse = htmlflashen($daten_kurse);
}
//neu
$beginn_kurse = "$day.$month.$year";
$beginn_kurse = input2date($beginn_kurse);
$ende_kurse = "$dayend.$monthend.$yearend";
$ende_kurse = input2date($ende_kurse);
if ($page == "kurse" && $new == "true"){
	$mysql = "titel_kurse,kursziele_kurse,ort_kurse,kosten_kurse,Arbeit,Erziehung,Gesundheit,Familie,thema_id,datum_kurse,beginn_kurse,ende_kurse,daten_kurse,leitung_kurse,platz_kurse,teilnehmer_kurse,kurs_art";
	$form = "'$titel_kurse','$kursziele_kurse','$ort_kurse','$kosten_kurse','$Arbeit','$Erziehung','$Gesundheit','$Familie','$searchnew','$datum_kurse','$beginn_kurse','$ende_kurse','$daten_kurse','$leitung_kurse','$platz_kurse','$teilnehmer_kurse','$kurs_art'";
	$query = "INSERT INTO kurse ($mysql) VALUES ($form)";
	//echo $query;
	mysql_query($query);
	@header("Location: admin.php?page=$page&search=$search");
}
//aendern
if ($page == "kurse" && $change == "true"){
	$form = "'$id_kurse','$titel_kurse','$kursziele_kurse','$ort_kurse','$kosten_kurse','$Arbeit','$Erziehung','$Gesundheit','$Familie','$searchnew','$datum_kurse','$beginn_kurse','$ende_kurse','$daten_kurse','$leitung_kurse','$platz_kurse','$teilnehmer_kurse','$kurs_art'";
	$query = "REPLACE INTO kurse VALUES ($form)";
	//echo $query;
	mysql_query($query);
	@header("Location: admin.php?page=$page&search=$search");
}
//loeschen
if ($page == "kurse" && $delete == "true"){
	mysql_query("DELETE FROM kurse WHERE id_kurse = '$id_kurse'");
	@header("Location: admin.php?page=$page&search=$search");
}

//neu

// with php 5.6 this has to be before the sql query otherwiese
  // the pdf will not be shown/found
  if( $_FILES['file']['name'] != "" ) {
    $file_name=$_FILES['file']['name'];
    $pathto="../../pdf/".$file_name;
    move_uploaded_file( $_FILES['file']['tmp_name'],$pathto) or die( "Could not copy file!");
}
// then comes the query
if ($page == "artikel" && $new == "true"){
	$datum = "$day.$month.$year";
	$erschienen = input2date($datum);
	$felder_mysql = "titel_artikel,Zeitschrift,pdf,Arbeit,Erziehung,Gesundheit,Familie,thema_id,erschienen";
	$felder_form = "'$titel_artikel', '$Zeitschrift', '$file_name', '$Arbeit', '$Erziehung', '$Gesundheit', '$Familie', '$searchnew', '$erschienen'";
  
	$sql = "INSERT INTO artikel ($felder_mysql) VALUES ($felder_form)";
	mysql_query($sql);
//	echo nl2br($query);
//	echo mysql_error();
//exit;
	@header("Location: admin.php?page=$page&search=$search");

}
//aendern

if ($page == "artikel" && $change == "true"){
	$datum = "$day.$month.$year";
	$erschienen = input2date($datum);
	if ($file != ""){
		//print '->'.$file.'<-';
		$fields = "
			titel_artikel='$titel_artikel', 
			Zeitschrift='$Zeitschrift', 
			pdf='$file_name', 
			Arbeit='$Arbeit', 
			Erziehung='$Erziehung', 
			Gesundheit='$Gesundheit', 
			Familie='$Familie', 
			thema_id='$searchnew', 
			erschienen='$erschienen'";

// for the deleting part it can come after the sql query ;) no idea why.
  if( $_FILES['file']['name'] != "" ) {
    $file_name=$_FILES['file']['name'];
    $pathto="../../pdf/".$file_name;
    move_uploaded_file( $_FILES['file']['tmp_name'],$pathto) or die( "Could not copy file!");
    } else {
			$delfile = "../../pdf/$oldfile";
			if ($file_name != $oldfile) 
				@unlink($delfile);
		}
	} else {

			$fields = "	
				titel_artikel='$titel_artikel', 
				Zeitschrift='$Zeitschrift', 
				pdf='$oldfile', 
				Arbeit='$Arbeit', 
				Erziehung='$Erziehung', 
				Gesundheit='$Gesundheit', 
				Familie='$Familie', 
				thema_id='$searchnew', 
				erschienen='$erschienen'
			";

		}
			$query="UPDATE artikel SET $fields WHERE id_artikel='$id_artikel'";
			mysql_query($query);
			header("Location: admin.php?page=$page&search=$searchnew");
	}

//loeschen
if ($page == "artikel" && $delete == "true"){
	$delfile = "../../pdf/$oldfile";
	mysql_query("DELETE FROM artikel WHERE id_artikel = '$id_artikel'");
	@unlink($delfile);
	@header("Location: admin.php?page=$page&search=$searchnew");
}
//Artikel pdf l?schen
if ($page == "artikel" && $pdfdelete == "true"){

	mysql_query("UPDATE artikel SET pdf = '' WHERE id = '$id_artikel'");
	$delfile = "../../pdf/$oldfile";
	@unlink($delfile);
	@header("Location: admin.php?page=$page&search=$searchnew");

}

//
//hier werden die text behandelt
//hier werden die daten codiert
if ($page == "text"){
	$inhalt_text = htmlflashen($inhalt_text);
	//$bereich_text = htmlflashen($bereich_text);
}
//neu
if ($page == "text" && $new == "true"){
	$mysql = "bereich_text,inhalt_text,datum_text";
	$form = "'$bereich_text','$inhalt_text','$datum_text'";
	$query = "INSERT INTO text ($mysql) VALUES ($form)";
	//echo $query;
	mysql_query($query);
	@header("Location: admin.php?page=$page&search=$search");
}
//aendern
if ($page == "text" && $change == "true"){
	$form = "'$id_text','$bereich_text','$inhalt_text','$datum_text'";
	$query = "REPLACE INTO text VALUES ($form)";
	//echo $query;
	mysql_query($query);
	@header("Location: admin.php?page=$page&search=$search");
}
//loesche
if ($page == "text" && $delete == "true"){
	mysql_query("DELETE FROM text WHERE id_text = '$id_text'");
	@header("Location: admin.php?page=$page&search=$search");
}
?>
