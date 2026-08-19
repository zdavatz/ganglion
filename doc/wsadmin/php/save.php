<?php //save.php
include("function.php");
include("property.php");

//error_reporting(E_ALL);

// Validate uploaded file has an allowed extension
function validate_upload($filename) {
	$allowed_extensions = array('pdf', 'doc', 'docx', 'txt', 'jpg', 'jpeg', 'png', 'gif');
	$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
	if (!in_array($ext, $allowed_extensions)) {
		die("Upload rejected: file type '.$ext.' is not allowed.");
	}
}

// Read request parameters explicitly instead of emulating register_globals
$page = isset($_POST['page']) ? $_POST['page'] : '';
$new = isset($_POST['new']) ? $_POST['new'] : '';
$change = isset($_POST['change']) ? $_POST['change'] : '';
$delete = isset($_POST['delete']) ? $_POST['delete'] : '';
$pdfdelete = isset($_POST['pdfdelete']) ? $_POST['pdfdelete'] : '';
$search = isset($_POST['search']) ? $_POST['search'] : '';
$searchnew = isset($_POST['searchnew']) ? $_POST['searchnew'] : '';
$id = isset($_POST['id']) ? $_POST['id'] : '';
$oldfile = isset($_POST['oldfile']) ? $_POST['oldfile'] : '';

// Date fields
$day = isset($_POST['day']) ? $_POST['day'] : '';
$month = isset($_POST['month']) ? $_POST['month'] : '';
$year = isset($_POST['year']) ? $_POST['year'] : '';
$dayend = isset($_POST['dayend']) ? $_POST['dayend'] : '';
$monthend = isset($_POST['monthend']) ? $_POST['monthend'] : '';
$yearend = isset($_POST['yearend']) ? $_POST['yearend'] : '';
$datum = isset($_POST['datum']) ? $_POST['datum'] : '';
$datumchange = isset($_POST['datumchange']) ? $_POST['datumchange'] : '';

// Themen fields
$Thema = isset($_POST['Thema']) ? $_POST['Thema'] : '';
$idThema = isset($_POST['idThema']) ? $_POST['idThema'] : '';

// Vortrag fields
$Titel = isset($_POST['Titel']) ? $_POST['Titel'] : '';
$Zusammenfassung = isset($_POST['Zusammenfassung']) ? $_POST['Zusammenfassung'] : '';
$Zielpublikum = isset($_POST['Zielpublikum']) ? $_POST['Zielpublikum'] : '';
$location = isset($_POST['location']) ? $_POST['location'] : '';
$hour = isset($_POST['hour']) ? $_POST['hour'] : '';
$minute = isset($_POST['minute']) ? $_POST['minute'] : '';
$audiofile_name = isset($_POST['audiofile_name']) ? $_POST['audiofile_name'] : '';
$audiofile_size = isset($_POST['audiofile_size']) ? $_POST['audiofile_size'] : '';
$google_video_url = isset($_POST['google_video_url']) ? $_POST['google_video_url'] : '';
$google_video_hours = isset($_POST['google_video_hours']) ? $_POST['google_video_hours'] : '';
$google_video_minutes = isset($_POST['google_video_minutes']) ? $_POST['google_video_minutes'] : '';
$google_video_seconds = isset($_POST['google_video_seconds']) ? $_POST['google_video_seconds'] : '';

// Category fields
$Arbeit = isset($_POST['Arbeit']) ? $_POST['Arbeit'] : 0;
$Erziehung = isset($_POST['Erziehung']) ? $_POST['Erziehung'] : 0;
$Gesundheit = isset($_POST['Gesundheit']) ? $_POST['Gesundheit'] : 0;
$Familie = isset($_POST['Familie']) ? $_POST['Familie'] : 0;

// Links fields
$url = isset($_POST['url']) ? $_POST['url'] : '';
$text = isset($_POST['text']) ? $_POST['text'] : '';
$beschreibung = isset($_POST['beschreibung']) ? $_POST['beschreibung'] : '';

