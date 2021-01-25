<?php

if (isset($command) && $command == "mailPage") {
	$subjectPage=$currentPage;
	if (isset($absender)){
		$email=$absender; 
	} else {
		$felderIn_profil = "id_profil, email";
		$query="SELECT $felderIn_profil FROM profil WHERE id_profil='$id' LIMIT 1";
		$result=mysql_query($query);
		$row=mysql_fetch_array($result);
		mysql_free_result($result);                                                                                                                                                                               
		$email=$row["email"];
	}
	$mailHeaders="MIME-Version: 1.0\r\nContent-Type: text/plain; charset=utf-8\r\nContent-Transfer-Encoding: 8-bit\r\nFrom:$email\r\n";                                                                                                                                    
	$mailTo="$recipient";   
	$mailSubject="Ganglion - Knotenpunkt menschlicher Beziehungen";                                                                                                                                                                                                                   
	$subjectPage .= (!empty($thread_id) ? "?id=$thread_id" : ""); 
	$mailBody=htmlflashen($personalMessage);
	//echo "mailBody - vor der ganzen addition = ".htmlentities($mailBody);	
	$mailBody.="\n\nFolgende Website wurde Ihnen durch ".$email." zur Ansicht empfohlen:\n\nhttp://www.ganglion.ch/flash/".$subjectPage."\n\nGanglion - Knotenpunkt menschlicher Beziehungen\nwww.ganglion.ch";                                                                                                                                                                                                                                    
	//echo "mailBody - nach der ganzen addition = ".htmlentities($mailBody);
	//send mail 
//	echo "$mailTo<br>$mailSubject<br>$mailBody<br>$mailHeaders";                                                                                                                                                                                                                                       
	mail($mailTo, $mailSubject, $mailBody, $mailHeaders);      
	echo "<p>&eof=true"; echo"&</p>\n";   

}

