<?php //source.php
//
include("auth.inc");

//error_reporting(E_ALL);

// Emulate register_globals on, 
// see https://www.php.net/manual/de/faq.misc.php#faq.misc.registerglobals
if (!ini_get('register_globals')) {
    $superglobals = array($_SERVER, $_ENV, $_FILES, $_COOKIE, $_POST, $_GET);
    if (isset($_SESSION)) {
        array_unshift($superglobals, $_SESSION);
    }
    foreach ($superglobals as $superglobal) {
        extract($superglobal, EXTR_SKIP);
    }
}


//
if (!isset($sessionPage)) $sessionPage = "";
if (!isset($sessionSearch)) $sessionSearch = "";
if (!isset($oldquerystring)) $oldquerystring = "";

session_start();

$_SESSION['username'] = 'ganglion';

$_SESSION['sessionPage'] = $sessionPage;
$_SESSION['sessionSearch'] = $sessionSearch;
$_SESSION['oldquerystring'] = $oldquerystring;
$_SESSION['session_searchterm'] = $session_searchterm;


//print_r($array);

$oldquery = $oldquerystring;
$oldquerystring = $QUERY_STRING;

//echo '<pre>';
//var_dump($_SERVER);
//echo '</pre>';

//echo $oldquery."<br>";
//echo $QUERY_STRING."<br>";


if (!empty($page))	{ $sessionPage = $page; }
if (!empty($search)){ $sessionSearch = $search; }
if (isset($searchterm)) 


{
	$session_searchterm = $searchterm;
}
else
{
	$searchterm = @$session_searchterm;
}

$page = $sessionPage;
$search = $sessionSearch;


if (!empty($search)){ $sessionSearch = "all"; }


include("function.php");
include("property.php");
include("browser.php");
include("object.php");
//
$closeTable = "</table>";
//echo $nocache;
//header ("Cache-Control: no-cache, must-revalidate");
//header ("Pragma: no-cache");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title>Ganglion Backend</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<SCRIPT language="JavaScript" type="text/javascript">
	djConfig = { 
		isDebug: true, 
	};
</SCRIPT>
<SCRIPT language="JavaScript" src="/javascript/dojo/dojo.js" type="text/javascript"></SCRIPT>
<SCRIPT language="JavaScript" type="text/javascript">
	dojo.require('dojo.fx.*');dojo.require('dojo.fx.html');dojo.require('dojo.io.*');dojo.require('dojo.io.IframeIO');dojo.require('dojo.animation.*');
