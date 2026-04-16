<?php 
	require_once($_SERVER['DOCUMENT_ROOT']."/html/php/mysql_header.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>									
	<meta http-equiv="Content-Type"
 content="text/html; charset=utf-8">
	<link rel="stylesheet" href="../html/css/browser5.css"
 type="text/css">
	<title>Ganglion - Knotenpunkt menschlicher Beziehungen</title>
</head>
<body>
<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/html/php/navbar.php");
?>
<div class="tabltxt-dl">
<a id='podcast' href='/html/podcast.php'><img src='/images/pod.gif' /> Abonnieren Sie die Vortr&auml;ge als Podcast</a><br>
Downloads Vortr&auml;ge:&nbsp;
<?php
	($result = mysqli_query($conn1, "select sum(downloads) as sumd from vortrag"));
 	$values = mysqli_fetch_array($result);
	$total_downloads = $values['sumd'];
	echo number_format($total_downloads,0,".","'");
?>
&nbsp;(als PDF)&nbsp;
<?php
	($result = mysqli_query($conn1, "select sum(audiofile_downloads) as audiosumd from vortrag"));
 	$values = mysqli_fetch_array($result);
	$total_audio_downloads = $values['audiosumd'];
	echo number_format($total_audio_downloads,0,".","'");
?>
&nbsp;(als Audio-File)&nbsp;
<?php
	($result = mysqli_query($conn1, "select sum(google_video_downloads) as googlevideosumd from vortrag"));
 	$values = mysqli_fetch_array($result);
	$total_audio_downloads = $values['googlevideosumd'];
	echo number_format($total_audio_downloads,0,".","'");
?>
&nbsp;(als Video-File)
</div>
<div style="margin: 10px 5px;">
<div style="display: flex; align-items: center; gap: 12px; margin-bottom: 6px;">
  <label style="font: bold 13px Arial, Helvetica, sans-serif; color: #002050; cursor: pointer;">
    <input type="radio" name="fts-mode" value="search" checked onchange="ftsToggleMode()"> Volltextsuche
  </label>
  <label style="font: bold 13px Arial, Helvetica, sans-serif; color: #002050; cursor: pointer;">
    <input type="radio" name="fts-mode" value="ask" onchange="ftsToggleMode()"> Fragen (KI)
  </label>
</div>
<form id="fts-form" onsubmit="ftsSubmit(); return false;" style="display: flex; align-items: center; gap: 6px; margin: 0;">
  <input type="text" id="fts-input" placeholder="z.B. ADHS Schule" style="font: 13px Arial, Helvetica, sans-serif; padding: 4px 8px; border: 1px solid #002050; width: 300px;">
  <button type="submit" id="fts-submit-btn" style="font: bold 13px Arial, Helvetica, sans-serif; color: #e4e1ee; background: #002050; border: 1px solid #002050; padding: 4px 12px; cursor: pointer;">Suchen</button>
  <button type="button" onclick="ftsClear()" id="fts-clear-btn" style="font: bold 13px Arial, Helvetica, sans-serif; color: #002050; background: #d57530; border: 1px solid #002050; padding: 4px 12px; cursor: pointer; display: none;">Zur&uuml;cksetzen</button>
</form>
</div>
<div id="fts-results" style="display: none; margin: 0 5px 10px 5px; padding: 8px; background: #e9ac72; border: 1px solid #002050;">
  <div id="fts-results-header" style="font: bold 13px Arial, Helvetica, sans-serif; color: #002050; margin-bottom: 6px;"></div>
  <div id="fts-results-list"></div>
</div>
<script>
var ftsEventSource = null;

function ftsGetMode() {
  var radios = document.getElementsByName('fts-mode');
  for (var i = 0; i < radios.length; i++) {
    if (radios[i].checked) return radios[i].value;
  }
  return 'search';
}

function ftsToggleMode() {
  var mode = ftsGetMode();
  var input = document.getElementById('fts-input');
  var btn = document.getElementById('fts-submit-btn');
  if (mode === 'ask') {
    input.placeholder = 'z.B. Was hilft Kindern mit ADHS in der Schule?';
    input.style.width = '600px';
    btn.textContent = 'Fragen';
  } else {
    input.placeholder = 'z.B. ADHS Schule';
    input.style.width = '300px';
    btn.textContent = 'Suchen';
  }
}

function ftsSubmit() {
  if (ftsGetMode() === 'ask') {
    ftsAsk();
  } else {
    ftsSearch();
  }
}

function ftsSearch() {
  var q = document.getElementById('fts-input').value.trim();
  if (!q) return;
  var xhr = new XMLHttpRequest();
  xhr.open('GET', '/html/php/search_proxy.php?q=' + encodeURIComponent(q));
  xhr.onload = function() {
    var box = document.getElementById('fts-results');
    var header = document.getElementById('fts-results-header');
    var list = document.getElementById('fts-results-list');
    var clearBtn = document.getElementById('fts-clear-btn');
    if (xhr.status !== 200) {
      box.style.display = 'block';
      header.textContent = 'Fehler: Suchserver nicht erreichbar.';
      list.innerHTML = '';
      clearBtn.style.display = 'inline';
      return;
    }
    var data;
    try { data = JSON.parse(xhr.responseText); } catch(e) {
      box.style.display = 'block';
      header.textContent = 'Fehler beim Verarbeiten der Suchergebnisse.';
      list.innerHTML = '';
      clearBtn.style.display = 'inline';
      return;
    }
    if (data.error) {
      box.style.display = 'block';
      header.textContent = data.error;
      list.innerHTML = '';
      clearBtn.style.display = 'inline';
      return;
    }
    if (!data.length) {
      box.style.display = 'block';
      header.textContent = 'Keine Ergebnisse f\u00fcr "' + q + '".';
      list.innerHTML = '';
      clearBtn.style.display = 'inline';
      return;
    }
    box.style.display = 'block';
    header.textContent = data.length + ' Ergebnis' + (data.length !== 1 ? 'se' : '') + ' f\u00fcr "' + q + '":';
    var html = '<table style="width:100%; border-collapse: collapse;">';
    html += '<tr><th style="text-align:left; padding: 3px 6px;">Titel</th><th style="text-align:left; padding: 3px 6px;">Datum</th><th style="text-align:left; padding: 3px 6px;">Textstelle</th></tr>';
    for (var i = 0; i < data.length; i++) {
      var r = data[i];
      var bg = (i % 2 === 1) ? ' background: #fca455;' : '';
      var link = r.vortrag_id ? '/html/php/download_vortrag.php?id=' + encodeURIComponent(r.vortrag_id) + '&download=pdf' : '#';
      html += '<tr style="' + bg + '">';
      html += '<td style="padding: 3px 6px;"><a href="' + link + '" target="_blank" style="color: #002050; text-decoration: underline;">' + (r.title || r.filename) + '</a></td>';
      html += '<td style="padding: 3px 6px; white-space: nowrap;">' + (r.date || '') + '</td>';
      html += '<td style="padding: 3px 6px; font-size: 12px;">' + (r.snippet || '') + '</td>';
      html += '</tr>';
    }
    html += '</table>';
    list.innerHTML = html;
    clearBtn.style.display = 'inline';
  };
  xhr.onerror = function() {
    document.getElementById('fts-results').style.display = 'block';
    document.getElementById('fts-results-header').textContent = 'Fehler: Suchserver nicht erreichbar.';
    document.getElementById('fts-results-list').innerHTML = '';
    document.getElementById('fts-clear-btn').style.display = 'inline';
  };
  xhr.send();
}

function ftsAsk() {
  var q = document.getElementById('fts-input').value.trim();
  if (!q) return;
  if (ftsEventSource) { ftsEventSource.close(); ftsEventSource = null; }

  var box = document.getElementById('fts-results');
  var header = document.getElementById('fts-results-header');
  var list = document.getElementById('fts-results-list');
  var clearBtn = document.getElementById('fts-clear-btn');
  var submitBtn = document.getElementById('fts-submit-btn');

  box.style.display = 'block';
  header.textContent = 'Frage: "' + q + '"';
  list.innerHTML = '<div id="fts-ask-sources"></div><div id="fts-ask-loading" style="margin-top: 8px; font: italic 13px Arial, Helvetica, sans-serif; color: #002050;">Antwort wird erstellt ...</div><div id="fts-ask-answer" style="margin-top: 8px; white-space: pre-wrap; font: 13px Arial, Helvetica, sans-serif; color: #002050; line-height: 1.5; display: none;"></div>';
  clearBtn.style.display = 'inline';
  submitBtn.disabled = true;
  submitBtn.textContent = 'Bitte warten...';

  // Use fetch + ReadableStream for SSE via POST proxy
  fetch('/html/php/ask_proxy.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ question: q })
  }).then(function(response) {
    if (!response.ok) {
      header.textContent = 'Fehler: Suchserver nicht erreichbar.';
      submitBtn.disabled = false;
      submitBtn.textContent = 'Fragen';
      return;
    }
    var reader = response.body.getReader();
    var decoder = new TextDecoder();
    var buffer = '';

    function processStream() {
      reader.read().then(function(result) {
        if (result.done) {
          submitBtn.disabled = false;
          submitBtn.textContent = 'Fragen';
          return;
        }
        buffer += decoder.decode(result.value, { stream: true });
        var lines = buffer.split('\n');
        buffer = lines.pop();
        for (var i = 0; i < lines.length; i++) {
          var line = lines[i].trim();
          if (line.indexOf('data: ') !== 0) continue;
          var jsonStr = line.substring(6);
          try {
            var msg = JSON.parse(jsonStr);
          } catch(e) { continue; }

          if (msg.type === 'sources' && msg.sources) {
            var srcDiv = document.getElementById('fts-ask-sources');
            if (msg.sources.length > 0) {
              var srcHtml = '<strong>Quellen:</strong> ';
              for (var s = 0; s < msg.sources.length; s++) {
                var src = msg.sources[s];
                var srcLink = src.vortrag_id ? '/html/php/download_vortrag.php?id=' + encodeURIComponent(src.vortrag_id) + '&download=pdf' : '#';
                if (s > 0) srcHtml += ', ';
                srcHtml += '<a href="' + srcLink + '" target="_blank" style="color: #002050; text-decoration: underline;">' + (src.title || src.filename) + '</a>';
              }
              srcDiv.innerHTML = srcHtml;
            }
          } else if (msg.type === 'token' && msg.content) {
            var loading = document.getElementById('fts-ask-loading');
            if (loading) loading.style.display = 'none';
            var ansDiv = document.getElementById('fts-ask-answer');
            ansDiv.style.display = 'block';
            ansDiv.textContent += msg.content;
          } else if (msg.type === 'error') {
            var loading = document.getElementById('fts-ask-loading');
            if (loading) loading.style.display = 'none';
            var ansDiv = document.getElementById('fts-ask-answer');
            ansDiv.style.display = 'block';
            ansDiv.textContent += '\nFehler: ' + (msg.content || 'Unbekannter Fehler');
            submitBtn.disabled = false;
            submitBtn.textContent = 'Fragen';
          } else if (msg.type === 'done') {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Fragen';
          }
        }
        processStream();
      });
    }
    processStream();
  }).catch(function(err) {
    header.textContent = 'Fehler: Suchserver nicht erreichbar.';
    list.innerHTML = '';
    submitBtn.disabled = false;
    submitBtn.textContent = 'Fragen';
  });
}