if (isset($request) && $request == "anmelden" && isset($command) && $command == "kurse"){
	//echo "position-light - kursanmeldung<br>";
	setlocale("LC_TIME", "de_CH");
	$datum=strftime("%A, %e. %B %Y");
	$mailHeaders="MIME-Version: 1.0\r\nContent-Type: text/html; charset='utf-8'\r\nContent-Transfer-Encoding: 7bit\r\nFrom:$email\r\nErrors-To: zdavatz@ywesee.com\r\n";
	$mailTo="sekretariat@ganglion.ch, zdavatz@ywesee.com";
	$mailSubject="Ganglion - Kursanmeldung";
	$mailBody = "
<HTML>
<TABLE width='500' border='0' cellspacing='2' align='left' valign='top'>
<tr align='left' valign='top'><td colspan='2'><font face='Arial, Helvetica, sans-serif' size='3'>Am $datum traf auf Ihrem Server folgende Kursanmeldung ein:</font></td></tr>
<tr align='left' valign='top'><td colspan='2'>&nbsp;</td></tr>
<tr align='left' valign='top'><td width='150'><b><font face='Arial, Helvetica, sans-serif' size='3'>Kurstitel:		</font></b></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Titel."<BR></font></td></tr>
".!empty($Anrede) ? "<tr align='left' valign='top'><td width='150'><b><font face='Arial, Helvetica, sans-serif' size='3'>Anrede:		</font></b></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Anrede."<BR></font></td></tr>":""."
<tr align='left' valign='top'><td width='150'><b><font face='Arial, Helvetica, sans-serif' size='3'>Name:			</font></b></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Name."<BR></font></td></tr>
<tr align='left' valign='top'><td width='150'><b><font face='Arial, Helvetica, sans-serif' size='3'>Vorname:		</font></b></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Vorname."<BR></font></td></tr>
<tr align='left' valign='top'><td width='150'><b><font face='Arial, Helvetica, sans-serif' size='3'>Adresse:		</font></b></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Adresse."<BR></font></td></tr>
<tr align='left' valign='top'><td width='150'><b><font face='Arial, Helvetica, sans-serif' size='3'>PLZ:			</font></b></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$PLZ."<BR></font></td></tr>
<tr align='left' valign='top'><td width='150'><b><font face='Arial, Helvetica, sans-serif' size='3'>Telefon:		</font></b></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Telefon."<BR></font></td></tr>
<tr align='left' valign='top'><td width='150'><b><font face='Arial, Helvetica, sans-serif' size='3'>E-Mail:			</font></b></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$email."<BR></font></td></tr>
<tr align='left' valign='top'><td width='150'><b><font face='Arial, Helvetica, sans-serif' size='3'>Bemerkungen:	</font></b></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Bemerkungen."<BR></font></td></tr>
<tr align='left' valign='top'><td colspan='2'>&nbsp;</td></tr>
<tr align='left' valign='top'><td colspan='2'><font face='Arial, Helvetica, sans-serif' size='3'>Ganglion - Knotenpunkt menschlicher Beziehungen</font></td></tr>
<tr align='left' valign='top'><td colspan='2'><font face='Arial, Helvetica, sans-serif' size='3'>www.ganglion.ch</font></td></tr>
</TABLE>
</HTML>
";
	mail($mailTo, $mailSubject, $mailBody, $mailHeaders); 
	
	$mailHeaders="MIME-Version: 1.0\r\nContent-Type: text/html; charset='utf-8'\r\nContent-Transfer-Encoding: 7bit\r\nFrom:kurse@ganglion.ch\r\nErrors-To: hwyss@ywesee.com\r\n";                                                                                                                                    
	$mailTo="$email, hwyss@ywesee.com";
	$mailSubject = "Ihre Kursanmeldung bei Ganglion";
	if (isset($Anrede)){
		switch ($Anrede) {
			case "Frau": 	$theWords = "Sehr geehrte Frau";
							break;
			case "Herr": 	$theWords = "Sehr geehrter Herr";
							break;
			case "Dr." : 
			case "Dr. med.":
			case "Prof.":	$theWords = "Guten Tag $Anrede";
			default:		$theWords = "Guten Tag $Vorname";
		}
	} else {
		$theWords = "Liebe(r) $Vorname";
	}
	$mailBody = "
<HTML>
<TABLE width='500' border='0' cellspacing='2' align='left' valign='top'>
<tr align='left' valign='top'><td colspan='2'><font face='Arial, Helvetica, sans-serif' size='3'>$theWords $Name</font></td></tr>
<tr align='left' valign='top'><td colspan='2'>&nbsp;</td></tr>
<tr align='left' valign='top'><td colspan='2'><font face='Arial, Helvetica, sans-serif' size='3'>Vielen Dank f&uuml;r Ihre Anmeldung. Wir werden uns in K&uuml;rze mit Ihnen in Verbindung setzen. Anbei zur Kontrolle noch einmal Ihre Angaben.</font></td></tr>
<tr align='left' valign='top'><td colspan='2'>&nbsp;</td></tr>
<tr align='left' valign='top'><td width='150'><b><font face='Arial, Helvetica, sans-serif' size='3'>Kurstitel:		</font></b></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Titel."<BR></font></td></tr>
".!empty($Anrede) ? "<tr align='left' valign='top'><td width='150'><b><font face='Arial, Helvetica, sans-serif' size='3'>Anrede:		</font></b></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Anrede."<BR></font></td></tr>":""."
<tr align='left' valign='top'><td width='150'><b><font face='Arial, Helvetica, sans-serif' size='3'>Name:			</font></b></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Name."<BR></font></td></tr>
<tr align='left' valign='top'><td width='150'><b><font face='Arial, Helvetica, sans-serif' size='3'>Vorname:		</font></b></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Vorname."<BR></font></td></tr>
<tr align='left' valign='top'><td width='150'><b><font face='Arial, Helvetica, sans-serif' size='3'>Adresse:		</font></b></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Adresse."<BR></font></td></tr>
<tr align='left' valign='top'><td width='150'><b><font face='Arial, Helvetica, sans-serif' size='3'>PLZ:			</font></b></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$PLZ."<BR></font></td></tr>
<tr align='left' valign='top'><td width='150'><b><font face='Arial, Helvetica, sans-serif' size='3'>Telefon:		</font></b></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Telefon."<BR></font></td></tr>
<tr align='left' valign='top'><td width='150'><b><font face='Arial, Helvetica, sans-serif' size='3'>E-Mail:		</font></b></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$email."<BR></font></td></tr>
<tr align='left' valign='top'><td width='150'><b><font face='Arial, Helvetica, sans-serif' size='3'>Bemerkungen:	</font></b></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Bemerkungen."<BR></font></td></tr>
<tr align='left' valign='top'><td colspan='2'>&nbsp;</td></tr>
<tr align='left' valign='top'><td colspan='2'><font face='Arial, Helvetica, sans-serif' size='3'>Mit freundlichen Gr&uuml;ssen</font></td></tr>
<tr align='left' valign='top'><td colspan='2'>&nbsp;</td></tr>
<tr align='left' valign='top'><td colspan='2'><font face='Arial, Helvetica, sans-serif' size='3'>Ganglion - Knotenpunkt menschlicher Beziehungen</font></td></tr>
<tr align='left' valign='top'><td colspan='2'><font face='Arial, Helvetica, sans-serif' size='3'>www.ganglion.ch</font></td></tr>
</TABLE>
</HTML>";	
	
	mail($mailTo, $mailSubject, $mailBody, $mailHeaders);
	
	echo "<p>&eof=true&</p>\n";
	
}

