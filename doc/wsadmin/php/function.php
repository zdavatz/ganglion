<?php //function.php
function deStampDate($stampedDate){
	$year=substr($stampedDate, 0,4);
	$month=substr($stampedDate, 4,2);
	$day=substr($stampedDate, 6,2);
	$hour=substr($stampedDate, 8,2);
	$minute=substr($stampedDate, 10,2);
	$second=substr($stampedDate, 12,2);
	$UXStamp=mktime($hour,$minute,$second,$month,$day,$year);
	$deStampDate=date("d.m.Y", $UXStamp);
	return $deStampDate;
}
//
function datum_ch($datum){
	$token="-";
	$y = strtok($datum,$token);
	$m = strtok($token);
	$d = strtok($token);
	$DatumCH = (time("d.m.Y", time(0,0,0,$m,$d,$y)));
	return $DatumCH;
}
//
function grad_ungrad($AnZahL){
		$iNull = $AnZahL/2; $token=".,";
		$iVor = strtok($iNull,$token);
		$inach = strtok($token);
		if ( $inach != 5 ) {
			$grad = 1;
		}
		else {
			$grad = 0;
		}
		return $grad;
}
//
function firstchar($allchar,$numchar){
		$ENDText = "~";
		$Text = chunk_split($allchar,$numchar,$ENDText);
		$Text = strtok($Text,$ENDText);
		return $Text;
}
//
function input2date($idate){
	$token="-./, ";
	$p1 = strtok($idate,$token);
	$p2 = strtok($token);
	$p3 = strtok($token);
	$p4 = strtok($token);
	$date="";
	$y=""; $m=""; $d="";
	//check 'd.m.y'
	if (($p1>0 && $p1<32) && ($p2>0 && $p2<13) && ($p3>32)){
		$y=$p3;
		$m=$p2;
		$d=$p1;
	}
	//check 'y.m.d'
	if (($y == "") &&
	   ($p1>32) && ($p2>0 && $p2<13) && ($p3>0 && $p3<32)){
		$y=$p1;
		$m=$p2;
		$d=$p3;
	}
	//check 'd.m'
	if (($y == "") && ($p3=="") && ($p2>0 && $p2<13) && ($p1>0 && $p1<32)){
		$y=date("Y");
		$m=$p2;
		$d=$p1;
	}
	//check 'd'
	if (($y == "") && ($p3=="") && ($p2=="") && ($p1>0 && $p1<32)){
		$y=date("Y");
		$m=date("m");
		$d=$p1;
	}
	//add 1900 or 2000 to year
	if ($y!="" && $y<=99){
		if ($y>=70) $y = $y + 1900;
		if ($y< 70)  $y = $y + 2000;
	}
	if ($y!=""){
		if (checkdate($m, $d, $y))
		$datum="$y-$m-$d";
	}
	return $datum;
}
//
function datum_lang($datum){
	$token="-";
	$y = strtok($datum,$token);
	$m = strtok($token);
	$d = strtok($token);
	$DatumCH = (date("d. F Y", time(0,0,0,$m,$d,$y)));
	return $DatumCH;
}
//
function navigator($input){
if 	(empty($input)){ $input = @$HTTP_USER_AGENT; }
//prueft das betriebssystem (os)
if 		(strchr($input,"Win"))		{ 	$out["os"] = "Win";	}
elseif 	(strchr($input,"Mac"))		{ 	$out["os"] = "Mac";	}
elseif 	(strchr($input,"Linux"))	{ 	$out["os"] = "Linux";	}
elseif 	(strchr($input,"Unix"))		{ 	$out["os"] = "Unix";	}
elseif 	(strchr($input,"Amiga"))	{ 	$out["os"] = "Amiga";	}
else 	{	$out["os"] = "none";	}
//
//prueft den browser (navigator, version, release)
if 		(strchr($input,"MSIE")){
		$out["navigator"] = "IE";
		$version = strchr($input,"MSIE");
		$token=";";
		$version = strtok($version,$token);
		$token=" ";
		$version = strtok($version,$token);
		$version = strtok($token);
		$token=".";
		$version = strtok($version,$token);
		$release = strtok($token);
		$out["version"] = intval($version);
		$out["release"] = intval($release);
}
else {	$out["navigator"] = "NC";
		$token="[";
		$version = strtok($input,$token);
		$token="/";
		$version = strtok($version,$token);
		$version = strtok($token);
		$token=".";
		$version = strtok($version,$token);
		$release = strtok($token);
		$out["version"] = intval($version);
		$out["release"] = intval($release);
}
//
//prueft die sprache	(language))
if 		(strchr($input,"[de]"))	{ 	$out["language"] = "de";	}
elseif 	(strchr($input,"[en]"))	{ 	$out["language"] = "en";	}
elseif 	(strchr($input,"[fr]"))	{ 	$out["language"] = "fr";	}
else	{ 	$out["language"] = "de";	}
//
//
//giebt die daten aus
	return $out;
}
//
function datumsplitt($datum){
	$token="-";
	$out["y"] = strtok($datum,$token);
	$out["m"] = strtok($token);
	$out["d"] = strtok($token);
	return $out;
}
//
function month_array(){
	$out[1] = "Januar";
	$out[2] = "Februar";
	$out[3] = "M&auml;rz";
	$out[4] = "April";
	$out[5] = "Mai";
	$out[6] = "Juni";
	$out[7] = "Juli";
	$out[8] = "August";
	$out[9] = "September";
	$out[10] = "Oktober";
	$out[11] = "November";
	$out[12] = "Dezember";
	return $out;
}
//
function rc_filesize($size){
	if ($size < 1024){
		$result = $size. " Byte";
	} else {
		$result = (integer)($size / 1024);
		if ($result < 9900) {
			$result .= " KB";
		} else {
			$result = (integer)($size / 1024) . " MB";
		}
	}
	return $result;
}


function htmlflashen($input){
	$needle = "%0D%0A";
	$str = "%0A";
	$haystack = urlencode($input);
	$out = str_replace($needle,$str,$haystack);
	return $out;
}

//hier wird eine für flash codierte datei wieder für html lesbar gemacht.
function htmlflashde($haystack){
	$needle = "%0A";
	$str = "%0D%0A";
	$out = str_replace($needle,$str,$haystack);
	$out = urldecode($out);
	$out = stripslashes($out);
	//$out = htmlentities($out);
	return $out;
}

function cleanfilename($input){
	$string = eregi_replace("[ö]","oe",$input);
	$string = eregi_replace("[ä]","ae",$string);
	$string = eregi_replace("[ü]","ue",$string);
	$string = eregi_replace("[^[:alnum:]^.]","",$string);
	return $string;
}
?>
