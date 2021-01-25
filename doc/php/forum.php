<?php // forum.php

//register session variables
session_register("php_thread_array");
session_register("php_thread_pointer");
session_register("php_thread_id");
session_register("php_forum_search");
session_register("php_forum_sortierung");
session_register("php_forum_zeitfenster");

if (isset($request) && $request=="uebersicht") {
	//keep vars or replace?
	if (!isset($search)){
		$search = (!isset($php_forum_search) ? "all" : $php_forum_search);
	} else {
		$countOpinions=0;	
	}
	
	if (!isset($sortierung))	$sortierung = (empty($php_forum_sortierung) ? "datum DESC" : $php_forum_sortierung);
	if (!isset($zeitfenster)) $zeitfenster = (empty($php_forum_zeitfenster) ? 0 : $php_forum_zeitfenster);
	
	//remember variables for next run
	$php_forum_search=$search;
	$php_forum_sortierung=trim($sortierung);
	$php_forum_zeitfenster=$zeitfenster;

	unset ($php_thread_array);

	if ($search=="all"){
		$precision="";
	}	else	{
		$precision="B.thema_id=$search AND";
	}
	if ($zeitfenster == 0){
		$epoche="";
	}	else	{
		$epoche="AND TO_DAYS(datum) > (TO_DAYS(NOW())-$zeitfenster)";
	}
	
	$fieldsIn_forumThread="B.id_thread, B.titel_thread, B.$bereich, B.datum_thread, B.profil_id_thread, B.thema_id, B.hits";
	$fieldsIn_forumInhalt="COUNT(C.thread_id) AS anzahlEintraege, MAX(C.datum) AS datum";
	$fieldsIn_thema="D.id_thema, D.thema";
	$fieldsIn_profil="E.id_profil, E.login";
	$groupBy="C.thread_id";

	if ($countOpinions > 0){
		$fieldsIn_vortrag = "A.id, A.Titel, A.Arbeit, A.Erziehung, A.Gesundheit, A.Familie, A.thema_id";
		$allFields = "$fieldsIn_vortrag, $fieldsIn_forumThread, $fieldsIn_forumInhalt, $fieldsIn_thema, $fieldsIn_profil";
		$tablesIn_ganglion = "vortrag AS A, forum_thread AS B, forum_inhalt AS C, thema AS D, profil AS E";
		$whereConditions = "B.$bereich=1 AND B.profil_id_thread=E.id_profil AND B.thema_id=D.id_thema AND A.id = $php_vortrag_id AND A.thema_id=B.thema_id AND C.thread_id=B.id_thread AND CONCAT('%', A.Titel, '%') LIKE CONCAT('%', B.titel_thread, '%')";


	} else {	
	
		$allFields = "$fieldsIn_forumThread, $fieldsIn_forumInhalt, $fieldsIn_thema, $fieldsIn_profil";
		$tablesIn_ganglion = "forum_thread AS B, forum_inhalt AS C, thema AS D, profil AS E";
		$whereConditions = "B.$bereich=1 AND B.profil_id_thread=E.id_profil AND B.thema_id=D.id_thema AND C.thread_id=B.id_thread";

	}
	
	$query = "SELECT $allFields FROM $tablesIn_ganglion WHERE $precision $whereConditions $epoche GROUP BY $groupBy ORDER BY $sortierung";

	echo $query."<br>";
	
	$result = mysql_query($query);
	
	$i=0;
	while ($row = mysql_fetch_array($result)){
		$php_thread_array[]=$row["id_thread"];
		echo "<p>&id_thread$i="; echo $row["id_thread"];echo "&</p>\n";
		echo "<p>&id_profil$i="; echo $row["id_profil"];echo "&</p>\n";
		echo "<p>&titel_thread$i="; echo $row["titel_thread"];echo "&</p>\n";
		echo "<p>&thema$i="; echo $row["thema"];echo "&</p>\n";
		echo "<p>&Urheber$i="; echo $row["login"];echo "&</p>\n";
		echo "<p>&panAnzahlEintraege$i="; echo $row["anzahlEintraege"];echo "&</p>\n";
		echo "<p>&panHits$i="; echo $row["hits"];echo "&</p>\n";
		echo "<p>&panDatum$i="; echo deStampDate($row["datum"]);echo "&</p>\n";
		$i++;
	}

	if ($i==0){
		echo "<p>&titel_thread0=Keine Eintr%E4ge vorhanden&</p>\n";
		$i=1;
	}
	
	echo "<p>&anzahl=$i";echo "&</p>\n";
	echo "<p>&eof=true"; echo"&</p>\n";
	mysql_free_result($result);	
}

