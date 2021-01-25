 
<div id="<?php echo "changeThema".$r?>">
<table class="TABLEthema"  bgcolor="#f7a65a" cellpadding="0" border="0" cellspacing="0">
<tr> 
<td nowrap>&nbsp;Bitte Thema &auml;ndern.</td>
<td align="right" valign="top"> 
<a href="#" onClick="closeAll();"> <img src="../images/endx.gif" width="20" height="20" border="0" alt=""> 
</a> </td>
</tr>
<tr> 
<td colspan="2"> 
<form method="post" action="save.php">
<input type="hidden" name="search" value="<?php print $search ?>">
	<input type="hidden" name="datumchange" value="<?php $datumchange = date("Y-m-d"); echo $datumchange; ?>">
	<input type="hidden" name="page" value="<?php print $page ?>">
	<input type="hidden" name="idThema" value="<?php echo $nummerThema[$r]; ?>">
	<input type="hidden" name="change" value="true">
<table>
<tr>
<td>
<input class='INPUTtexts' type="text" name="Thema" value="<?php echo $Thema[$r]; ?>">
</td>
<td>
<input type="submit" name="send" value="Abschicken">
</td>
</tr>
</table>
</form>
</td>
</tr>
</table>
</div>
