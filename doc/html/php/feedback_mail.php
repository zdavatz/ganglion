<?php
$_SESSION['user_input'] = @$$user_input;
$_SESSION['missing_email'] = @$$missing_email;
$user_input = array(); 
$email=$_POST["email"];
if(empty($_POST["email"]))
{
	$user_input = $_POST;
	$missing_email = true;
	header("Location: /html/kontakt.php");
	exit;
}
require('/usr/share/php/Mail.php');

$recipients='udavatz@ganglion.ch, sekretariat@ganglion.ch';

$headers['From']='kontakt@ganglion.ch';
$headers['To']=	$recipients;
$headers["MIME-Version"]=  '1.0';
$headers["Content-type"]= 'text/plain charset=utf-8';


switch($_POST['subject'])
{
	case 'counsel':
		$subject="Beratungsanfrage: ";
		break;
	case 'lecture':
		$subject="Vortragsanfrage: ";
		break;
	case 'apply':
		$subject="Kursanmeldung: ";
		break;
	default:
		$subject="Feedback: ";
}

$headers['Subject']=$subject;


$body="";

$textfield=$_POST["textfield"];
if(!empty($textfield))
{
	$body.=$textfield."";
}

$book_bewahren=$_POST["book_bewahren"];
$email=$_POST["email"];
if(!empty($email))
{
	$body.='Email: '.$email."\r\n";
}

$book_bewahren=$_POST["book_bewahren"];
if(!empty($book_bewahren))
{
	$body.='Buch Bestellung: Wie bewahren wir...  Anzahl:	'.$book_bewahren."\r\n";
}

$book_fusion=$_POST["book_fusion"];
if(!empty($book_fusion))
{
	$body.='Buch Bestellung: Fusion and Diffusion  Anzahl:	'.$book_fusion."\r\n";
}

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

$phone=$_POST["phone"];
if(!empty($phone))
{
	$body.='Telefon: '.$phone."\r\n";
}
if(!empty($body))
{
	$mail_object=&Mail::factory('sendmail');
	$mail_object->send($recipients,$headers,$body);
}
?>
