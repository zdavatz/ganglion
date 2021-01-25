<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>sende Newsletter</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../css/WinNC.css">
</head>

<body bgcolor="#FFFFFF">
<table>
  <tr>
	<td>
	  <p>Die Newsletter wird an die Abonnenten gesendet.</p>
	  <p>Bitte warten Sie kurz.</p>
	</td>
  </tr>
</table>
<?php
include("function.php");
include("property.php");
include("mail_class.php");

$query_news = "SELECT * FROM newsletter WHERE id_news = '$id_news' ";
$result_news = mysql_query($query_news);
$row = mysql_fetch_array($result_news);
	$titel_news = htmlflashde($row["titel_news"]);
	$text_news = htmlflashde($row["text_news"]);
mysql_free_result($result_news);

if ($titel_news != "" && $text_news != ""){

$query = "SELECT * FROM profil WHERE newsletter = 1";
$result = mysql_query($query);
/*
 * Example usage
 *
 
 $attachment = fread(fopen("test.jpg", "r"), filesize("test.jpg")); 

 $mail = new mime_mail();
 $mail->from = "foo@bar.com";
 $mail->headers = "Errors-To: foo@bar.com";
 $mail->to = "bar@foo.com";
 $mail->subject = "Testing...";
 $mail->body = "This is just a test.";
 $mail->add_attachment("$attachment", "test.jpg", "image/jpeg");
 $mail->send();
 
 */ 
while ($row = mysql_fetch_array($result)){
	$userid = $row["id_profil"];
	
	$footer = "";
	$footer .= "\n\n\n\n---\n";
	$footer .= "Ganglion - Knotenpunkt menschlicher Beziehungen\n";
	$footer .= "http://$SERVER_NAME \n\n";
	$footer .= "Wenn Sie keine Newsletter mehr empfangen möchten benutzen Sie Bitte folgenden Link:\n";
	$footer .= "http://$SERVER_NAME/newsletter.php?userid=$userid&subscribe=out&/\n";
	
	$body = $text_news.$footer;

	$mail = new mime_mail();
	$mail->from = "newsletter@ganglion.ch";
	$mail->headers = "Errors-To: newsletter@ganglion.ch";
	$mail->to = $row["email"];
	$mail->subject = $titel_news;
	$mail->body = $body;
	$mail->send();
	
	unset($userid);
	unset($recipient);
	unset($subject);
	unset($footer);
	unset($body);
	
}
$ok = mysql_query("UPDATE newsletter SET send_news = NOW('') WHERE id_news = '$id_news' ");



}
?>
<script language="Javascript" type="text/javascript" charset="utf-8">
<!--

alert("Die Newsletter wurde gesendet.");
window.opener.location.reload();
window.close();
// -->
</script>
</body>
</html>