function ftsClear() {
  if (ftsEventSource) { ftsEventSource.close(); ftsEventSource = null; }
  document.getElementById('fts-input').value = '';
  document.getElementById('fts-results').style.display = 'none';
  document.getElementById('fts-results-list').innerHTML = '';
  document.getElementById('fts-clear-btn').style.display = 'none';
  var btn = document.getElementById('fts-submit-btn');
  btn.disabled = false;
  btn.textContent = ftsGetMode() === 'ask' ? 'Fragen' : 'Suchen';
}
</script>
<table>
<?php 
$url = $_SERVER["PHP_SELF"];
$valid = array
(
"Titel"			=>	"Titel",
"Thema"			=>	"thema",
"Gelesen"		=>	"hits",
"Downloads"	=>	"downloads",
"AudioFileDownloads"	=>	"audiofile_downloads",
"Gehalten"	=>	"gehalten",
);
if(isset($_GET["orderby"]) && isset($valid[$_GET["orderby"]]))
{
$orderby = $valid[$_GET["orderby"]];
}
else
{
$orderby = "Gehalten";
}
if(isset($_GET["orderdir"]) && $_GET["orderdir"] == "asc")
{
$orderdir = "asc";
}
else
{
$orderdir = "desc";
}
$directions = array
(
"Titel"			=>	"asc",
"thema"			=>	"asc",
"hits"			=>	"asc",
"downloads"	=>	"asc",
"gehalten"	=>	"asc",
"audiofile_downloads"	=>	"asc",
);
if($orderdir == "asc")
{
$directions[$orderby] = "desc";
}
?>
<table>
<tr>
<!--	<td class="tabltxt-r-bg" colspan="6">&Uuml;bersicht Themen:</td>-->
<td ID= "SiteTitel">Ursula Davatz - Vortr&auml;ge&nbsp;</td>
<td colspan="8" class="tabltxt-r">
<?php //getmenu.php

