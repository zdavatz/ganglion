<table id='new' class ='TABLEnew' border="0">
 <tr>
  <td>
   <form name="new" method="get"  action="admin.php">
	<input type="hidden" name="search" value="<?php print $search ?>">
	<input type="hidden" name="page" value="<?php print $page ?>">
	<input type="hidden" name="new" value="true">
	<input type="submit" name="send" value="neuer Eintrag">
   </form>
  </td>
<?php 
if($page=="vortrag" && !empty($searchterm))
{
?>
  <td>
   <form name="all" method="get" action="admin.php">
    <input type="hidden" name="searchterm" value="">
    <input type="submit" name="all" value="Alle Vortr&auml;ge">
   </form>
  </td>
<?php
}
?>  
 </tr>
</table>
