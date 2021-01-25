<?php


?>
<tr> 
<td colspan="2">

	<table id="nav" class="TABLEnav" width="100%" border="0">
	 <tr> 
	  <td id='SiteTitel' class='TDSiteTitel'>
	  <?php 
	  echo "<b>".$titel."</b>"; 
	  if ($debug == "true"){ 
	  	echo "         $QUERY_STRING\n";
	  }
	  ?>
	  </td>
	  <td class="TDSiteNav" align="right">
	  <table border="0" align="right">
	  <tr>
	  <td class="TDSiteNav">
	   <form name="search" method="get" action="admin.php">
	    <input type="text" name="searchterm">
	    <input type="hidden" name="page" value="vortrag">
	    <input type="submit" name="search" value="Vortrag suchen">
	   </form>
	  </td>
	  <td class='TDSiteNav'> 
	   <form name="go" method="get"  action="admin.php">
		<select name="page" onChange="go.submit()">
		 <option value="" selected>&Uuml;bersicht...</option>
		 <option value="text">Text</option>
		 <option value="vortrag">Vortr&auml;ge</option>
		 <option value="kurse">Kurse</option>
		 <option value="artikel">Zeitungsartikel</option>
		 <!--<option value="foren">Forum</option>-->
		 <option value="profil">Profile</option>
		 <option value="themen">Themen</option>
		 <option value="links">Links</option>
		 <option value="news">Newsletter</option>
		</select>
		<input type="hidden" name="search" value="<?php print $search ?>">
		<noscript> 
		<input type=SUBMIT value=Go name="SUBMIT"/>
		</noscript> 
	   </form>
	  </td>
	  </tr>
	  </table>
	  </td>
	 </tr>
	</table>
	
</td>
</tr>
