<?php //browser.php

$navigator = navigator(@$HTTP_USER_AGENT);
$OS = $navigator["os"];
$NAV = $navigator["navigator"];
$version = $navigator["version"];
$release = $navigator["release"];

if($version>=5){
	$css = "browser5.css";
}
elseif($OS=="Win"&&$NAV=="IE"){
	$css = "browser5.css";
}
elseif ($OS == "Win" && $NAV == "NC"){
	$css = "WinNC.css";
}

elseif ($OS == "Mac" && $NAV == "IE"){
	$css = "IE4mac.css";

}
elseif ($OS == "Mac" && $NAV == "NC") {
	$css = "NC4mac.css";
}

elseif ($OS == "Linux" && $NAV == "NC"){
	$css = "WinNC.css";
}

else{
	$css = "WinNC.css";;
}
if (isset($css)){
	$css = "<link rel='stylesheet' href='../css/$css' type='text/css'>";
}

?>
