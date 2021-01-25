<?php

$result = mysql_query("SELECT A.*, B.id_profil, B.login, B.email  FROM forum_inhalt AS A, profil AS B WHERE A.profil_id=B.id_profil AND A.id_inhalt='$id_inhalt'");
$row = mysql_fetch_array($result);
	
	$titel = $row["titel"];
	$text = $row["text"];
	$login = $row["login"];
	$email = $row["email"];
	$datum = deStampDate($row["datum"]);

?>
<form method="post" action="save.php" name="changeDiskussion">
<table id='diskussion' class='TABLEdiskussion'>
<tr> 
<td id='diskussion' class='TDdiskussion'>Titel:</td>
<td id='diskussion' class='TDdiskussion'><?php print $titel;?></td>
</tr>
<tr> 
<td id='diskussion' class='TDdiskussion'>Login:</td>
<td id='diskussion' class='TDdiskussion'><?php print $login;?></td>
</tr>
<tr> 
<td id='diskussion' class='TDdiskussion'>Email:</td>
<td id='diskussion' class='TDdiskussion'><?php print $email;?></td>
</tr>
<tr> 
<td id='diskussion' class='TDdiskussion'>Text: </td>
<td id='diskussion' class='TDdiskussion'><?php print $text;?></td>
</tr>
<tr> 
<td  id='diskussiondelete' class='TDdiskussiondelete'> 
<input type="hidden" name="id" value="<?php print $id; ?>">
<input type="hidden" name="diskussion" value="true">
<input type="hidden" name="id_inhalt" value="<?php print $id_inhalt; ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="delete" value="true">
<input type="hidden" name="search" value="<?php echo $search ?>">
<input type="hidden" name="comment" value="one">
</td>
<td id='diskussiondelete' class='TDdiskussiondelete'> 
<input type="submit" name="delete4" value="Eintrag L&ouml;schen">
</td>
</tr>
</table>
</form>
</body>
</html>
