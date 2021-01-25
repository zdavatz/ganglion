<?php
function no_authentification(){
	Header("WWW-authenticate: basic real=\"wsadmin\"");
	Header("HTTP/1.0 401 Unauthorized"); ?>
	<b><font face="Arial, Helvetica, sans-serif" size="5" color="#FF0000">
		Sie ben&ouml;tigen Nutzernamen und Kennwort zum Zugriff.
	</font></b> 
	<?php
	exit;
}

if (!isset($_SERVER['PHP_AUTH_USER'])){
	no_authentification();
	} else {
	if ($_SERVER['PHP_AUTH_USER'] != "webmaster" && $_SERVER['PHP_AUTH_PW'] != "ganglion"){
		no_authentification();
		}
}