// Kurse fields
$id_kurse = isset($_POST['id_kurse']) ? $_POST['id_kurse'] : '';
$titel_kurse = isset($_POST['titel_kurse']) ? $_POST['titel_kurse'] : '';
$kursziele_kurse = isset($_POST['kursziele_kurse']) ? $_POST['kursziele_kurse'] : '';
$ort_kurse = isset($_POST['ort_kurse']) ? $_POST['ort_kurse'] : '';
$kosten_kurse = isset($_POST['kosten_kurse']) ? $_POST['kosten_kurse'] : '';
$leitung_kurse = isset($_POST['leitung_kurse']) ? $_POST['leitung_kurse'] : '';
$daten_kurse = isset($_POST['daten_kurse']) ? $_POST['daten_kurse'] : '';
$platz_kurse = isset($_POST['platz_kurse']) ? $_POST['platz_kurse'] : '';
$teilnehmer_kurse = isset($_POST['teilnehmer_kurse']) ? $_POST['teilnehmer_kurse'] : '';
$kurs_art = isset($_POST['kurs_art']) ? $_POST['kurs_art'] : '';
$datum_kurse = isset($_POST['datum_kurse']) ? $_POST['datum_kurse'] : '';

// Artikel fields
$titel_artikel = isset($_POST['titel_artikel']) ? $_POST['titel_artikel'] : '';
$Zeitschrift = isset($_POST['Zeitschrift']) ? $_POST['Zeitschrift'] : '';
$id_artikel = isset($_POST['id_artikel']) ? $_POST['id_artikel'] : '';
$file = isset($_POST['file']) ? $_POST['file'] : '';
$file_name = isset($_POST['file_name']) ? $_POST['file_name'] : '';

// Text fields
$id_text = isset($_POST['id_text']) ? $_POST['id_text'] : '';
$bereich_text = isset($_POST['bereich_text']) ? $_POST['bereich_text'] : '';
$inhalt_text = isset($_POST['inhalt_text']) ? $_POST['inhalt_text'] : '';
$datum_text = isset($_POST['datum_text']) ? $_POST['datum_text'] : '';

// set mysql-encoding
mysqli_query($conn1, "SET NAMES 'utf8'"); mysqli_query($conn1, "SET CHARACTER SET utf8"); 

//hier werden die daten codiert
if ($page == "themen"){
	$Thema = htmlflashen($Thema);
}
//neu
if ($page == "themen" && $new == "true"){
	$mysql = "thema, datumchange";
	$form = "'" . mysqli_real_escape_string($conn1,$Thema). "', '" . mysqli_real_escape_string($conn1,$datum). "'";

	//echo "$Thema, $datumchange";

	if (!mysqli_query($conn1, "INSERT INTO thema ($mysql) VALUES ($form)")) {
		die($conn1->error);
	}

	@header("Location: admin.php?page=$page&search=$search");
}

//aendern

if ($page == "themen" && $change == "true"){

//	echo"'$idThema','$Thema', '$datum'";

	$query = "UPDATE thema SET thema='" . mysqli_real_escape_string($conn1,$Thema) . "', datumchange='" . mysqli_real_escape_string($conn1,$datum) . "' WHERE id_thema='" . mysqli_real_escape_string($conn1,$idThema) . "'";
	//echo $query;

	if (!mysqli_query($conn1, $query)) {
		die($conn1->error);
	}

	

	@header("Location: admin.php?page=$page&search=$search");

}

//loeschen

if ($page == "themen" && $delete == "true"){

	if (!mysqli_query($conn1, "DELETE FROM thema WHERE id_thema = '" . mysqli_real_escape_string($conn1,$idThema) . "'")) {
		die($conn1->error);
	}

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
    $file_name = basename($_FILES['file']['name']);
    validate_upload($file_name);
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

	$error = mysqli_error($conn1);
	if ($error != "") {
		die($error);
	}

	if($audiofile_name != '') {
		system('ruby /var/www/ganglion.ch/create_xml_from_db.rb');
	}

	@header("Location: admin.php?page=$page&search=$searchnew");

}