if (@$new == "true" || @$change == "true"){
	$result = mysqli_query($conn1, "SELECT * FROM thema ORDER BY thema ASC");
	$i=0;
	$lastThema="";
?>

		<input type="hidden" name="page" value="<?php echo $page ?>">
		<input type="hidden" name="sortby" value="standart">
		<select name="searchnew" size="1">
<?php
	if ($new == "true"){
		echo "<option value='1' selected>Bitte w&auml;hlen...</option>\n";
		$thema = "";
	}
	$thema_id = $thema;
	while ($row = mysqli_fetch_array($result)){
	 		$idWWW = $row["id_thema"];
	 		$thema = urldecode($row["thema"]);
	 		$select = "";
	 		if ($idWWW == $thema_id) $select = "selected";
	 		echo "<option value='".htmlspecialchars($idWWW, ENT_QUOTES, 'UTF-8')."' $select>".htmlspecialchars($thema, ENT_QUOTES, 'UTF-8')."</option>\n";
		  	$i++;
	}
	echo "</select>\n";

} 
else 
{
	if(!isset($table)) $table = "vortrag";
	$result = mysqli_query($conn1, "SELECT id_thema, thema, thema_id FROM thema AS A, $table AS B WHERE A.id_thema=B.thema_id GROUP BY id_thema ORDER BY thema ASC");
	$lastThema="";
?>
<form method="get" action="vortraege.php" name="themen">
<select name="search" size="1" onChange='this.form.submit()'>		
<?php
$search = $_GET["search"] or "";
if ($search == "all"){ $select = "selected"; }
	echo"<option value='all' $select>alle Themen</option>";
	
	while ($row = mysqli_fetch_array($result)){
	 		$id = $row["id_thema"];
	 		$thema = urldecode($row["thema"]);
	 		$select = "";
	 		if ($id == $search){ $select = "selected"; }
	 			echo "<option value='".htmlspecialchars($id, ENT_QUOTES, 'UTF-8')."' $select>".htmlspecialchars($thema, ENT_QUOTES, 'UTF-8')."</option>\n";
			$lastThema=$row["thema"];
	}
	echo "</select>\n";
	echo "</form>\n";
}
mysqli_free_result($result);
?>
	</td>