// Aktuelle MySQL-Abfrage:
// SELECT id_thread, titel_thread, Familie, datum_thread, profil_id_thread, thema_id, id_thema, thema, id_profil, login, SUM(hits) AS hits, MAX(datum) AS datum, COUNT(thread_id) AS anzahlEintraege FROM forum_thread AS A, thema AS B, profil AS C, forum_inhalt AS D WHERE A.thema_id=3 AND A.thema_id=B.id_thema AND A.profil_id_thread=C.id_profil AND A.Familie=1 AND A.id_thread=D.thread_id  GROUP BY A.id_thread ORDER BY datum DESC

if (isset($request) && $request == "keepPointer"){
	$php_thread_pointer=$pointer;
	unset($php_thread_id);
	echo "<p>&eof=true&</p>\n";	
}
if (isset($request) && $request=="keepID"){
	$php_thread_id=$id;
	unset($php_thread_array);
	echo "<p>&eof=true&</p>\n";	
}

if (isset($request) && $request == "directThread") {
	
	//echo "<b>Hier sind unsere Variablen:</b><br>ID=$php_vortrag_id<br>Pointer = $php_vortrag_pointer<br>Gr&ouml;sse des ID-Arrays: ".sizeof($vortrag_array)."<br>";
	
	if (sizeof($php_thread_array) == 0){
	//echo "kein thread_array gefunden<br>";
		$query="SELECT id_thread, $bereich, MAX(datum) AS datum FROM forum_thread AS A, forum_inhalt AS B WHERE $bereich=1 AND A.id_thread=B.thread_id GROUP BY A.id_thread ORDER BY datum DESC";
		//echo $query."<br>";
		$result = mysql_query($query);
		while ($row = mysql_fetch_array($result)){
			$php_thread_array[]=$row["id_thread"];
		}
	}
	if (isset ($pointer)){
	//echo "es gibt frische Pointer<br>";
		$php_thread_pointer=$pointer;
		unset($php_thread_id);
	} elseif (isset ($id)){
	//echo "es gibt frische ID<br>";
		$php_thread_id=$id;
		unset($php_thread_pointer);
	}
	if (isset($php_thread_id) && in_array($php_thread_id, $php_thread_array)){
	//echo "id wurde gleich mitgeliefert<br>";
		$php_thread_pointer=getPointer($php_thread_array, $php_thread_id);
	}  elseif (isset($php_thread_pointer)){
	//echo "wir sind in der pointer-schleife<br>";
		$php_thread_id=$php_thread_array[$php_thread_pointer];
	//echo "-- resultierende id = $id<br>";
	} else {
	//echo "setzen wir doch alles NULL...<br>";
		$php_thread_pointer=0;
		$php_thread_id=$php_thread_array[0];
	}


	$felderIn_forum_thread = "id_thread, titel_thread, profil_id_thread, thema_id";
	$felderIn_profil = "id_profil, login";
	$felderIn_thema = "id_thema, thema";
	$tabellenIn_ganglion = "forum_thread AS A, profil AS B, thema AS C";
	$whereBedingungen = "A.id_thread = $php_thread_id AND B.id_profil=A.profil_id_thread AND C.id_thema=A.thema_id";
	
	$result = mysql_query ("SELECT $felderIn_forum_thread, $felderIn_profil, $felderIn_thema FROM $tabellenIn_ganglion WHERE $whereBedingungen");
	$row = mysql_fetch_array($result);
	echo "<p>&Titel=".$row["titel_thread"]."&</p>\n";
	echo "<p>&Urheber=".$row["login"]."&</p>\n";
	echo "<p>&Thema=".$row["thema"]."&</p>\n";
	echo "<p>&thread_id=".$row["id_thread"]."&</p>\n";
	mysql_free_result($result);
	
	$felderIn_forum_inhalt = "profil_id, titel, text, datum";
	$felderIn_profil = "id_profil, login, email, url, signatur";
	$tabellenIn_ganglion = "forum_inhalt AS A, profil AS B";
	$whereBedingungen = "A.thread_id=$php_thread_id AND A.profil_id=B.id_profil";
	$sortierung = "A.datum DESC";
	
	$query = "SELECT $felderIn_forum_inhalt, $felderIn_profil FROM $tabellenIn_ganglion WHERE $whereBedingungen ORDER BY $sortierung";
	
	//echo "$query<br>";
	
	$result = mysql_query ($query);
	
	if (mysql_num_rows($result) > 0){
		$i=0;
		echo "&DetailThread=";
		while ($row = mysql_fetch_array($result)){
			$profil_id=$row["profil_id"];
			$datum=$row["datum"];
			$login=$row["login"];
			$email=$row["email"];
			$url=$row["url"];
			if ($i>0) echo "\n\n_______________________________________________________________________________________\n\n";
			echo deStampDate($datum)."     ".deStampTime($datum)."     ";
			echo "$login     $email     $url";
			echo "\n\n\n";
			//echo "<b>"; 
			echo $row["titel"]."\n\n"; 
			//echo "</b>\n\n";
			echo $row["text"]; echo "\n\n";
			echo "-- \n";

			if (empty($row["signatur"])){
				echo "$login\n";
				echo "$email\n";
				echo "$url\n";
			}
			echo $row["signatur"]; echo "\n";		
			$i++;
		}
		echo "&\n";
		echo "<p>&profil_id=$profil_id&</p>\n";
		echo "<p>&urheber_email=$email";echo "&</p>\n";
		echo "<p>&url=$url";echo "&</p>\n";
	}
	
	echo "<p>&php_thread_pointer=$php_thread_pointer&</p>\n";
	echo "<p>&anzahl=".sizeof($php_thread_array)."&</p>\n";
	echo "<p>&eof=true"; echo"&</p>\n";
	mysql_free_result($result);	
	
	$result = mysql_query ("SELECT id_thread, hits FROM forum_thread WHERE id_thread=$php_thread_id");
	$row = mysql_fetch_array($result);
	$hits = $row["hits"]+1;
	//echo "hits=$hits<br>";
	mysql_free_result($result);
	mysql_query("UPDATE forum_thread SET hits=$hits WHERE id_thread=$php_thread_id");
}

