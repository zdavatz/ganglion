<?php
//set session variables
session_register("vortrag_array");
session_register("php_vortrag_pointer");
session_register("php_vortrag_id");
session_register("php_search");
session_register("php_sortierung");
session_register("php_zeitfenster");

//keep vars or replace by new vars?
if (empty($request))	$request	= "uebersicht";
if (empty($table))  	$table		= "vortrag";



if (isset($request) && $request=="uebersicht"){
	
	//keep vars or replace, part 2
	if (!isset($search)) 	$search 	= (empty($php_search) ? "all" : $php_search);
	if (!isset($sortierung))	$sortierung = (empty($php_sortierung) ? "gehalten DESC" : $php_sortierung);
	if (!isset($zeitfenster)) $zeitfenster = (empty($php_zeitfenster) ? 0 : $php_zeitfenster);
	
	//remember variables for next run
	$php_search=$search;
	$php_sortierung=trim($sortierung);
	$php_zeitfenster=$zeitfenster;


		unset($vortrag_array);
		
		$felderIn_thema = "id_thema, thema";
		$tabellenIn_ganglion = "$table AS A, thema AS B";
	
		if($bereich == "Nächste Vorträge"){
			$felderIn_vortrag = "id, Titel, gehalten, hits, downloads, thema_id";
			$whereBedingungen = "A.thema_id=B.id_thema AND gehalten > NOW()";
			$search="all";
			$zeitfenster=0;
		} else {
			$felderIn_vortrag = "id, Titel, gehalten, hits, downloads, $bereich, thema_id";
			$whereBedingungen = "A.thema_id=B.id_thema AND A.$bereich=1";
		}
		
		if ($search=="all"){
			$precision="";
		}	else	{
			$precision="A.thema_id=$search AND";
		}
		if ($zeitfenster == 0){
			$epoche="";
		}	else	{
			$epoche="AND YEAR(gehalten)=$zeitfenster";
		}

		$query="SELECT $felderIn_vortrag, $felderIn_thema FROM $tabellenIn_ganglion WHERE $precision $whereBedingungen $epoche ORDER BY $sortierung";
		echo "$query<br>";

		$result = mysql_query ($query);
				$i=0;
				$datum = date("j.n.Y");	
				echo "<p>&datum=$datum&</p>\n";	
				while ($row = mysql_fetch_array($result)){		
						$gehalten = datum_ch($row["gehalten"]);
						$id = $row["id"];
						
						$vortrag_array[$i]=$id;
						
						$Titel = stripslashes($row["Titel"]);
						$thema = stripslashes($row["thema"]);
						$hits = $row["hits"];
						$downloads = $row ["downloads"];
						if (empty($id))  	$id		= "&nbsp;";
						if (empty($Titel)) 	$Titel	= "&nbsp;";
						if (empty($thema))  $thema	= "&nbsp;";
					echo "<p>&id$i=$id&</p>\n";
					echo "<p>&Titel$i=$Titel&</p>\n";
					echo "<p>&gehalten$i=$gehalten&</p>\n";
					echo "<p>&thema$i=$thema&</p>\n";
					echo "<p>&hits$i=$hits&</p>\n";	
					echo "<p>&downloads$i=$downloads&</p>\n";

					$i++;
					
				}

			if ($i==0){
				echo "<p>&Titel0=Keine Eintr%E4ge vorhanden&</p>\n";
				$i=1;
			}
			echo "<p>&php_sortby=".trim(strtok($sortierung, " "))."&</p>\n";
			echo "<p>&php_richtung=".trim(strstr($sortierung, " "))."&</p>\n";
			echo "<p>&anzahl=$i&</p>\n";
			echo "<p>&eof=true&</p>\n";
			mysql_free_result($result);	
}

if (isset($request) && $request=="keepPointer"){
	$php_vortrag_pointer=$pointer;
	unset ($php_vortrag_id);
	echo "<p>&eof=true&</p>\n";	
}
if (isset($request) && $request=="keepID"){
	$php_vortrag_id=$id;
	unset($vortrag_array);
	echo "<p>&eof=true&</p>\n";	
}