//aendern

if ($page == "vortrag" && $change == "true"){
	$file_name=$_FILES['file']['name'];
	if ($file_name != "") {
		$file_name = basename($file_name);
		validate_upload($file_name);
		if (isset($oldfile) && $oldfile != "" && $file_name != $oldfile) {
			@unlink("../../pdf/" . basename($oldfile));
		}
		$pathto="../../pdf/" . $file_name;
		move_uploaded_file( $_FILES['file']['tmp_name'],$pathto) or die( "Could not copy file!");
	}

	$google_video_hours = isset($google_video_hours) ? $google_video_hours : '';
	$google_video_minutes = isset($google_video_minutes) ? $google_video_minutes : '';
	$google_video_seconds = isset($google_video_seconds) ? $google_video_seconds : '';
	$google_video_size = $google_video_hours.":".$google_video_minutes.":".$google_video_seconds;
	$Titel = isset($Titel) ? $Titel : '';
	$Zusammenfassung = isset($Zusammenfassung) ? $Zusammenfassung : '';
	$Zielpublikum = isset($Zielpublikum) ? $Zielpublikum : '';
	$time = intval($time ?: '0');
	$location = isset($location) ? $location : '';
	if ($file_name == '') {
		$file_name = $oldfile;
	}
	$audiofile_name = isset($audiofile_name) ? $audiofile_name : '';
	$audiofile_size = intval(str_replace(" ", "", $audiofile_size));
	$google_video_url = isset($google_video_url) ? $google_video_url : '';
	$google_video_size = isset($google_video_size) ? str_replace(" ", "", $google_video_size) : '';
	$Arbeit = intval(isset($Arbeit) ? $Arbeit : '0');
	$Erziehung = intval(isset($Erziehung) ? $Erziehung : '0');
	$Gesundheit = intval(isset($Gesundheit) ? $Gesundheit : '0');
	$Familie = intval(isset($Familie) ? $Familie : '0');
	$searchnew = intval($searchnew ?: '0');
	$datumchange = isset($datumchange) ? $datumchange : '';
	$datum = "$day.$month.$year";
	$gehalten = input2date($datum);

	$placeholders = "	Titel=?, 
				Zusammenfassung=?, 
				Zielpublikum=?, 
				gehalten=?,
				zeit=?, 
				location=?,
				pdf=?,
				audiofile=?,
				audiofile_size=?,
				google_video_url=?,
				google_video_size=?,
				Arbeit=?, 
				Erziehung=?, 
				Gesundheit=?, 
				Familie=?, 
				thema_id=?, 
				datumchange=?";
	
	$query="UPDATE vortrag SET $placeholders WHERE id=?";
	$stmt = mysqli_prepare($conn1, $query);
	$id_int = intval($id);
	mysqli_stmt_bind_param(
		$stmt,
		'ssssisssissiiiiisi',
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
		$datumchange,
		$id_int
	);
	if (!mysqli_stmt_execute($stmt)) {
		die($conn1->error);
	}

 	if($audiofile_name != '') {
 		system('ruby /var/www/ganglion.ch/create_xml_from_db.rb');
 	}

	header("Location: admin.php?page=$page&search=$searchnew");
}

//loeschen

if ($page == "vortrag" && $delete == "true"){

	$delfile = "../../pdf/" . basename($oldfile);

	if (!mysqli_query($conn1, "DELETE FROM vortrag WHERE id = '" . mysqli_real_escape_string($conn1,$id) . "'")) {
		die($conn1->error);
	}

	@unlink($delfile);
		
 	system('ruby /var/www/ganglion.ch/create_xml_from_db.rb');

	@header("Location: admin.php?page=$page&search=$search");

}