if (isset($request) && $request == "newThread") {
	$Titel=urlencode($Titel);
	$felderIn_forum_thread = "titel_thread, Familie, Arbeit, Gesundheit, Erziehung, profil_id_thread, thema_id";
	$werteFuer_forum_thread = "'$Titel', $Familie, $Arbeitsplatz, $Gesundheit, $Erziehung, $profil_id, $thema_id";

	$insert = mysql_query ("INSERT INTO forum_thread ($felderIn_forum_thread) VALUES ($werteFuer_forum_thread)");
	if ($insert){
		//echo"OK1";
		$newThreadId = mysql_insert_id();
		$felderIn_forum_inhalt = "thread_id, profil_id, titel, text";
		$werteFuer_forum_inhalt = "$newThreadId, $profil_id, '$Titel', '$Input'";
		mysql_query ("INSERT INTO forum_inhalt ($felderIn_forum_inhalt) VALUES ($werteFuer_forum_inhalt)");
	}
	echo "<p>&eof=true"; echo"&</p>\n";
}


if (isset($request) && $request == "addAnswer") {
	$felderIn_forum_inhalt = "thread_id, profil_id, titel, text";
	$werteFuer_forum_inhalt = "$id, $profil_id, '$Subtitle', '$Input'";
	$query = "INSERT INTO forum_inhalt ($felderIn_forum_inhalt) VALUES ($werteFuer_forum_inhalt)";
//	echo "query=$query<br>";
	
	$insert = mysql_query ($query);
//	echo "Eintrag erfolgt = $insert<br>";
	echo "<p>&eof=true"; echo"&</p>\n";
	
	if ($insert){
		$newAnswerId = mysql_insert_id();
		$felderIn_forum_inhalt = "id_inhalt, thread_id, profil_id, datum";
		$felderIn_profil = "id_profil, login, email, notification";
		$felderIn_forum_thread = "id_thread, titel_thread, Familie, Arbeit, Gesundheit, Erziehung";
		$tabellenIn_ganglion = "forum_inhalt AS A, profil AS B, forum_thread AS C";
		$whereBedingungen = "A.id_inhalt!=$newAnswerId AND A.thread_id=$id AND B.notification=1 AND A.profil_id=B.id_profil AND B.id_profil!=$profil_id";
		$gruppierung="B.id_profil";
		$result = mysql_query("SELECT $felderIn_forum_inhalt, $felderIn_profil, $felderIn_forum_thread FROM $tabellenIn_ganglion WHERE $whereBedingungen GROUP BY $gruppierung");
		while ($row = mysql_fetch_array($result)) {
			$bereich=$row["Familie"] ? "familie" : ($row[Arbeit] ? "arbeit" : ($row["Gesundheit"] ? "gesundheit" : ($row["Erziehung"] ? "erziehung" : "")));
			$mailTo = $row["email"];
			$datum = deStampDate($row["datum"]);
			$thread = $row["titel_thread"];
			$login = $row["login"];
			$mailHeaders="MIME-Version: 1.0\nContent-Type: text/plain; charset=utf-8\nContent-Transfer-Encoding: 7bit\nFrom:Ganglion - Knotenpunkt menschlicher Beziehungen<forum@ganglion.ch>\n";                                                                                                                                    
			$mailSubject="Neuer Eintrag in der Diskussion '$thread'";
			$mailBody = "$login,\n\n
in der Diskussion '$thread' wurde am $datum ein neuer Beitrag mit der Titel '$Subtitle' eingetragen. \n\n
Sie finden Ihn unter http://www.ganglion.ch/flash/forum_".$bereich."_detail.php?id=$id\n\n
Ganglion - Knotenpunkt menschlicher Beziehungen\nwww.ganglion.ch
";
			mail($mailTo, $mailSubject, $mailBody, $mailHeaders);      
		}
	}

}