if (isset($request) && $request=="directThread"){

	//echo "<b>Hier sind unsere Variablen:</b><br>ID=$php_vortrag_id<br>Pointer = $php_vortrag_pointer<br>Gr&ouml;sse des ID-Arrays: ".sizeof($vortrag_array)."<br>";
	
	if (sizeof($vortrag_array) == 0){
	//echo "kein vortrag_array gefunden<br>";
		$query="SELECT id, $bereich FROM vortrag WHERE $bereich=1 ORDER BY datumchange DESC";
		$result = mysql_query($query);
		while ($row = mysql_fetch_array($result)){
			$vortrag_array[]=$row["id"];
		}
	}
	if (isset ($pointer)){
	//echo "es gibt frische Pointer<br>";
		$php_vortrag_pointer=$pointer;
		unset($php_vortrag_id);
	} elseif (isset ($id)){
	//echo "es gibt frische ID<br>";
		$php_vortrag_id=$id;
		unset($php_vortrag_pointer);
	}
	if (isset($php_vortrag_id) && in_array($php_vortrag_id, $vortrag_array)){
	//echo "id wurde gleich mitgeliefert<br>";
		$php_vortrag_pointer=getPointer($vortrag_array, $php_vortrag_id);
	}  elseif (isset($php_vortrag_pointer)){
	//echo "wir sind in der pointer-schleife<br>";
		$php_vortrag_id=$vortrag_array[$php_vortrag_pointer];
	//echo "-- resultierende id = $id<br>";
	} else {
	//echo "setzen wir doch alles NULL...<br>";
		$php_vortrag_pointer=0;
		$php_vortrag_id=$vortrag_array[0];
	}
	

	$felderIn_vortrag = "id, Titel, Zusammenfassung, gehalten, Zielpublikum, zeit, location, pdf, thema_id, hits";
	$felderIn_thema = "id_thema, thema";
	$tabellenIn_ganglion = "vortrag AS A, thema AS B";
	$whereBedingungen = "A.id=$php_vortrag_id AND B.id_thema=A.thema_id";
	
	$query="SELECT $felderIn_vortrag, $felderIn_thema FROM $tabellenIn_ganglion WHERE $whereBedingungen";
//	echo $query."<br>";
	
	$result = mysql_query ($query);
	$row = mysql_fetch_array($result);
				$id = $row["id"];
				$Titel = stripslashes($row["Titel"]);		
				$Zusammenfassung = stripslashes(urldecode($row["Zusammenfassung"]));
				$gehalten =datum_ch($row["gehalten"]);		
				$Zielpublikum = stripslashes($row["Zielpublikum"]);		
				$time = $row["zeit"];
				$zeit = date("H:i", $time);
				$location = stripslashes($row["location"]);
				$pdf = $row["pdf"];
				$thema = $row ["thema"];
				$thema_id = $row ["thema_id"];		
			echo "<p>&id=$id&</p>\n";
			echo "<p>&DetailTitel=$Titel&</p>\n";
			echo "<p>&Zusammenfassung=$Zusammenfassung&</p>\n";
			echo "<p>&DetailDatum=$gehalten&</p>\n";
			echo "<p>&Zielpublikum=$Zielpublikum&</p>\n";
			echo "<p>&zeit$i=$zeit&</p>\n";
			echo "<p>&location$i=$location&</p>\n";
			echo "<p>&DetailThema=$thema&</p>\n";
			echo "<p>&thema_id=$thema_id&</p>\n";
			echo "<p>&pdf=$pdf&</p>\n";
			echo "<p>&php_vortrag_pointer=$php_vortrag_pointer&</p>\n";
			echo "<p>&anzahl=".sizeof($vortrag_array)."&</p>\n";
			
	$hits = $row["hits"]+1;
	mysql_query("UPDATE vortrag SET hits=$hits WHERE id=$id");	
	mysql_free_result($result);
			
	$fieldsIn_vortrag = "A.id, A.Titel, A.thema_id";
	$fieldsIn_forumThread="B.id_thread, B.titel_thread, B.$bereich, B.thema_id";
	$allFields = "$fieldsIn_vortrag, $fieldsIn_forumThread";
	$tablesIn_ganglion = "vortrag AS A, forum_thread AS B";
	$whereConditions = "A.id = $php_vortrag_id AND A.thema_id=B.thema_id AND CONCAT('%', A.Titel, '%') LIKE CONCAT('%', B.titel_thread, '%')";
	$query="SELECT $allFields FROM $tablesIn_ganglion WHERE $whereConditions";
	
	echo "$query<br>";
	
	$result = mysql_query($query);
	
	session_register("countOpinions");
	$countOpinions = mysql_num_rows($result);
	mysql_free_result($result);
	
	$query="SELECT id_thread, $bereich, thema_id FROM forum_thread WHERE thema_id=$thema_id AND $bereich=1";
	$result=mysql_query($query);
	$countTopics=mysql_num_rows($result);
	mysql_free_result($result);
			
	echo "<p>&countOpinions=$countOpinions&</p>\n";
	echo "<p>&countTopics=$countTopics&</p>\n";
	
	echo "<p>&eof=true&</p>\n";
	
	
}

