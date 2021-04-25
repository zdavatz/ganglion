<?php //function.php
/*
 *  Class mime_mail
 *  Original implementation by Sascha Schumann <sascha@schumann.cx>
 *  Modified by Tobias Ratschiller <tobias@dnet.it>:
 *      - General code clean-up
 *      - separate body- and from-property
 *      - killed some mostly un-necessary stuff
 */ 
 
class mime_mail 
 {
 var $parts;
 var $to;
 var $from;
 var $headers;
 var $subject;
 var $body;

  /*
  *     void mime_mail()
  *     class constructor
  */         
 function mime_mail()
  {
  $this->parts = array();
  $this->to =  "";
  $this->from =  "";
  $this->subject =  "";
  $this->body =  "";
  $this->headers =  "";
  }

  /*
  *     void add_attachment(string message, [string name], [string ctype])
  *     Add an attachment to the mail object
  */ 
 function add_attachment($message, $name =  "", $ctype =  "application/octet-stream")
  {
  $this->parts[] = array (
                           "ctype" => $ctype,
                           "message" => $message,
                           "encode" => $encode,
                           "name" => $name
                          );
  }

/*
 *      void build_message(array part=
 *      Build message parts of an multipart mail
 */ 
function build_message($part)
 {
 $message = $part[ "message"];
 $message = chunk_split(base64_encode($message));
 $encoding =  "base64";
 return  "Content-Type: ".$part[ "ctype"].
                        ($part[ "name"]? "; name = \"".$part[ "name"]. "\"" :  "").
                         "\nContent-Transfer-Encoding: $encoding\n\n$message\n";
 }

/*
 *      void build_multipart()
 *      Build a multipart mail
 */ 
function build_multipart() 
 {
 $boundary =  "b".md5(uniqid(time()));
 $multipart =  "Content-Type: multipart/mixed; boundary = $boundary\n\nThis is a MIME encoded message.\n\n--$boundary";

 for($i = sizeof($this->parts)-1; $i >= 0; $i--) 
    {
    $multipart .=  "\n".$this->build_message($this->parts[$i]). "--$boundary";
    }
 return $multipart.=  "--\n";
 }

/*
 *      void send()
 *      Send the mail (last class-function to be called)
 */ 
 
function send() 
 {
 $mime =  "";
 if (!empty($this->from))
    $mime .=  "From: ".$this->from. "\n";
 if (!empty($this->headers))
    $mime .= $this->headers. "\n";
    
 if (!empty($this->body))
    $this->add_attachment($this->body,  "",  "text/plain");   
 $mime .=  "MIME-Version: 1.0\n".$this->build_multipart();
 mail($this->to, $this->subject,  "", $mime);
 }
};  // end of class 

/*
 * Example usage
 *
 
 $attachment = fread(fopen("test.jpg", "r"), filesize("test.jpg")); 

 $mail = new mime_mail();
 $mail->from = "foo@bar.com";
 $mail->headers = "Errors-To: foo@bar.com";
 $mail->to = "bar@foo.com";
 $mail->subject = "Testing...";
 $mail->body = "This is just a test.";
 $mail->add_attachment("$attachment", "test.jpg", "image/jpeg");
 $mail->send();
 
 */ 
 
 
 
function datum_ch($datum){
	$token="-";
	$y = strtok($datum,$token);
	$m = strtok($token);
	$d = strtok($token);
	$DatumCH = (date("d.m.Y", mktime(0,0,0,$m,$d,$y)));
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
function deStampDate($stampedDate){
	$year=substr($stampedDate, 0,4);
	$month=substr($stampedDate, 4,2);
	$day=substr($stampedDate, 6,2);
	$hour=substr($stampedDate, 8,2);
	$minute=substr($stampedDate, 10,2);
	$second=substr($stampedDate, 12,2);
	$UXStamp=mktime($hour,$minute,$second,$month,$day,$year);
	$deStampDate=date("j.n.Y", $UXStamp);
	return $deStampDate;
}
//
function deStampTime($stampedDate){
	$year=substr($stampedDate, 0,4);
	$month=substr($stampedDate, 4,2);
	$day=substr($stampedDate, 6,2);
	$hour=substr($stampedDate, 8,2);
	$minute=substr($stampedDate, 10,2);
	$second=substr($stampedDate, 12,2);
	$UXStamp=mktime($hour,$minute,$second,$month,$day,$year);
	$deStampTime=date("H:i", $UXStamp);
	return $deStampTime;
}
//
function navigator($input){
if 	(empty($input)){ $input = @$HTTP_USER_AGENT; }
//prft das betriebssystem (os)
if 		(strchr($input,"Win"))		{ 	$out["os"] = "Win";	}
elseif 	(strchr($input,"Mac"))		{ 	$out["os"] = "Mac";	}
elseif 	(strchr($input,"Linux"))	{ 	$out["os"] = "Linux";	}
elseif 	(strchr($input,"Unix"))		{ 	$out["os"] = "Unix";	}
elseif 	(strchr($input,"Amiga"))	{ 	$out["os"] = "Amiga";	}
else 	{	$out["os"] = "none";	}
//
//prft den browser (navigator, version, release)
if 		(strchr($input,"MSIE")){ 	
		$out["navigator"] = "IE";
		$version = strchr($input,"MSIE");
		$token=";";
		$version = strtok($version,$token);
		$token=" ";
		$version = strtok($version,$token);
		$version = strtok($token);
		$token=".";
		$out["version"] = strtok($version,$token);
		$out["release"] = strtok($token);
}
else {	$out["navigator"] = "NC";
		$token="[";
		$version = strtok($input,$token);
		$token="/";
		$version = strtok($version,$token);
		$version = strtok($token);
		$token=".";
		$out["version"] = strtok($version,$token);
		$out["release"] = strtok($token);
}       	
//
//prft die sprache	(language))
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
function htmlflashen($input){
$haystack = urlencode($input);
$result = str_replace("%0D", "%0D%0A", $haystack);
$haystack = urldecode($result);
return $haystack;
}

function getPointer($myArray, $myValue){
	$i=0;
	while ($compare = array_shift($myArray)){
		if ($compare == $myValue){
			$pointer=$i;
			break;
		}
		$i++;
	}
	return $pointer;
}
?>