if (isset($request) && $request == "getMenu") {
	$result = mysql_query ("SELECT * FROM thema ORDER BY thema");
	
	$i=0;
	while ($row=mysql_fetch_array($result)){
		echo "<p>&choose_thema$i="; echo $row["thema"]; echo"&</p>\n";
		echo "<p>&choose_thema_id$i="; echo $row["id_thema"]; echo"&</p>\n";
		$i++;
	}
	echo "<p>&themen_anzahl=$i"; echo "&</p>\n";
	echo "<p>&eof=true"; echo"&</p>\n";
	mysql_free_result($result);	
}


if (isset($request) && $request == "profile") {
	$felderIn_profil = "id_profil, login, email, url, publikationen, fachgebiet, biographie";
	$query = "SELECT $felderIn_profil FROM profil WHERE id_profil=$id";
	//echo "query=$query<br>";
	
	$result = mysql_query ($query);
	$row= mysql_fetch_array($result);
	echo "<p>&Urheber="; echo $row["login"]; echo "&</p>\n";
	echo "<p>&user_email="; echo $row["email"]; echo "&</p>\n";
	echo "<p>&url="; echo $row["url"]; echo "&</p>\n";
	echo "<p>&Publikationen="; echo $row["publikationen"]; echo "&</p>\n";
	echo "<p>&Fachgebiet="; echo $row["fachgebiet"]; echo "&</p>\n";
	echo "<p>&Biographie="; echo $row["biographie"]; echo "&</p>\n";
	echo "<p>&eof=true"; echo"&</p>\n";
	mysql_free_result($result);	
}

if (isset($request) && $request == "alterProfile") {
	$result = mysql_query ("SELECT * FROM profil WHERE id_profil=$id");
	$row= mysql_fetch_array($result);
	echo "<p>&userLogin="; echo $row["login"]; echo "&</p>\n";
	echo "<p>&userPass="; echo $row["pass"]; echo "&</p>\n";
	echo "<p>&userEmail="; echo $row["email"]; echo "&</p>\n";
	echo "<p>&userURL="; echo $row["url"]; echo "&</p>\n";
	echo "<p>&userPublikationen="; echo $row["publikationen"]; echo "&</p>\n";
	echo "<p>&userFachgebiet="; echo $row["fachgebiet"]; echo "&</p>\n";
	echo "<p>&userBiographie="; echo $row["biographie"]; echo "&</p>\n";
	echo "<p>&userSignatur="; echo $row["signatur"]; echo "&</p>\n";
	echo "<p>&userNotification="; echo $row["notification"]; echo "&</p>\n";
	echo "<p>&userNewsletter="; echo $row["newsletter"]; echo "&</p>\n";
	echo "<p>&eof=true"; echo"&</p>\n";
	mysql_free_result($result);	
}

