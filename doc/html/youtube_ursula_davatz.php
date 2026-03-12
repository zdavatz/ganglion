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
	<title>Ganglion - YouTube Videos</title>
</head>
<body>
<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/html/php/navbar.php");
?>
<br>
<table>
<tr>
<td ID="SiteTitel">Ursula Davatz - YouTube Videos</td>
</tr>
</table>
<?php
$keyFile = $_SERVER['DOCUMENT_ROOT'] . '/../.yt-keys';
$apiKey = trim(file_get_contents($keyFile));
$channelId = 'UCDZ9tWjHLJIvwwl40XbaT1w';
$uploadsPlaylistId = 'UUDZ9tWjHLJIvwwl40XbaT1w';

// Cache results for 1 hour to conserve API quota
$cacheVersion = 2;
$cacheFile = sys_get_temp_dir() . '/yt_cache_v' . $cacheVersion . '_' . md5($channelId) . '.json';
$cacheMaxAge = 3600;
$videos = null;

if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheMaxAge) {
	$videos = json_decode(file_get_contents($cacheFile), true);
}

if ($videos === null) {
	$videos = array();
	$videoIds = array();
	$nextPageToken = '';

	// Step 1: Get all video IDs from uploads playlist
	do {
		$plUrl = 'https://www.googleapis.com/youtube/v3/playlistItems'
			. '?part=snippet'
			. '&playlistId=' . urlencode($uploadsPlaylistId)
			. '&maxResults=50'
			. '&key=' . urlencode($apiKey);
		if (!empty($nextPageToken)) {
			$plUrl .= '&pageToken=' . urlencode($nextPageToken);
		}
		$plResponse = @file_get_contents($plUrl);
		if ($plResponse === false) {
			break;
		}
		$plData = json_decode($plResponse, true);
		if (!isset($plData['items'])) {
			break;
		}
		foreach ($plData['items'] as $item) {
			$videoIds[] = $item['snippet']['resourceId']['videoId'];
		}
		$nextPageToken = isset($plData['nextPageToken']) ? $plData['nextPageToken'] : '';
	} while (!empty($nextPageToken));

	// Step 2: Get video details (statistics + snippet) in batches of 50
	for ($i = 0; $i < count($videoIds); $i += 50) {
		$batch = array_slice($videoIds, $i, 50);
		$vUrl = 'https://www.googleapis.com/youtube/v3/videos'
			. '?part=snippet,statistics'
			. '&id=' . urlencode(implode(',', $batch))
			. '&key=' . urlencode($apiKey);
		$vResponse = @file_get_contents($vUrl);
		if ($vResponse === false) {
			continue;
		}
		$vData = json_decode($vResponse, true);
		if (!isset($vData['items'])) {
			continue;
		}
		foreach ($vData['items'] as $v) {
			$videos[] = array(
				'id'          => $v['id'],
				'title'       => $v['snippet']['title'],
				'description' => $v['snippet']['description'],
				'published'   => $v['snippet']['publishedAt'],
				'thumbnail'   => isset($v['snippet']['thumbnails']['medium']['url'])
					? $v['snippet']['thumbnails']['medium']['url']
					: $v['snippet']['thumbnails']['default']['url'],
				'views'       => isset($v['statistics']['viewCount']) ? (int)$v['statistics']['viewCount'] : 0,
				'likes'       => isset($v['statistics']['likeCount']) ? (int)$v['statistics']['likeCount'] : 0,
				'comments'    => isset($v['statistics']['commentCount']) ? (int)$v['statistics']['commentCount'] : 0,
			);
		}
	}

	// Cache unsorted results
	@file_put_contents($cacheFile, json_encode($videos));
}

// Sorting
$url = $_SERVER["PHP_SELF"];
$valid = array(
	'Titel'          => 'title',
	'Aufrufe'        => 'views',
	'Likes'          => 'likes',
	'Kommentare'     => 'comments',
	'Veroeffentlicht' => 'published',
);
if (isset($_GET['orderby']) && isset($valid[$_GET['orderby']])) {
	$orderby = $valid[$_GET['orderby']];
} else {
	$orderby = 'views';
}
if (isset($_GET['orderdir']) && $_GET['orderdir'] == 'asc') {
	$orderdir = 'asc';
} else {
	$orderdir = 'desc';
}
$directions = array(
	'title'     => 'asc',
	'views'     => 'asc',
	'likes'     => 'asc',
	'comments'  => 'asc',
	'published' => 'asc',
);
if ($orderdir == 'asc') {
	$directions[$orderby] = 'desc';
}
usort($videos, function($a, $b) use ($orderby, $orderdir) {
	if ($orderby == 'title') {
		$cmp = strcasecmp($a['title'], $b['title']);
	} elseif ($orderby == 'published') {
		$cmp = strcmp($a['published'], $b['published']);
	} else {
		$cmp = $a[$orderby] - $b[$orderby];
	}
	return ($orderdir == 'asc') ? $cmp : -$cmp;
});

if (empty($videos)) {
	echo '<p>Keine Videos gefunden.</p>';
} else {
	echo '<table>';
	echo '<tr>';
	echo '<th>Nr.</th>';
	echo '<th>Vorschau</th>';
	echo '<th><a class="th" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '?orderby=Titel&amp;orderdir=' . $directions['title'] . '">Titel sortieren</a></th>';
	echo '<th><a class="th" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '?orderby=Aufrufe&amp;orderdir=' . $directions['views'] . '">Aufrufe sortieren</a></th>';
	echo '<th><a class="th" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '?orderby=Likes&amp;orderdir=' . $directions['likes'] . '">Likes sortieren</a></th>';
	echo '<th><a class="th" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '?orderby=Kommentare&amp;orderdir=' . $directions['comments'] . '">Kommentare sortieren</a></th>';
	echo '<th><a class="th" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '?orderby=Veroeffentlicht&amp;orderdir=' . $directions['published'] . '">Ver&ouml;ffentlicht sortieren</a></th>';
	echo '</tr>';
	$suffix = '';
	$nr = 1;
	foreach ($videos as $video) {
		$pubDate = date('d.m.Y', strtotime($video['published']));
		echo '<tr class="tabltxt-l' . $suffix . '">';
		echo '<td class="tabltxt-c">' . $nr . '</td>';
		echo '<td><a href="https://www.youtube.com/watch?v=' . htmlspecialchars($video['id'], ENT_QUOTES, 'UTF-8') . '" target="_blank">';
		echo '<img src="' . htmlspecialchars($video['thumbnail'], ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($video['title'], ENT_QUOTES, 'UTF-8') . '" width="160"></a></td>';
		echo '<td><a class="links' . $suffix . '" href="https://www.youtube.com/watch?v=' . htmlspecialchars($video['id'], ENT_QUOTES, 'UTF-8') . '" target="_blank">';
		echo htmlspecialchars($video['title'], ENT_QUOTES, 'UTF-8') . '</a></td>';
		echo '<td class="tabltxt-c">' . number_format($video['views'], 0, '.', "'") . '</td>';
		echo '<td class="tabltxt-c">' . number_format($video['likes'], 0, '.', "'") . '</td>';
		echo '<td class="tabltxt-c">' . number_format($video['comments'], 0, '.', "'") . '</td>';
		echo '<td class="tabltxt-c">' . htmlspecialchars($pubDate, ENT_QUOTES, 'UTF-8') . '</td>';
		echo '</tr>' . "\n";
		$suffix = empty($suffix) ? '-bg' : '';
		$nr++;
	}
	echo '</table>';
}
?>
</body>
</html>
