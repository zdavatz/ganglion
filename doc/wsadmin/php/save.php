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

if (!isset($change)) {
	$change = '';
}
if (!isset($delete)) {
	$delete = '';
}
if (!isset($pdfdelete)) {
	$pdfdelete = '';
}
if (!isset($dayend)) {
	$dayend = '';
}
if (!isset($monthend)) {
	$monthend = '';
}
if (!isset($yearend)) {
	$yearend = '';
}
if (!isset($datum)) {
	$datum = '';
}

// set mysql-encoding
mysqli_query($conn1, "SET NAMES 'utf8'"); mysqli_query($conn1, "SET CHARACTER SET utf8"); 

//hier werden die daten codiert
if ($page == "themen"){
	$Thema = htmlflashen($Thema);
}
//neu
if ($page == "themen" && $new == "true"){
	$mysql = "thema, datumchange";
	$form = "'$Thema', '$datum'";

	//echo "$Thema, $datumchange";

	mysqli_query($conn1, "INSERT INTO thema ($mysql) VALUES ($form)");

	@header("Location: admin.php?page=$page&search=$search");
}

//aendern

if ($page == "themen" && $change == "true"){

//	echo"'$idThema','$Thema', '$datum'";

	$query = "UPDATE thema SET thema='$Thema', datumchange='$datum' WHERE id_thema=$idThema";
	//echo $query;

	mysqli_query($conn1, $query);

	

	@header("Location: admin.php?page=$page&search=$search");

}

//loeschen

if ($page == "themen" && $delete == "true"){

	mysqli_query($conn1, "DELETE FROM thema WHERE id_thema = '$idThema'");

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
		$time = mktime(intval($hour), intval($minute));
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
	$placeholders = "?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?";

	$sql = "INSERT INTO vortrag ($felder_mysql) VALUES ($placeholders)";
	$stmt = mysqli_prepare($conn1, $sql);

	$google_video_hours = isset($google_video_hours) ? $google_video_hours : '';
	$google_video_minutes = isset($google_video_minutes) ? $google_video_minutes : '';
	$google_video_seconds = isset($google_video_seconds) ? $google_video_seconds : '';
	$google_video_size = $google_video_hours.":".$google_video_minutes.":".$google_video_seconds;
	$Titel = isset($Titel) ? $Titel : '';
	$Zusammenfassung = isset($Zusammenfassung) ? $Zusammenfassung : '';
	$Zielpublikum = isset($Zielpublikum) ? $Zielpublikum : '';
	$gehalten = isset($gehalten) ? $gehalten : '';
	$time = intval($time ?: '0');
	$location = isset($location) ? $location : '';
	$file_name = isset($file_name) ? $file_name : '';
	$audiofile_name = isset($audiofile_name) ? $audiofile_name : '';
	$audiofile_size = intval($audiofile_size ?: '0');
	$google_video_url = isset($google_video_url) ? $google_video_url : '';
	$google_video_size = isset($google_video_size) ? $google_video_size : '';
	$Arbeit = intval(isset($Arbeit) ? $Arbeit : '0');
	$Erziehung = intval(isset($Erziehung) ? $Erziehung : '0');
	$Gesundheit = intval(isset($Gesundheit) ? $Gesundheit : '0');
	$Familie = intval(isset($Familie) ? $Familie : '0');
	$searchnew = intval($searchnew ?: '0');
	$datumchange = isset($datumchange) ? $datumchange : '';
	mysqli_stmt_bind_param($stmt,
		'ssssisssissiiiiis',
		$Titel,
		$Zusammenfassung,
		$Zielpublikum,
		$gehalten,
		$time,
		$location,
		$file_name,
		$audiofile_name,
		$audiofile_size,
		$google_video_url,
		$google_video_size,
		$Arbeit,
		$Erziehung,
		$Gesundheit,
		$Familie,
		$searchnew,
		$datumchange
	);

	mysqli_stmt_execute($stmt);
//echo nl2br($query);

echo mysqli_error($conn1);

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
	mysqli_query($conn1, $query);

 	if($audiofile_name != '') {
 		system('ruby /var/www/ganglion.ch/create_xml_from_db.rb');
 	}

	header("Location: admin.php?page=$page&search=$searchnew");
}