//Pdf L?schen
if ($page == "vortrag" && $pdfdelete == "true"){
	$stmt = mysqli_prepare($conn1, "UPDATE vortrag SET pdf = '' WHERE id = ?");
	$id_int = intval($id);
	mysqli_stmt_bind_param($stmt, 'i', $id_int);
	if (!mysqli_stmt_execute($stmt)) {
		die($conn1->error);
	}
	$delfile = "../../pdf/" . basename($oldfile);
	@unlink($delfile);
	@header("Location: admin.php?page=$page&search=$search");

}

//

//hier werden die Links behandelt

//

//hier werden die daten codiert

if ($page == "links"){
	$url = isset($url) ? $url : "";
	$text = isset($text) ? $text : "";

	$url = htmlflashen($url);

	$text = htmlflashen($text);

}

//neu

if ($page == "links" && $new == "true"){

	$felder_mysql = "url, text, datum, Arbeit, Erziehung, Gesundheit, Familie, thema_id";
	$placeholders = "?, ?, ?,?,?,?, ?, ?";

	$url = isset($url) ? $url : "";
	$beschreibung = isset($beschreibung) ? $beschreibung : "";
	$datum = isset($datum) ? $datum : "";
	$searchne = isset($searchne) ? $searchne : "";
	$Arbeit = isset($Arbeit) ? intval($Arbeit) : 0;
	$Erziehung = isset($Erziehung) ? intval($Erziehung) : 0;
	$Gesundheit = isset($Gesundheit) ? intval($Gesundheit) : 0;
	$Familie = isset($Familie) ? intval($Familie) : 0;

	$stmt = mysqli_prepare($conn1, "INSERT INTO links ($felder_mysql) VALUES ($placeholders)");
	mysqli_stmt_bind_param(
		$stmt,
		'sssiiiis',
		$url,
		$beschreibung,
		$datum,
		$Arbeit,
		$Erziehung,
		$Gesundheit,
		$Familie,
		$searchnew
	);
	if (!mysqli_stmt_execute($stmt)) {
		die($conn1->error);
	}

	@header("Location: admin.php?page=$page&search=$searchnew");

}

//aendern

if ($page == "links" && $change == "true"){

	$felder_mysql = "id_links, url, text, datum, Arbeit, Erziehung, Gesundheit, Familie, thema_id";
	$placeholders = "?,?,?,?,?,?,?,?,?";

	$stmt = mysqli_prepare($conn1, "REPLACE INTO links ($felder_mysql) VALUES ($placeholders)");

	$id = isset($id) ? $id : "";
	$url = isset($url) ? $url : "";
	$beschreibung = isset($beschreibung) ? $beschreibung : "";
	$datum = isset($datum) ? $datum : "";
	$Arbeit = isset($Arbeit) ? $Arbeit : 0;
	$Erziehung = isset($Erziehung) ? $Erziehung : 0;
	$Gesundheit = isset($Gesundheit) ? $Gesundheit : 0;
	$Familie = isset($Familie) ? $Familie : 0;
	$searchnew = isset($searchnew) ? $searchnew : "";

	mysqli_stmt_bind_param(
		$stmt,
		'ssssiiiis',
		$id,
		$url,
		$beschreibung,
		$datum,
		$Arbeit,
		$Erziehung,
		$Gesundheit,
		$Familie,
		$searchnew,
	);
	if (!mysqli_stmt_execute($stmt)) {
		die($conn1->error);
	}

	@header("Location: admin.php?page=$page&search=$searchnew");

}

//loeschen