</SCRIPT>
<script language="Javascript" type="text/javascript" src="../js/standart.js" charset="utf-8">
</script>
<?php print $css; ?> 
<style type="text/css">
div#patience-bg {  
	display: none;
	position: absolute; 
	background-color: black;
	top: 0px;
	left: 0px;
	width: 100%; 
	height: 100%; 
	z-index: 1;
	visibility: visible;
}
div#patience {
	display: none;
	z-index: 2;
	visibility: visible;
	position: absolute;
	border: red solid 2pt;
	left: 50%;
	margin-left: -150px;
	top: 50%;
	margin-top: -100px;
	width: 300px;
	height: 200px;
	background-color: white;
	padding-top: 20px;
	text-align: center;
}
div#bar {
	display: none;
	visibility: visible;
	z-index: 3;
	position: absolute;
	border: black solid 1pt;
	background-color: white;
	width: 250px;
	left: 50%;
	margin-left: -125px;
	height: 20px;
	top: 50%;
	margin-top: -10px;
}
div#mover {
	display: none;
	visibility: visible;
	z-index: 3;
	position: absolute;
	background-color: red;
	width: 10px;
	left: 50%;
	margin-left: -125px;
	height: 20px;
	top: 50%;
	margin-top: -10px;
}
</style>
</head>
<body>
<div id='patience-bg'><div id='patience'>Bitte haben Sie etwas Geduld. <br>Die Dateien werden hochgeladen...<div id='bar'><div id='mover'></div></div></div></div>
<table width="100%" border="0">
<tr> 
<td class='TDSiteTitel' colspan="2">
<img src="../images/clear.gif" width="650" height="1" alt="">
</td>
</tr>
<?php
if (empty($page))	{ 	$page = "vortrag";	}
if (empty($new))	{	$new = "false";		}
if (empty($change))	{	$change = "false";	}
//
//
if ($page == "kurse" && $new != "true" && $change != "true"){
		$titel="&Uuml;bersicht Kurse";
		$table = "kurse";
//
		include("navigation.php");
		include("uebersichtKurse.php");
}
//
if ($page == "kurse" && $new == "true" && $change != "true"){
		$titel="<a class='ASiteTitel' href='#' onClick='history.back();'>Kurse</a> &gt; neuer Eintrag";
		$table = "kurse";
//
		include("navigation.php");
		echo $closeTable;
		include("kurse.php");
}
//
if ($page == "kurse" && $new != "true" && $change == "true"){
		$titel="<a class='ASiteTitel' href='#' onClick='history.back();'>Kurse</a> &gt; Eintrag &auml;ndern";
		$table = "kurse";
//
		include("navigation.php");
		echo $closeTable;
		include("kurse.php");
}
if ($page == "artikel" && $new != "true" && $change != "true"){
		$titel="&Uuml;bersicht Zeitungsartikel";
		$table = "artikel";
//
		include("navigation.php");
		include("uebersichtArtikel.php");
}
//
if ($page == "artikel" && $new == "true" && $change != "true"){
		$titel="<a class='ASiteTitel' href='#' onClick='history.back();'>Zeitungsartikel</a> &gt; neuer Eintrag";
		$table = "artikel";
//
		include("navigation.php");
		include("artikel.php");
}
//
if ($page == "artikel" && $new != "true" && $change == "true"){
		$titel="<a class='ASiteTitel' href='#' onClick='history.back();'>Zeitungsartikel</a> &gt; Eintrag &auml;ndern";
		$table = "artikel";
//
		include("navigation.php");
		echo $closeTable;
		include("artikel.php");
}
//links
if  ($page == "links" && $new != "true" && $change != "true"){
		$titel="&Uuml;bersicht Links";
		$table = "links";
		include("navigation.php");
		include("uebersichtLinks.php");
}
//
if ($page == "links" && $new == "true" && $change != "true"){
		$titel="<a class='ASiteTitel' href='#' onClick='history.back();'>Links</a> &gt; neuer Eintrag";
		include("navigation.php");
		echo $closeTable;
		include("links.php");
}
//
if ($page == "links" && $new != "true" && $change == "true"){
		$titel="<a class='ASiteTitel' href='#' onClick='history.back();'>Links</a> &gt; Eintrag &auml;ndern";
		include("navigation.php");
		echo $closeTable;
		include("links.php");
}
//
//
//vortrag
if  ($page == "vortrag" && $new != "true" && $change != "true"){
		$titel=(empty($searchterm))?"&Uuml;bersicht Vortr&auml;ge":"Suchresultat&nbsp;f&uuml;r&nbsp;&quot;".$searchterm."&quot;";
		$table = "vortrag";
		include("navigation.php");
		include("uebersicht.php");
}
//
if ($page == "vortrag" && $new == "true" && $change != "true"){
		$titel="<a class='ASiteTitel' href='#' onClick='history.back();'>Vortr&auml;ge</a> &gt; neuer Eintrag";
		include("navigation.php");
		echo $closeTable;
		include("vortrag.php");
}
//
if ($page == "vortrag" && $new != "true" && $change == "true"){
		$titel="<a class='ASiteTitel' href='#' onClick='history.back();'>Vortr&auml;ge</a> &gt; Eintrag &auml;ndern";
		include("navigation.php");
		echo $closeTable;
		include("vortrag.php");
}
//

//
//themen
if  ($page == "themen" && $new != "true" && $change != "true"){
		$titel="&Uuml;bersicht Themen";
		include("navigation.php");
		include("uebersichtThemen.php");
}
if ($page == "themen" && $new == "true" && $change != "true"){
		$titel="<a class='ASiteTitel' href='#' onClick='history.back();'>Themen</a> &gt; neues Thema";
		include("navigation.php");
		echo $closeTable;
		include("themen.php");
}
if ($page == "themen" && $new != "true" && $change == "true"){
		$titel="<a class='ASiteTitel' href='#' onClick='history.back();'>Themen</a> &gt; Thema &auml;ndern";
		include("navigation.php");
		echo $closeTable;
		include("themen.php");
}