//loeschen

if ($page == "vortrag" && $delete == "true"){

	$delfile = "../../pdf/$oldfile";

	mysqli_query($conn1, "DELETE FROM vortrag WHERE id = '$id'");

	@unlink($delfile);
		
 	system('ruby /var/www/ganglion.ch/create_xml_from_db.rb');

	@header("Location: admin.php?page=$page&search=$search");

}

//Pdf L?schen
if ($page == "vortrag" && $pdfdelete == "true"){

	mysqli_query($conn1, "UPDATE vortrag SET pdf = '' WHERE id = '$id'");
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



	mysqli_query($conn1, "INSERT INTO links ($felder_mysql) VALUES ($felder_form)");

	@header("Location: admin.php?page=$page&search=$searchnew");

}

//aendern

if ($page == "links" && $change == "true"){

	$felder_mysql = "id_links, url, text, datum, Arbeit, Erziehung, Gesundheit, Familie, thema_id";

	$felder_form = "'$id','$url', '$beschreibung', '$datum','$Arbeit','$Erziehung','$Gesundheit', '$Familie', '$searchnew'";

	mysqli_query($conn1, "REPLACE INTO links ($felder_mysql) VALUES ($felder_form)");



	@header("Location: admin.php?page=$page&search=$searchnew");

}

//loeschen

if ($page == "links" && $delete == "true"){

	mysqli_query($conn1, "DELETE FROM links WHERE id_links = '$id'");

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
	mysqli_query($conn1, $query);
	@header("Location: admin.php?page=$page&search=$search");
}
//aendern
if ($page == "kurse" && $change == "true"){
	$form = "'$id_kurse','$titel_kurse','$kursziele_kurse','$ort_kurse','$kosten_kurse','$Arbeit','$Erziehung','$Gesundheit','$Familie','$searchnew','$datum_kurse','$beginn_kurse','$ende_kurse','$daten_kurse','$leitung_kurse','$platz_kurse','$teilnehmer_kurse','$kurs_art'";
	$query = "REPLACE INTO kurse VALUES ($form)";
	//echo $query;
	mysqli_query($conn1, $query);
	@header("Location: admin.php?page=$page&search=$search");
}
//loeschen
if ($page == "kurse" && $delete == "true"){
	mysqli_query($conn1, "DELETE FROM kurse WHERE id_kurse = '$id_kurse'");
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
	mysqli_query($conn1, $sql);
//	echo nl2br($query);
//	echo mysqli_error($conn1);
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
			mysqli_query($conn1, $query);
			header("Location: admin.php?page=$page&search=$searchnew");
	}

//loeschen
if ($page == "artikel" && $delete == "true"){
	$delfile = "../../pdf/$oldfile";
	mysqli_query($conn1, "DELETE FROM artikel WHERE id_artikel = '$id_artikel'");
	@unlink($delfile);
	@header("Location: admin.php?page=$page&search=$searchnew");
}
//Artikel pdf l?schen
if ($page == "artikel" && $pdfdelete == "true"){

	mysqli_query($conn1, "UPDATE artikel SET pdf = '' WHERE id = '$id_artikel'");
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
	mysqli_query($conn1, $query);
	@header("Location: admin.php?page=$page&search=$search");
}
//aendern
if ($page == "text" && $change == "true"){
	$form = "'$id_text','$bereich_text','$inhalt_text','$datum_text'";
	$query = "REPLACE INTO text VALUES ($form)";
	//echo $query;
	mysqli_query($conn1, $query);
	@header("Location: admin.php?page=$page&search=$search");
}
//loesche
if ($page == "text" && $delete == "true"){
	mysqli_query($conn1, "DELETE FROM text WHERE id_text = '$id_text'");
	@header("Location: admin.php?page=$page&search=$search");
}
?>