if (isset($request) && $request == "saveProfile") {
	mysql_query("UPDATE profil SET login='$login', pass='$userPass', email='$email', url='$url', publikationen='$publikationen', fachgebiet='$fachgebiet', biographie='$biographie', signatur='$signatur', notification='$mail_notification', newsletter='$newsletter' WHERE id_profil=$id");
	echo "<p>&success=true&</p>\n";
	echo "<p>&eof=true"; echo"&</p>\n";
}

if (isset($request) && $request == "newProfile") {
	$result = mysql_query("SELECT login FROM profil WHERE login='$login'");
	$row=mysql_fetch_array($result);
	if (empty($row)){
		mysql_query("INSERT INTO profil SET login='$login', pass='$userPass', email='$email', url='$url', publikationen='$publikationen', fachgebiet='$fachgebiet', biographie='$biographie', signatur='$signatur', notification='$mail_notification', newsletter='$newsletter'");	
		echo "<p>&success=true&</p>\n";
		session_register ("currentUser");
		session_register ("currentName");
		session_register ("login_action");
		session_register ("login_frame");
		session_register ("login_id");
		$currentUser=mysql_insert_id();
		$currentName=$login;
		if (!empty($desiredAction)) $login_action=$desiredAction;
		if (!empty($desiredFrame)) $login_frame=$desiredFrame;
		if (!empty($desiredId)) $login_id=$desiredId;
	
	} else {
		echo "<p>&success=taken&</p>\n";
	}
	echo "<p>&eof=true"; echo"&</p>\n";
	mysql_free_result($result);
}

if (isset($request) && $request == "login") {
	include("login.php");
}

if (isset($request) && $request == "retrieveUserID"){
	if (isset($currentUser)){
		echo "<p>&this_user=$currentUser&</p>\n";
		echo "<p>&this_name=$currentName&</p>\n";
	} 
		if (isset($navigation_open)) echo "<p>&offen=$navigation_open&</p>\n";
		
		if (isset($currentPage)) {
			echo "<p>&thisPage=$currentPage&</p>\n"; 
		
		}
		//count items for bereich
		if (isset($bereich)) {
			//check for new lectures
			if($bereich=="Home"){
				$query = "SELECT * FROM vortrag WHERE gehalten > NOW()";
				$result = mysql_query($query);
				$newLects=mysql_num_rows($result);
				echo "<p>&newLects=$newLects&</p>\n";
				mysql_free_result($result);
			}
			unset($table);
			
			$query = "SELECT * FROM kurse WHERE beginn_kurse > NOW()";
			$result = mysql_query($query);
			$newCourses=mysql_num_rows($result);
			echo "<p>&newCourses=$newCourses&</p>\n";
			mysql_free_result($result);

			switch($bereich){
				case "Vortraege": $table="vortrag"; break;
				case "Forum": $table="forum_thread"; break;
				case "Kurse" : 
				case "Links" :
					$table=strtolower($bereich);
			}
			if(isset($table)){
				$query = "	SELECT 
							SUM(Arbeit) AS Arbeit,
							SUM(Erziehung) AS Erziehung,
							SUM(Gesundheit) AS Gesundheit,
							SUM(Familie) AS Familie 
							FROM $table";
				$result= mysql_query($query);
				$row = mysql_fetch_assoc($result);
				mysql_free_result($result);
				echo "<p>&countFamilie=".$row["Familie"]."&</p>\n";		
				echo "<p>&countArbeit=".$row["Arbeit"]."&</p>\n";		
				echo "<p>&countGesundheit=".$row["Gesundheit"]."&</p>\n";		
				echo "<p>&countErziehung=".$row["Erziehung"]."&</p>\n";		
			}
			echo "<p>&bereich=$bereich&</p>\n";
		}
		if (isset($php_desired_action)) echo "<p>&action=$php_desired_action&</p>\n";
		if (isset($php_desired_page)) echo "<p>&desiredPage=$php_desired_page&</p>\n";
		if (isset($php_desired_id)) echo "<p>&id=$php_desired_id&</p>\n";
		if (isset($pdf)) echo "<p>&pdf=$pdf&</p>\n";
		if (isset($last_page)) echo "<p>&lastPage=$last_page&</p>\n";
		if (isset($php_newThread_info) && substr($currentPage, -8) == "_neu.php"){
			echo "<p>&NewTitel=".$php_newThread_info["titel"]."&</p>\n";
			echo "<p>&thema_id=".$php_newThread_info["thema_id"]."&</p>\n";
			echo "<p>&thema=".$php_newThread_info["thema"]."&</p>\n";
			echo "<p>&Familie=".$php_newThread_info["familie"]."&</p>\n";
			echo "<p>&Arbeitsplatz=".$php_newThread_info["arbeit"]."&</p>\n";
			echo "<p>&Gesundheit=".$php_newThread_info["gesundheit"]."&</p>\n";
			echo "<p>&Erziehung=".$php_newThread_info["erziehung"]."&</p>\n";
			unset($php_newThread_info);
		}
		
		//most recent change...
		$query = "	SELECT
					MAX(UNIX_TIMESTAMP(forum_inhalt.datum)),
					MAX(UNIX_TIMESTAMP(kurse.datum_kurse)),
					MAX(UNIX_TIMESTAMP(links.datum)),
					MAX(UNIX_TIMESTAMP(text.datum_text)),
					MAX(UNIX_TIMESTAMP(vortrag.datumchange))
					FROM forum_inhalt, kurse, links, text, vortrag
					";
		$result = mysql_query($query);
		$arr_stamps = mysql_fetch_row($result);
		mysql_free_result($result);
		$eval_text = '$stamp=max('.implode(",", $arr_stamps).");";
		eval($eval_text);
		echo "<p>&thisYear=".date("d.m.Y", $stamp)."&</p>\n";
				
		echo "<p>&eof=true"; echo"&</p>\n";
		if ($bereich != "Profil" && $bereich != "Nutzung"){
			unset($php_desired_action);
			unset($php_desired_page);
			unset($pdf);
		}
}	

