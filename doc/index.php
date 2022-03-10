<?php 
	require_once($_SERVER['DOCUMENT_ROOT']."/html/php/mysql_header.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
 <meta http-equiv="Content-Type"
 content="text/html; charset=utf-8">
	<link rel="stylesheet" href="../html/css/browser5.css"
 type="text/css">
  <title>Ganglion - Knotenpunkt menschlicher Beziehungen</title>
</head>
<body>
<?php
  require_once($_SERVER['DOCUMENT_ROOT']."/html/php/navbar.php");
?>
<br>
<table>
<tr>
<td width="310"><img src="../images/drdavatz.jpg" alt="Fr. Dr.med. Ursula Davatz" width="640" height="427"><br><br>
Frau Dr.med. Ursula Davatz, geboren 1942, ist mit dem K&uuml;nstler 
<a href="https://davaz.com">J&uuml;rg DaVaz</a> verheiratet und hat drei erwachsene Kinder.
<br>
<br>
<br>
<?php
							
		$query = "select Titel, thema, Zusammenfassung, zeit, Zielpublikum, location, id, date_format(gehalten,'%d.%m.%Y') 
							as gehalten_formatted, unix_timestamp(gehalten) as gehalten_unix
							from vortrag, thema 
							where thema_id!=255 and id_thema=thema_id
							and gehalten >= now()
							order by gehalten ASC limit 1";
		$result = mysqli_query($conn1, $query);
		$values = mysqli_fetch_assoc($result);
		echo '<nobr class="TDbold-big">N&auml;chster&nbsp;Vortrag:</nobr><br><br><a href="html/vortraege.php">'.urldecode ($values["Titel"]).'</a>';
		if (!empty($values["gehalten_formatted"]))
			{
				echo '<br><br><b>Datum:&nbsp;'.stripslashes(urldecode($values["gehalten_formatted"].'</b>'));
			}
		?>
<td>
<table class="nopaddingTABLE">
<tr>
<td class="TDbold-big" colspan="3">
	Frau Dr. med. Ursula Davatz<br>
	FMH Psychiatrie und Psychotherapie<br>
	Familiensystemtherapie nach Murray Bowen<br>
</td>	
</tr>
<tr>
<td class="TDbold" colspan="3">
	Biographie
<a href="html/pdf/Biographie.pdf">(Download)</a>
</td>
</tr>
<tr>
<td colspan="3">
Ausgebildet als &Auml;rztin, Psychaterin und Systemtherapeutin nach Murray Bowen. Langj&auml;hrige T&auml;tigkeit als Supervisorin, Dozentin und Referentin.<br> 
30 j&auml;hrige Erfahrung im Umgang mit Familiensystemen und Indexpatienten aus dem schwierigsten psychiatrischen Formenkreis wie Schizophrenie, Drogensucht, Essst&ouml;rungen, Psychosomatik und Delinquenz.<br>
Langj&auml;hrige Ausbildnerin in System- und Familientherapie f&uuml;r &Auml;rzte, Psychiater, Psychologen, Spitexschwestern, Jugendanw&auml;lte und andere interessierte Fachpersonen.<br>
Veranstalterin von vielen multidisziplin&auml;ren Tagungen im Gesundheits -und Pr&auml;ventionsbereich.<br>
Langj&auml;hrige Mitarbeit in Gremien, Organisationen und Projekten gesundheitspolitischer Natur, soziale Stiftungen und Krankenkasse.<br>
</td>
</tr>
<tr>
<td class="TDbold-big" colspan="3">B&uuml;cher:</td>
</tr>
<tr>
<td class="TDbold" colspan="2">"Fusion und Differentiation"<br>Fusing behavior in animal and man</td>
<td><a href="html/kontakt.php">Buch bestellen</a></td>
</tr>
<tr>
<td class="TDbold" colspan="2">"Wie bewahren wir unsere Kinder<br>vor der Drogensucht"</td>
<td><a href="html/kontakt.php">Buch bestellen</a></td>
</tr>
<tr>
<td class="TDbold" colspan="2">"ADHS und Schizophrenie - Wie emotionale Monsterwellen entstehen und wie sie behandelt werden"</td>
<td><a href="http://www.somedia-buchverlag.ch/gesamtverzeichnis/adhs-und-schizophrenie/">Buch bestellen</a> | <a href="https://www.amazon.de/ADHS-Schizophrenie-emotionale-Monsterwellen-entstehen-ebook/dp/B07ND672ZH/">E-Book bei Amazon bestellen</a></td>
</tr>
</td>
<tr>
<td class="TDbold" colspan="2">"AD(H)D and Schizophrenia - Guiding Principles (English Updated Version)"</td>
<td><a href="https://itunes.apple.com/us/book/id1451739789">Bei iBooks (Apple) kaufen</a> | <a href="https://www.amazon.com/dp/B07NGRBLQ1">Bei Amazon (Kindle) kaufen</a> | <a href="https://www.amazon.de/dp/3033070779">Bei Amazon als Buch kaufen</a></td>
</tr>
</td>
</tr>
<tr><td class="nopaddingTABLE">&nbsp;</td></tr>
<tr>
<td class="TDbold-big" colspan="3">Praxisadressen von Frau Dr. med. U. Davatz:</td>
</tr>
<tr>
<td>
Baden:<br>
<a href="html/maederstr.php">M&auml;derstrasse 13</a><br>
Anwesend: Mo, Di, Do, Fr<br><br>
Z&uuml;rich:<br>
<a href="html/winterthurerstr.php">Winterthurerstrasse 52</a><br>
Anwesend: Mi, Sa<br>
</td>
<td colspan="2" width="60%">
Sekretariat:<br>
Praxisgemeinschaft M&auml;derstrasse,<br>
<a href="html/maederstr.php">M&auml;derstrasse 13</a><br>
5400 Baden<br>
<a href="mailto:sekretariat@ganglion.ch">sekretariat@ganglion.ch</a><br>
Tel. 056 200 08 10<br>
Montag bis Freitag 9-11 Uhr<br>
Fax: 056 200 08 18<br>
</td>
</tr>
<td class="TDbold-big" colspan="3"><a href=https://adhs.expert/wp-content/uploads/2022/01/PSYCHIATER-PRAXIS-BADEN.pdf target=_blank>Ärzte Baden</a></td>
</tr>
<td class="TDbold-big" colspan="3"><a href=https://adhs.expert/wp-content/uploads/2022/01/Psychologinnen_Psychologe-Praxis-in-Baden-Ma%CC%88derstrasse-11.pdf target=_blank>Psychologe/Innen Baden</a></td>
</tr>
<td class="TDbold-big" colspan="3"><a href=https://adhs.expert/wp-content/uploads/2022/01/PSYCHOLOGINNEN-Praxis-Zürich_Winterthurerstrasse-52.pdf target=_blank>Psychologinnen Zürich</a></td>
<td class="TDbold-big" colspan="3"><a href=https://psychiatriewohin.ch/ target=_blank>Grossanlass "Psychiatrie wohin?" zum 80-jährigen Geburtstag von Dr.med. Ursula Davatzh</a></td>
</table>
</td>
</tr>
</table>
</body>
</html>