if ($page == "links" && $delete == "true"){

	if (!mysqli_query($conn1, "DELETE FROM links WHERE id_links = '" . mysqli_real_escape_string($conn1,$id) . "'")) {
		die($conn1->error);
	}

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
if ($page == "kurse" && $new == "true") {

	$titel_kurse = isset($titel_kurse) ? $titel_kurse : "";
	$kursziele_kurse = isset($kursziele_kurse) ? $kursziele_kurse : "";
	$ort_kurse = isset($ort_kurse) ? $ort_kurse : "";
	$kosten_kurse = isset($kosten_kurse) ? $kosten_kurse : "";
	$Arbeit = isset($Arbeit) ? $Arbeit : 0;
	$Erziehung = isset($Erziehung) ? $Erziehung : 0;
	$Gesundheit = isset($Gesundheit) ? $Gesundheit : 0;
	$Familie = isset($Familie) ? $Familie : 0;
	$searchnew = isset($searchnew) ? $searchnew : 0;
	$datum_kurse = isset($datum_kurse) ? $datum_kurse : "";
	$beginn_kurse = isset($beginn_kurse) ? $beginn_kurse : "";
	$ende_kurse = isset($ende_kurse) ? $ende_kurse : "";
	$daten_kurse = isset($daten_kurse) ? $daten_kurse : "";
	$leitung_kurse = isset($leitung_kurse) ? $leitung_kurse : "";
	$platz_kurse = isset($platz_kurse) ? $platz_kurse : "";
	$teilnehmer_kurse = isset($teilnehmer_kurse) ? $teilnehmer_kurse : "";
	$kurs_art = isset($kurs_art) ? $kurs_art : "";

	$pdf_kurse = "";
	if ($_FILES['file']['name'] != "") {
		$pdf_kurse = basename($_FILES['file']['name']);
		validate_upload($pdf_kurse);
		$pathto = "../../html/pdf/" . $pdf_kurse;
		move_uploaded_file($_FILES['file']['tmp_name'], $pathto) or die("Could not copy file!");
	}

	$mysql = "titel_kurse,kursziele_kurse,ort_kurse,kosten_kurse,Arbeit,Erziehung,Gesundheit,Familie,thema_id,datum_kurse,beginn_kurse,ende_kurse,daten_kurse,leitung_kurse,platz_kurse,teilnehmer_kurse,kurs_art,pdf_kurse";
	$placeholders = "?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?";
	$query = "INSERT INTO kurse ($mysql) VALUES ($placeholders)";
	$stmt = mysqli_prepare($conn1, $query);
	mysqli_stmt_bind_param(
		$stmt,
		'ssssiiiiisssssssss',
		$titel_kurse,
		$kursziele_kurse,
		$ort_kurse,
		$kosten_kurse,
		$Arbeit,
		$Erziehung,
		$Gesundheit,
		$Familie,
		$searchnew,
		$datum_kurse,
		$beginn_kurse,
		$ende_kurse,
		$daten_kurse,
		$leitung_kurse,
		$platz_kurse,
		$teilnehmer_kurse,
		$kurs_art,
		$pdf_kurse,
	);
	if (!mysqli_stmt_execute($stmt)) {
		die($conn1->error);
	}

	@header("Location: admin.php?page=$page&search=$search");
}
//aendern
if ($page == "kurse" && $change == "true"){
	$Arbeit = isset($Arbeit) ? $Arbeit : 0;
	$Erziehung = isset($Erziehung) ? $Erziehung : 0;
	$Gesundheit = isset($Gesundheit) ? $Gesundheit : 0;
	$Familie = isset($Familie) ? $Familie : 0;

	$pdf_kurse = $oldfile;
	if ($_FILES['file']['name'] != "") {
		$pdf_kurse = basename($_FILES['file']['name']);
		validate_upload($pdf_kurse);
		if ($oldfile != "" && $pdf_kurse != basename($oldfile)) {
			@unlink("../../html/pdf/" . basename($oldfile));
		}
		$pathto = "../../html/pdf/" . $pdf_kurse;
		move_uploaded_file($_FILES['file']['tmp_name'], $pathto) or die("Could not copy file!");
	}

	$mysql = "id_kurse,titel_kurse,kursziele_kurse,ort_kurse,kosten_kurse,Arbeit,Erziehung,Gesundheit,Familie,thema_id,datum_kurse,beginn_kurse,ende_kurse,daten_kurse,leitung_kurse,platz_kurse,teilnehmer_kurse,kurs_art,pdf_kurse";
	$placeholders = "?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?";
	$stmt = mysqli_prepare($conn1, "REPLACE INTO kurse ($mysql) VALUES ($placeholders)");
	mysqli_stmt_bind_param(
		$stmt,
		'sssssiiiiisssssssss',
		$id_kurse,
		$titel_kurse,
		$kursziele_kurse,
		$ort_kurse,
		$kosten_kurse,
		$Arbeit,
		$Erziehung,
		$Gesundheit,
		$Familie,
		$searchnew,
		$datum_kurse,
		$beginn_kurse,
		$ende_kurse,
		$daten_kurse,
		$leitung_kurse,
		$platz_kurse,
		$teilnehmer_kurse,
		$kurs_art,
		$pdf_kurse
	);
	if (!mysqli_stmt_execute($stmt)) {
		die($conn1->error);
	}
	@header("Location: admin.php?page=$page&search=$search");
}
//loeschen
if ($page == "kurse" && $delete == "true"){
	$stmt = mysqli_prepare($conn1, "DELETE FROM kurse WHERE id_kurse = ?");
	mysqli_stmt_bind_param($stmt, 's', $id_kurse);
	if (!mysqli_stmt_execute($stmt)) {
		die($conn1->error);
	}
	if ($oldfile != "") {
		@unlink("../../html/pdf/" . basename($oldfile));
	}
	@header("Location: admin.php?page=$page&search=$search");
}

//Pdf loeschen
if ($page == "kurse" && $pdfdelete == "true"){
	$stmt = mysqli_prepare($conn1, "UPDATE kurse SET pdf_kurse = '' WHERE id_kurse = ?");
	mysqli_stmt_bind_param($stmt, 's', $id_kurse);
	if (!mysqli_stmt_execute($stmt)) {
		die($conn1->error);
	}
	if ($oldfile != "") {
		@unlink("../../html/pdf/" . basename($oldfile));
	}
	@header("Location: admin.php?page=$page&search=$search");
}

//neu

// then comes the query
if ($page == "artikel" && $new == "true"){
	// with php 5.6 this has to be before the sql query otherwiese
  // the pdf will not be shown/found
	try {
		if( $_FILES['file']['name'] != "" ) {
		    $file_name = basename($_FILES['file']['name']);
		    validate_upload($file_name);
		    $pathto="../../pdf/".$file_name;
		    move_uploaded_file( $_FILES['file']['tmp_name'],$pathto) or die( "Could not copy file!");
		}
	}
	catch (Exception $e) {
	}
	$datum = "$day.$month.$year";
	$erschienen = input2date($datum);
	$Arbeit = isset($Arbeit) ? $Arbeit : 0;
	$Erziehung = isset($Erziehung) ? $Erziehung : 0;
	$Gesundheit = isset($Gesundheit) ? $Gesundheit : 0;
	$Familie = isset($Familie) ? $Familie : 0;
	$felder_mysql = "titel_artikel,Zeitschrift,pdf,Arbeit,Erziehung,Gesundheit,Familie,thema_id,erschienen";
	$placeholders_artikel = "?,?,?,?,?,?,?,?,?";
	$stmt = mysqli_prepare($conn1, "INSERT INTO artikel ($felder_mysql) VALUES ($placeholders_artikel)");
	mysqli_stmt_bind_param(
		$stmt,
		'sssiiiiis',
		$titel_artikel,
		$Zeitschrift,
		$file_name,
		$Arbeit,
		$Erziehung,
		$Gesundheit,
		$Familie,
		$searchnew,
		$erschienen
	);
	if (!mysqli_stmt_execute($stmt)) {
		die($conn1->error);
	}
//	echo nl2br($query);
//	echo mysqli_error($conn1);
//exit;
	@header("Location: admin.php?page=$page&search=$search");

}
//aendern

if ($page == "artikel" && $change == "true"){
	$datum = "$day.$month.$year";
	$erschienen = input2date($datum);
	$Arbeit = isset($Arbeit) ? $Arbeit : 0;
	$Erziehung = isset($Erziehung) ? $Erziehung : 0;
	$Gesundheit = isset($Gesundheit) ? $Gesundheit : 0;
	$Familie = isset($Familie) ? $Familie : 0;
	$pdf_value = $oldfile;
	if ($file != ""){
		// for the deleting part it can come after the sql query ;) no idea why.
		if( $_FILES['file']['name'] != "" ) {
			$file_name = basename($_FILES['file']['name']);
			validate_upload($file_name);
			$pathto="../../pdf/".$file_name;
			move_uploaded_file( $_FILES['file']['tmp_name'],$pathto) or die( "Could not copy file!");
			$pdf_value = $file_name;
		} else {
			$delfile = "../../pdf/" . basename($oldfile);
			if ($file_name != $oldfile)
				@unlink($delfile);
			$pdf_value = $file_name;
		}
	}
	$stmt = mysqli_prepare($conn1, "UPDATE artikel SET titel_artikel=?, Zeitschrift=?, pdf=?, Arbeit=?, Erziehung=?, Gesundheit=?, Familie=?, thema_id=?, erschienen=? WHERE id_artikel=?");
	mysqli_stmt_bind_param(
		$stmt,
		'sssiiiiiss',
		$titel_artikel,
		$Zeitschrift,
		$pdf_value,
		$Arbeit,
		$Erziehung,
		$Gesundheit,
		$Familie,
		$searchnew,
		$erschienen,
		$id_artikel
	);
	if (!mysqli_stmt_execute($stmt)) {
		die($conn1->error);
	}
	header("Location: admin.php?page=$page&search=$searchnew");
}

//loeschen
if ($page == "artikel" && $delete == "true"){
	$delfile = "../../pdf/" . basename($oldfile);
	$stmt = mysqli_prepare($conn1, "DELETE FROM artikel WHERE id_artikel = ?");
	mysqli_stmt_bind_param($stmt, 's', $id_artikel);
	if (!mysqli_stmt_execute($stmt)) {
		die($conn1->error);
	}
	@unlink($delfile);
	@header("Location: admin.php?page=$page&search=$searchnew");
}
//Artikel pdf loeschen
if ($page == "artikel" && $pdfdelete == "true"){
	$stmt = mysqli_prepare($conn1, "UPDATE artikel SET pdf = '' WHERE id_artikel = ?");
	mysqli_stmt_bind_param($stmt, 's', $id_artikel);
	if (!mysqli_stmt_execute($stmt)) {
		die($conn1->error);
	}
	$delfile = "../../pdf/" . basename($oldfile);
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
	$stmt = mysqli_prepare($conn1, "INSERT INTO text (bereich_text,inhalt_text,datum_text) VALUES (?,?,?)");
	mysqli_stmt_bind_param($stmt, 'sss', $bereich_text, $inhalt_text, $datum_text);
	if (!mysqli_stmt_execute($stmt)) {
		die($conn1->error);
	}
	@header("Location: admin.php?page=$page&search=$search");
}
//aendern
if ($page == "text" && $change == "true"){
	$stmt = mysqli_prepare($conn1, "REPLACE INTO text (id_text,bereich_text,inhalt_text,datum_text) VALUES (?,?,?,?)");
	mysqli_stmt_bind_param($stmt, 'ssss', $id_text, $bereich_text, $inhalt_text, $datum_text);
	if (!mysqli_stmt_execute($stmt)) {
		die($conn1->error);
	}
	@header("Location: admin.php?page=$page&search=$search");
}
//loesche
if ($page == "text" && $delete == "true"){
	$stmt = mysqli_prepare($conn1, "DELETE FROM text WHERE id_text = ?");
	mysqli_stmt_bind_param($stmt, 's', $id_text);
	if (!mysqli_stmt_execute($stmt)) {
		die($conn1->error);
	}
	@header("Location: admin.php?page=$page&search=$search");
}
?>