//
//
//
//forum
if  ($page == "foren" && $new != "true" && $change != "true" && $diskussion != "true" && $entry != "true"){
		$titel="&Uuml;bersicht Forum";
		$table = "forum_thread";
		include("navigation.php");
		include("uebersichtForen.php");
}
//
if ($page == "foren" && $new == "true" && $change != "true" && $diskussion != "true"  && $entry != "true"){
		$titel="<a class='ASiteTitel' href='#' onClick='history.back();'>Foren</a> &gt; neue Diskussion";
		$table = "forum_inhalt";
		include("navigation.php");
		echo $closeTable;
		include("foren.php");
}
//
if ($page == "foren" && $new != "true" && $change == "true" && $diskussion != "true"  && $entry != "true"){
		$titel="<a class='ASiteTitel' href='#' onClick='history.back();'>Forum</a> &gt; Diskussion &auml;ndern";
		$table = "forum_inhalt";
		include("navigation.php");
		echo $closeTable;
		include("foren.php");
}
//
if ($page == "foren" && $new != "true" && $change != "true" && $diskussion == "true" && $entry != "true"){
		$titel="<a class='ASiteTitel' href='#' onClick='history.back();'>Forum</a> &gt; Antworten &gt; &Uuml;bersicht Titel";
		$table = "forum_inhalt";
		include("navigation.php");
		include("uebersichtDiskussion.php");
}
//
if ($page == "foren" && $new != "true" && $change != "true" && $diskussion != "true" && $entry == "true"){
		$titel="<a class='ASiteTitel' href='#' onClick='history.back();'>Forum</a> &gt; Antworten &gt; Eintrag l&ouml;schen";
		$table = "forum_inhalt";
		include("navigation.php");
		echo $closeTable;
		include("changeDiskussion.php");
}
//
//
//
//Profile
if  ($page == "profil" && $new != "true" && $change != "true"){
		$titel="&Uuml;bersicht Profile";
		$table = "profil";
		include("navigation.php");
		include("uebersichtProfil.php");
}
//

if ($page == "profil" && $new == "true" && $change != "true"){
		$titel="<a class='ASiteTitel' href='#' onClick='history.back();'>Profile</a> &gt; neuer Eintrag";
		$table = "profil";
		include("navigation.php");
		echo $closeTable;
		include("profil.php");
}
//
if ($page == "profil" && $new != "true" && $change == "true"){
		$titel="<a class='ASiteTitel' href='#' onClick='history.back();'>Profile</a> &gt; Eintrag &auml;ndern";
		$table = "profil";
		include("navigation.php");
		echo $closeTable;
		include("profil.php");
}
//
//
//
//
//Texte
if  ($page == "text" && $new != "true" && $change != "true"){
		$titel="&Uuml;bersicht Text";
		$table = "text";
		include("navigation.php");
		include("uebersichtText.php");
}
//

if ($page == "text" && $new == "true" && $change != "true"){
		$titel="<a class='ASiteTitel' href='#' onClick='history.back();'>Text</a> &gt; neuer Eintrag";
		$table = "text";
		include("navigation.php");
		echo $closeTable;
		include("text.php");
}
//
if ($page == "text" && $new != "true" && $change == "true"){
		$titel="<a class='ASiteTitel' href='#' onClick='history.back();'>Text</a> &gt; Eintrag &auml;ndern";
		$table = "text";
		include("navigation.php");
		echo $closeTable;
		include("text.php");
}
//
//Newsletter
if  ($page == "news" && $new != "true" && $change != "true"){
		$titel="&Uuml;bersicht Newsletter";
		$table = "news";
		include("navigation.php");
		include("uebersichtnews.php");
}
//

if ($page == "news" && $new == "true" && $change != "true"){
		$titel="<a class='ASiteTitel' href='#' onClick='history.back();'>Newsletter</a> &gt; neuer Eintrag";
		$table = "news";
		include("navigation.php");
		echo $closeTable;
		include("news.php");
}
//
if ($page == "news" && $new != "true" && $change == "true"){
		$titel="<a class='ASiteTitel' href='#' onClick='history.back();'>Newsletter</a> &gt; Eintrag &auml;ndern";
		$table = "news";
		include("navigation.php");
		echo $closeTable;
		include("news.php");
}
//

?> 
</body>
</html>