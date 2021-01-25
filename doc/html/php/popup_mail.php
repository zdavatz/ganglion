<?php
$_SESSION['user_input'] = @$$user_input;
$_SESSION['missing'] = @$$missing;
$email=$_POST["email"];
$user_input = array(); 
$mandatory = array("name", "email");
$missing = false;
foreach($mandatory as $key) 
{
	if(empty($_POST[$key])) $missing = true;
}
if($missing)
{
	$user_input = $_POST;
	header("Location: /html/popup_kurse.php");
	exit;
}
require('/usr/share/php/Mail.php');

$recipients='udavatz@ganglion.ch, sekretariat@ganglion.ch';

$headers['From']='kursanmeldung@ganglion.ch';
$headers['To']=	$recipients;
$headers["MIME-Version"]=  '1.0';
$headers["Content-type"]= 'text/plain charset=utf-8';


$headers['Subject']= stripslashes($subject);


$title=$_POST["title"];
if(!empty($title))
{
	$body.='Anrede: '.$title."\r\n";
}

$name=$_POST["name"];
if(!empty($name))
{
	$body.='Name: '.$name."\r\n";
}

$firstname=$_POST["firstname"];
if(!empty($firstname))
{
	$body.='Vorname: '.$firstname."\r\n";
}

$company=$_POST["company"];
if(!empty($company))
{
	$body.='Firma: '.$company."\r\n";
}

$address=$_POST["address"];
if(!empty($address))
{
	$body.='Adresse: '.$address."\r\n";
}

$plz_location=$_POST["plz_location"];
if(!empty($plz_location))
{
	$body.='PLZ / Ort: '.$plz_location."\r\n";
}

$phone_privat=$_POST["phone_privat"];
if(!empty($phone_privat))
{
	$body.='Telefon Privat: '.$phone_privat."\r\n";
}

$phone_geschaeft=$_POST["phone_geschaeft"];
if(!empty($phone_geschaeft))
{
	$body.='Telefon Geschaeft: '.$phone_geschaeft."\r\n";
}

$phone_mobile=$_POST["phone_mobile"];
if(!empty($phone_mobile))
{
	$body.='Telefon Mobile: '.$phone_mobile."\r\n";
}

$email=$_POST["email"];
if(!empty($email))
{
	$body.='Email: '.$email."\r\n";
}
if(!empty($body))
{
	$mail_object=&Mail::factory('sendmail');
	$mail_object->send($recipients,$headers,$body);
}
?>
