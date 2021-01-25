<?php
	session_register("htBereich");
	$result = mysql_query("
		SELECT id, Titel, Zusammenfassung, gehalten, pdf, Familie, Arbeit, Gesundheit, Erziehung, thema_id, id_thema, thema 
		FROM vortrag AS A, thema AS B 
		WHERE B.id_thema=A.thema_id
		AND gehalten<CURRENT_DATE() 
		ORDER BY gehalten DESC");
		$row = mysql_fetch_array($result);	
		$htBereich=$row[$bereich];
	
		if(!$htBereich){
			$htBereich = strtolower($row["Familie"] ? "Familie" : ($row["Arbeit"] ? "Arbeit" : ($row["Gesundheit"] ? "Gesundheit" : "Erziehung")));
		} else {
			$htBereich = strtolower($bereich);
		}
	echo "<p>&hotTopic_bereich=$htBereich&</p>\n";
	echo "<p>&hotTopic_id=".stripslashes($row["id"])."&</p>\n";
	echo "<p>&hotTopic_Titel=".stripslashes($row["Titel"])."&</p>\n";
	echo "<p>&hotTopic_text=".stripslashes(urldecode($row["Zusammenfassung"]))."&</p>\n";

	echo "<p>&eof=true"; echo"&</p>\n";  
	mysql_free_result($result);

?>