if (isset($request) && $request=="opinion"){

	switch($bereich){
		case "Familie":
		case "Arbeit":
		case "Gesundheit":
		case "Erziehung":
			$vbereich = $bereich;
			break;
		default:
			$vbereich = $htBereich;
	}

	if (!empty($search)){
		
		$query = "SELECT thema_id, $vbereich FROM forum_thread WHERE thema_id=$search AND $vbereich=1";
		//echo "$query<br>";
		$result = mysql_query($query);
		if (mysql_num_rows($result) > 0){
			
			session_register("php_forum_search");
			$php_forum_search=$search;
			echo "<p>&nextPage=forum_".strtolower($vbereich).".php&</p>\n";		
		} else {
			//make new discussion with same Topic
			mysql_free_result($result);
			$query = "SELECT id_thema, thema FROM thema WHERE id_thema=$search";	
			$result = mysql_query($query);
			$row = mysql_fetch_array($result);
			session_register("php_newThread_info");
			$php_newThread_info = array("thema_id"=>$search, "thema"=>$row["thema"]);

			echo "<p>&nextPage=forum_".strtolower($vbereich)."_neu.php&</p>\n";

		}
			
		mysql_free_result($result);
		$countOpinions = 0;
	
	} elseif (empty($countOpinions) || $countOpinions == 0){
	
		//mysql_free_result($result);
		$fieldsIn_vortrag="id, Titel, Familie, Arbeit, Gesundheit, Erziehung, thema_id";
		$fieldsIn_thema="id_thema, thema";
		$tablesIn_ganglion="vortrag AS A, thema AS B";
		$whereConditions="A.id=$php_vortrag_id AND A.thema_id = B.id_thema";
		$query = "SELECT $fieldsIn_vortrag, $fieldsIn_thema FROM $tablesIn_ganglion WHERE $whereConditions";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		session_register("php_newThread_info");
		$php_newThread_info = array("titel"=>$row["Titel"], "thema_id"=>$row["thema_id"], "thema"=>$row["thema"], "familie"=>$row["Familie"], "arbeit"=>$row["Arbeit"], "gesundheit"=>$row["Gesundheit"], "erziehung"=>$row["Erziehung"]);

		echo "<p>&nextPage=forum_".strtolower($vbereich)."_neu.php&</p>\n";
		mysql_free_result($result);
		
	} else {
		
		echo "<p>&nextPage=forum_".strtolower($vbereich).".php&</p>\n";
		
	}

	echo "<p>&eof=true&</p>\n";
}

if (isset($request) && $request=="updateDownloads"){
	
	mysql_query ("UPDATE vortrag SET downloads=(downloads+1) WHERE id=$pdf_id");
	if (!empty($currentUser)){
		mysql_query ("UPDATE profil SET downloads=(downloads+1) WHERE id_profil=$currentUser");
	}
	echo "<p>&eof=true&</p>\n";
	
}
?>
