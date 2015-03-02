<?php

function getLyricsBySong($_artist, $_song, $_word)
{
    include_once('simple_html_dom.php');
    // Create DOM from URL or file
    $artist = $_artist;
    $artist = str_replace(" ", "-", $artist);
    $artist = strtolower($artist);
    $song = $_song;
    #$song = str_replace(" ", "-", $song);
    $song = strtolower($song);
    $html = file_get_html('http://www.metrolyrics.com/' . $artist . '-lyrics.html');
    $song_links = "";
    $str = "";
    $massivesonglyrics = "";
    foreach ($html->find('a') as $element) {
        if (strpos($element, '-lyrics-' . $artist) !== false) {
            if (stripos($element, strtolower($song)) !== false || stripos($element, strtoupper($song)) !== false || stripos($element, $song) !== false){
                $song_links = $element->href;
                break;
            }
        }
    }
    $song_size = 1;
    $htmlsong = file_get_html($song_links);
    foreach ($htmlsong->find('div[id=lyrics-body-text]') as $lyrics) {
        $str = preg_replace("/\[([^\[\]]++|(?R))*+\]/", "", $lyrics);
        $massivesonglyrics = $massivesonglyrics . $str;
    }
    return $massivesonglyrics;
}

$artist = $_GET['artist'];
$song =  $_GET['song'];
$lyrics = getLyricsBySong($artist, $song, $_GET['word']);
$keyword =  $_GET['word'];
$lyrics = preg_replace("/\w*?".preg_quote($keyword)."\w*/i", "<span class='highlight'>$0</span>", $lyrics);
?>

<html>
<head>
	<link rel="stylesheet" href="css/lyricsPage.css">
</head>
<body>
	<header>
		<div id="header"><?php echo $song ?></div>
		<div id="artist"><?php echo $artist ?></div>
	</header>
	<div id="lyrics">
		<?php echo $lyrics ?>
	</div>
	<div id="buttons">
		<?php echo "<a href=\"specificWord.php?artist=$artist&word=$keyword\"><button id=\"songSelection\">Song Selection</button></a>" ?> 
		<a href="index.html"><button id="home">Word Cloud</button></a>
	</div>
</body>
</html>