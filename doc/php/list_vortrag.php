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

		$result = mysqli_query($conn1, $query);
				$i=0;
				$datum = date("j.n.Y");	
				echo "<p>&datum=$datum&</p>\n";	
				while ($row = mysqli_fetch_array($result)){		
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
			mysqli_free_result($result);	
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
		$result = mysqli_query($conn1, $query);
		while ($row = mysqli_fetch_array($result)){
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
	
	$result = mysqli_query($conn1, $query);
	$row = mysqli_fetch_array($result);
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
	mysqli_query($conn1, "UPDATE vortrag SET hits=$hits WHERE id=$id");	
	mysqli_free_result($result);

	echo "<p>&eof=true&</p>\n";
	
	
}

if (isset($request) && $request=="updateDownloads"){
	
	mysqli_query($conn1, "UPDATE vortrag SET downloads=(downloads+1) WHERE id=$pdf_id");
	echo "<p>&eof=true&</p>\n";
	
}
?>
