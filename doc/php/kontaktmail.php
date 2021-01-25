<?php //kontaktmail.php


if (isset($command) && $command == "kontaktmail"){

	//find out current newsletter-status and send Mail if status changed
	if (isset ($email) && isset ($newsletter)) changeNewsletter($email, $newsletter);

	// Falls der User nicht eingeloggt ist, wird geprŸft, ob seine E-Mail-adresse bereits registriert ist.	
	if (empty($profil_id) && !empty($email)){
		//echo "not logged In<br>";
		$query = "SELECT id_profil, email FROM profil WHERE email='$email' ORDER BY id_profil DESC";
		//echo "query = $query<br>";
		$result=mysql_query($query);
		if (mysql_num_rows($result) > 0){
			$row=mysql_fetch_array($result);
			$profil_id=$row["id_profil"];
		}
		mysql_free_result($result);
	}
	
	// Falls der User identifiziert werden kann, werden seine Angaben in der DB festgehalten 
	if (!empty($profil_id)){
		//echo "user identified <br>";
		// Eintrag in die Profiltabelle - Dieser User hat diese Adressangaben gemacht
		$query_email = "email='$email'";
		$query_name = (empty($Name) ? "" : ",profil_name='$Name'");
		$query_vorname = (empty($Vorname) ? "" : ",profil_vorname='$Vorname'");
		$query_adresse = (empty($Adresse) ? "" : ",profil_adresse='$Adresse'");
		$query_plz = (empty($PLZ) ? "" : ",profil_plz='$PLZ'");
		$query_telefon = (empty($Telefon) ? "" : ",profil_telefon='$Telefon'");
		if (isset($newsletter)){
			$newsletter = ($newsletter == 2 ? 0 : $newsletter);
			$query_newsletter = ",newsletter=$newsletter";
		}
		$felderUpdateIn_profil = "$query_email $query_name $query_vorname $query_adresse $query_plz $query_telefon $query_newsletter";
		$query = "UPDATE profil SET $felderUpdateIn_profil WHERE id_profil=$profil_id";
		//echo "query = $query<br>";	
		mysql_query ($query);
	} elseif ($newsletter == 1){
		$query = "INSERT INTO profil SET newsletter=1, email='$email'";
		mysql_query($query);
	}
	
	$mailCheck = $feedback.$problemstellung.$vortrag_thema.$vortrag_publikum.$url.$link_thema;
	if (!empty($mailCheck) || $books)	include("mailserver.php");
	
	echo ($mailCheck);
	
	echo "<p>&eof=true"; echo"&</p>\n";

}

?>