if (isset($command) && $command == "kontaktmail"){
	//echo "position-light - kontaktmail<br>";
	setlocale("LC_TIME", "de_CH");
	$datum=strftime("%A, %e. %B %Y");
	$mailHeaders="MIME-Version: 1.0\r\nContent-Type: text/html; charset='utf-8'\r\nContent-Transfer-Encoding: 7bit\r\nFrom:kontakt@ganglion.ch\r\nErrors-To: hwyss@ywesee.com\r\n";
	$mailTo="$email, hwyss@ywesee.com";
	$mailSubject="Ganglion";
	$i = 0;
	if (isset($problemstellung)) {
		$mailSubject.=" - Beratungsanfrage";
		$i++;
	}
	if (isset($vortrag_thema) || isset($vortrag_publikum)) {
		$mailSubject.=" - Vortragsanfrage";
		$i++;
	}
	if (isset($books)) {
		$mailSubject.=" - Buchbestellung";
		$i++;
	}
	if ($i>0){
		switch ($i) {
			case 1 : 	$betreff = ($problemstellung != "" ? "Ihre Beratungsanfrage" : ($books ? "Ihre Buchbestellung" : "Ihre Vortragsanfrage"));
						break;	
			case 2 :	$betreff = ($problemstellung != "" ? "Ihre Beratungsanfrage" : "Ihre Vortragsanfrage")." und ".($books ? "Ihre Buchbestellung" : "Ihre Vortragsanfrage");
						break;
			case 3 :	$betreff = "Ihre Beratungsanfrage, Ihre Vortragsanfrage sowie Ihre Buchbestellung";
						break;			
		}
		$mailBody = "
<HTML>
<TABLE width='600' border='0' cellspacing='2' align='left' valign='top'>
<tr align='left' valign='top'><td colspan='2'><font face='Arial, Helvetica, sans-serif' size='3'>Sehr geehrte(r) $Anrede $Name </font></td></tr>
<tr align='left' valign='top'><td colspan='2'>&nbsp;</td></tr>
<tr align='left' valign='top'><td colspan='2'><font face='Arial, Helvetica, sans-serif' size='3'>Wir haben $betreff am $datum erhalten. Vielen Dank. ".($problemstellung != "" || $vortrag_thema !="" || $vortrag_publikum != "" ? "Wir werden uns in K&uuml;rze mit Ihnen in Verbindung setzen." : "")."</font></td></tr>
<tr align='left' valign='top'><td colspan='2'>&nbsp;</td></tr>
".(!empty($Anrede) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>Anrede:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Anrede."<BR></font></td></tr>\n" : "")
.(isset($Name) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>Name:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Name."<BR></font></td></tr>\n" : "")
.(isset($Vorname) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>Vorname:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Vorname."<BR></font></td></tr>\n" : "")
.(isset($Firma) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>Firma:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Firma."<BR></font></td></tr>\n" : "")
.(isset($Adresse) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>Adresse:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Adresse."<BR></font></td></tr>\n" : "")
.(isset($PLZ) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>PLZ / Ort:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$PLZ."<BR></font></td></tr>\n" : "")
."<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>E-Mail:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$email."<BR></font></td></tr>
".(isset($Telefon) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>Telefon:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Telefon."<BR></font></td></tr>\n" : "")
.(isset($problemstellung) ?  "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>Problemstellung:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$problemstellung."<BR></font></td></tr>\n" : "")
.(isset($vortrag_thema) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>Vortrag zum Thema:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$vortrag_thema."<BR></font></td></tr>\n" : "")
.(isset($vortrag_publikum) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>Vortrag f&uuml;r:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$vortrag_publikum."<BR></font></td></tr>\n" : "")
.(isset($books) ? "<tr align='left' valign='top'><td colspan='2'><font face='Arial, Helvetica, sans-serif' size='3'><B>Bestellte B&uuml;cher:</B></font></td><td width='350'>\n" : "")
.(isset($drogensucht) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'>Wie bewahren wir unsere Kinder vor der Drogensucht:		</font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$drogensucht.($drogensucht == 1 ? " exemplar" : " exemplare")."<BR></font></td></tr>\n" : "")
.(isset($diffusion) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'>Fusion and Differentiation:		</font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$diffusion.($diffusion == 1 ? " exemplar" : " exemplare")."<BR></font></td></tr>\n" : "")
."<tr align='left' valign='top'><td colspan='2'>&nbsp;</td></tr><tr align='left' valign='top'><td colspan='2'>&nbsp;</td></tr>
<tr align='left' valign='top'><td colspan='2'><font face='Arial, Helvetica, sans-serif' size='3'>Ganglion - Knotenpunkt menschlicher Beziehungen</font></td></tr>
<tr align='left' valign='top'><td colspan='2'><font face='Arial, Helvetica, sans-serif' size='3'>www.ganglion.ch</font></td></tr>
</TABLE>
</HTML>
";
		mail($mailTo, $mailSubject, $mailBody, $mailHeaders); 
	}

	//mail to Webmaster
	if (isset($feedback)){
		$mailSubject.=" - Feedback";
	}
	if (isset($url) || isset($link_thema)){
		$mailSubject.=" - Linkvorschlag";
	}
	unset($betreff);
	if (isset($problemstellung)) {
		$betreff.="eine Beratungsanfrage";
		$komma = true;
	}
	if (isset($vortrag_thema) || isset($vortrag_publikum)) {
		$betreff.= ($komma ? ", " : "")."eine Vortragsanfrage";
		$komma = true;
	}
	if (isset($books)) {
		$betreff.= ($komma ? ", " : "")."eine Buchbestellung";
		$komma = true;
	}
	if (isset($feedback)) {
		$betreff.= ($komma ? ", " : "")."ein Feedback";
		$komma = true;
	}
	if (isset($url) || isset($link_thema)) {
		$betreff.= ($komma ? ", " : "")."ein Linkvorschlag";
	}
	$lastKomma = strrpos ($betreff, ",");
	if ($lastKomma != 0) {
		$betreff = substr($betreff, 0, $lastKomma)." und ".substr($betreff, $lastKomma+1);
	}

	
	$wurde = ($i>1 ? "wurden" : "wurde");

	$mailHeaders="MIME-Version: 1.0\r\nContent-Type: text/html; charset='utf-8'\r\nContent-Transfer-Encoding: 7bit\r\nFrom:website@ganglion.ch\r\nErrors-To: mhatakeyama@ywesee.com\r\n";
	$mailTo="sekretariat@ganglion.ch, mhatakeyama@ywesee.com, zdavatz@ywesee.com";


	$mailBody = "
<HTML>
<TABLE width='600' border='0' cellspacing='2' align='left' valign='top'>
<tr align='left' valign='top'><td colspan='2'><font face='Arial, Helvetica, sans-serif' size='3'>Am $datum $wurde von Ihrer Website aus $betreff gesendet. Folgende Angaben wurden dabei &uuml;bermittelt.</font></td></tr>
<tr align='left' valign='top'><td colspan='2'>&nbsp;</td></tr>
".(!empty($Anrede) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>Anrede:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Anrede."<BR></font></td></tr>\n" : "")
.(isset($Name) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>Name:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Name."<BR></font></td></tr>\n" : "")
.(isset($Vorname) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>Vorname:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Vorname."<BR></font></td></tr>\n" : "")
.(isset($Firma) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>Firma:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Firma."<BR></font></td></tr>\n" : "")
.(isset($Adresse) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>Adresse:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Adresse."<BR></font></td></tr>\n" : "")
.(isset($PLZ) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>PLZ / Ort:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$PLZ."<BR></font></td></tr>\n" : "")
."<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>E-Mail:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$email."<BR></font></td></tr>
".(isset($Telefon) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>Telefon:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$Telefon."<BR></font></td></tr>\n" : "")
.(isset($feedback) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>Feedback:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$feedback."<BR></font></td></tr>\n" : "")
.(isset($problemstellung) ?  "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>Problemstellung:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$problemstellung."<BR></font></td></tr>\n" : "")
.(isset($vortrag_thema) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>Vortrag zum Thema:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$vortrag_thema."<BR></font></td></tr>\n" : "")
.(isset($vortrag_publikum) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>Vortrag f&uuml;r:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$vortrag_publikum."<BR></font></td></tr>\n" : "")
.(isset($link_thema) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>Link zum Thema:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$link_thema."<BR></font></td></tr>\n" : "")
.(isset($url) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'><B>URL:</B></font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$url."<BR></font></td></tr>\n" : "")
.(isset($books) ? "<tr align='left' valign='top'><td colspan='2'><font face='Arial, Helvetica, sans-serif' size='3'><B>Bestellte B&uuml;cher:</B></font></td><td width='350'>\n" : "")
.(isset($drogensucht) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'>Wie bewahren wir unsere Kinder vor der Drogensucht:		</font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$drogensucht.($drogensucht == 1 ? " exemplar" : " exemplare")."<BR></font></td></tr>\n" : "")
.(isset($diffusion) ? "<tr align='left' valign='top'><td width='250'><font face='Arial, Helvetica, sans-serif' size='3'>Fusion and Differentiation:		</font></td><td width='350'><font face='Arial, Helvetica, sans-serif' size='3'>".$diffusion.($diffusion == 1 ? " exemplar" : " exemplare")."<BR></font></td></tr>\n" : "")
."<tr align='left' valign='top'><td colspan='2'>&nbsp;</td></tr><tr align='left' valign='top'><td colspan='2'>&nbsp;</td></tr>
<tr align='left' valign='top'><td colspan='2'><font face='Arial, Helvetica, sans-serif' size='3'>Ganglion - Knotenpunkt menschlicher Beziehungen</font></td></tr>
<tr align='left' valign='top'><td colspan='2'><font face='Arial, Helvetica, sans-serif' size='3'>www.ganglion.ch</font></td></tr>
</TABLE>
</HTML>
";
	mail($mailTo, $mailSubject, $mailBody, $mailHeaders); 

}

?>
