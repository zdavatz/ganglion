<?php
require_once($_SERVER['DOCUMENT_ROOT']."/html/php/feedback_mail.php");
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" href="../html/css/browser5.css" type="text/css">
		<title>Ganglion - Knotenpunkt menschlicher Beziehungen</title>
	</head>
<body><br>
<?php
require_once($_SERVER['DOCUMENT_ROOT']."/html/php/navbar.php");
?>
<table>
	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
<?php if (!empty($mail_failed)) { ?>
	<tr><td class= "TDbold-bigfont"> Leider ist beim Versand ein Fehler aufgetreten.</td></tr>
	<tr><td>Bitte schreiben Sie uns direkt an <a href="mailto:sekretariat@ganglion.ch">sekretariat@ganglion.ch</a>.</td></tr>
<?php } else { ?>
	<tr><td class= "TDbold-bigfont"> Vielen Dank und noch viel Spass mit Ganglion!</td></tr>
<?php } ?>
</table>
</body>
</html>