if (isset($request) && $request == "retrievePassword"){
	$result=mysql_query("SELECT id_profil, login, pass, email FROM profil WHERE email='$email' AND login IS NOT NULL AND pass IS NOT NULL ORDER BY id_profil DESC");
	$row=mysql_fetch_array($result);
	setlocale("LC_TIME", "de_CH");
	$datum=strftime("%A, %e. %B %Y");
	$login=$row["login"];
	$passwort=$row["pass"];
	$mailHeaders="MIME-Version: 1.0\r\nFrom:Ganglion - Knotenpunkt menschlicher Beziehungen<info@ganglion.ch>\r\nContent-Type: text/plain; charset=utf-8\r\nContent-transfer-encoding: quoted-printable\r\n";                                                                                                                                    
	$mailTo=$email;
	if(!empty($row)) {
		$mailSubject="Ihr Passwort f=?utf-8?q?=FC?=r Ganglion";
		$mailBody = ("$login,\n\n
Sie haben am $datum um Zusendung Ihres Passworts gebeten. Es Lautet wie folgt: \n\nBenutzername: $login\nPasswort: $passwort\n\nWir freuen uns, sie bald wieder unter http://www.ganglion.ch begr=FCssen zu d=FCrfen!\n\nGanglion - Knotenpunkt menschlicher Beziehungen");
	} else {
		$mailSubject="Zugang zu Ganglion";
		$mailBody = "Am $datum wurde unter Angabe Ihrer E-Mail-Adresse die Zusendung eines Passworts zum Ganglion-Forum verlangt. Leider konnten wir in Verbindung mit Ihrer E-Mail-Adresse keinen Benutzereintrag finden. Sie k=F6nnen sich jedoch gerne jederzeit ein neues Benutzerprofil einrichten unter http://www.ganglion.ch/flash/forum.php\n\nGanglion - Knotenpunkt menschlicher Beziehungen";
	}
	mail($mailTo, $mailSubject, $mailBody, $mailHeaders); 
	echo "<p>&eof=true"; echo"&</p>\n";
	mysql_free_result($result);
}
	
?>