</tr>
	<tr>
	<th>N&auml;chster Vortrag<br>
	</th>
	<th><a class="th" href="<?php	echo $url."?orderby=Titel&amp;orderdir=".$directions["Titel"];?>">Titel sortieren</a><br>
	</th>
	<th><a class="th" href="<?php echo	$url."?orderby=Thema&amp;orderdir=".$directions["thema"];?>">Themen sortieren</a><br>
	</th>
	<th>Info<br>
	</th>
	<th>PDF / Video<br>
	</th>
	<th>Audio-File<br>
	</th>
	<th><a class="th" href="<?php echo	$url."?orderby=Downloads&amp;orderdir=".$directions["downloads"];?>">PDF Downloads</a><br>
	</th>
	<th><a class="th" href="<?php echo	$url."?orderby=AudioFileDownloads&amp;orderdir=".$directions["audiofile_downloads"];?>">Audio / Video File Downloads</a><br>
	</th>
	<th><a class="th" href="<?php echo	$url."?orderby=Gehalten&amp;orderdir=".$directions["gehalten"];?>">Gehalten</a><br>
	</th>
	</tr>
	<tr>
<?php
		
		if(!empty($search) && $search != "all")
		{
			$thema_condition = "thema_id='".mysqli_real_escape_string($conn1,$search)."'";
		}
		else
		{
			$thema_condition = "thema_id!=255";
		}
		$query = "select Titel, thema, pdf, audiofile, audiofile_size, audiofile_downloads, id, google_video_url, google_video_size, google_video_downloads, downloads, zeit, Zielpublikum, location, date_format(gehalten,'%d.%m.%Y') 
							as gehalten_formatted 
							from vortrag, thema
							where $thema_condition and id_thema=thema_id
							order by ".$orderby." ".$orderdir;
		$vortrag_result = mysqli_query($conn1, $query);
		echo	'<td valign="top" rowspan="'.(mysqli_num_rows($vortrag_result)+1).'" colspan="1" width="25%">';
		
		$query = "select Titel, thema, Zusammenfassung, zeit, Zielpublikum, location, id, date_format(gehalten,'%d.%m.%Y') 
							as gehalten_formatted, unix_timestamp(gehalten) as gehalten_unix,
							google_video_url
							from vortrag, thema 
							where thema_id!=255 and id_thema=thema_id
							and gehalten >= now()
							order by gehalten ASC limit 1";
							
		$result = mysqli_query($conn1, $query);
		$values = mysqli_fetch_assoc($result);
		echo "<table class='nopaddingTABLE'>";
		echo "<tr>";
		echo "<td colspan='2' class='TDbold-big'>";
		echo htmlspecialchars(urldecode ($values["Titel"]), ENT_QUOTES, 'UTF-8');
		echo "</td>\n";
		echo "</tr>";
		echo "<tr>\n";
		if (!empty($values["gehalten_formatted"]))
			{
				echo '<td>Datum:</td><td class="TDbold">'.htmlspecialchars(stripslashes(urldecode($values["gehalten_formatted"])), ENT_QUOTES, 'UTF-8').'</td>';
			}
		echo "</tr>";
		echo "<tr>";
		$time_H = date("h",$values["zeit"]);
		$time_M = date("i",$values["zeit"]);
		if (!empty($values["zeit"]))
			{
				echo '<td>Zeit:</td><td class="TDbold">'.strftime('%H:%M' ,$values["zeit"]).'</td>';
			}
		echo "</tr>";
		echo "<tr>";
		if (!empty($values["location"]))
			{
				echo '<td>Ort:</td><td class="TDbold">'.htmlspecialchars(stripslashes(urldecode($values["location"])), ENT_QUOTES, 'UTF-8').'</td>';
			}
		echo "</tr>";
		if (!empty($values["thema"]))
			{
				echo '<tr><td class="nopaddingTABLE" colspan="2">Ein Vortrag zum Thema:</td></tr>';
				echo '<tr><td class="nopaddingTABLE" colspan="2">'.htmlspecialchars(stripslashes(urldecode($values["thema"])), ENT_QUOTES, 'UTF-8').'</td></tr>';
			}
		echo "</table>";
		echo "</td>";
		$open_row = false;
		
		while($values = mysqli_fetch_assoc($vortrag_result))
		{
			if($open_row)
			{
				echo "<tr class='tabltxt-l".$suffix."'>";
			}
			else
			{
				$open_row = true;
			}
			$umfeld = array();
			if (!empty($values["Zielpublikum"]))
			{
				$umfeld[] = 'Zielpublikum: '.htmlspecialchars(urldecode($values["Zielpublikum"]), ENT_QUOTES, 'UTF-8');
			}
			if (!empty($values["location"]))
			{
				$umfeld[] = 'Ort: '.htmlspecialchars(urldecode($values["location"]), ENT_QUOTES, 'UTF-8');
			}
			$zieltext = implode(', ', $umfeld);
			echo "<td>";
			if(empty($values["google_video_url"]))
			{
				echo htmlspecialchars(stripslashes(urldecode ($values["Titel"])), ENT_QUOTES, 'UTF-8');
			}
			else
			{
 				list($google_video_hours, $google_video_minutes, $google_video_seconds) = explode(":", $values["google_video_size"]);
 				$videoLength = htmlspecialchars($google_video_hours."h ".$google_video_minutes."m ".$google_video_seconds."s", ENT_QUOTES, 'UTF-8');
 				echo "<a class='links".$suffix."'	href='/html/php/download_vortrag.php?id=".htmlspecialchars($values["id"], ENT_QUOTES, 'UTF-8')."&amp;download=google_video' alt='Google Video: ".$videoLength."' title='Google Video: ".$videoLength."' target='_blank'>
 						".htmlspecialchars(stripslashes(urldecode ($values["Titel"])), ENT_QUOTES, 'UTF-8')."
				</a>";
			}	
			echo "</td>";
			
			echo "<td class='tabltxt-l"."'>".htmlspecialchars(stripslashes(urldecode ($values["thema"])), ENT_QUOTES, 'UTF-8')."</td>";
			echo "<td>";
			$popurl = "popup_vortrag.php?id=".urlencode($values["id"]);
			$script = 'window.open("'.$popurl.'", "popup", "menubar=no,resizable=no,scrollbars=yes,height=400,locationbar=no,toolbar=yes,width=500").focus(); return false';
			echo "<a class='big-dot' href='$popurl' onClick='".$script."'>?</a>";
			echo "</td>";
			echo "<td class='tabltxt-c"."'>";
			if(empty($values["pdf"]))
			{
				echo "";
			}
			else
			{
				echo "<a class='pdf-ico".$suffix."'	href='/html/php/download_vortrag.php?id=".htmlspecialchars($values["id"], ENT_QUOTES, 'UTF-8')."&amp;download=pdf'
				target='_blank'><img src='../html/images/adobe.gif' alt='PDF File'></a>";
				if(empty($values["google_video_url"])) {
					echo "";
				} else {
					echo "&nbsp";
				}
			}
			if(empty($values["google_video_url"])) {
				echo "";
			} else {
				echo "<a class='pdf-ico".$suffix."'	href='/html/php/download_vortrag.php?id=".htmlspecialchars($values["id"], ENT_QUOTES, 'UTF-8')."&amp;download=google_video'
				target='_blank'><img src='../html/images/google_video.gif' alt='Google Video: ".$videoLength."' title='Google Video: ".$videoLength."'></a>";
			}
			echo "</td>";
			echo "<td class='tabltxt-l"."'>";
			if(empty($values["audiofile"])) {
				echo "&nbsp;";
			} else {
				$sizeMb = strval(round($values["audiofile_size"]/1024/1024, 2))."M";
				echo "<audio controls='pdf-ico"."'	src='/html/php/download_vortrag.php?id=".htmlspecialchars($values["id"], ENT_QUOTES, 'UTF-8')."&amp;download=audiofile'
				target='_blank'><img src='../html/images/audiofile.gif' alt='Audio File'>".$sizeMb."</audio>";
			}
			echo "</td>";
			echo "<td class='tabltxt-c"."'>".htmlspecialchars(urldecode ($values["downloads"]), ENT_QUOTES, 'UTF-8')."</td>";
			echo "<td class='tabltxt-c"."'>".htmlspecialchars(urldecode ($values["audiofile_downloads"]), ENT_QUOTES, 'UTF-8')." / ".htmlspecialchars(urldecode ($values["google_video_downloads"]), ENT_QUOTES, 'UTF-8')."</td>";
			echo "<td class='tabltxt-c"."'>".htmlspecialchars($values["gehalten_formatted"], ENT_QUOTES, 'UTF-8')."</td>";
			echo "</tr>\n";
			if(empty($suffix))
			{
				$suffix = "-bg";
			}
			else
			{
				$suffix = "";
			}

		}
?>
</table>
</body>
</html>
