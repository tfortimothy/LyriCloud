<?php

$toSearch = $_GET['word'];
$theArtist = $_GET['artist'];

function getLyricsByArtist()
{
    include_once('simple_html_dom.php');
    // Create DOM from URL or file
    //$artist = "Britney Spears";
    $artist = str_replace(" ","-",$artist);
    $artist = strtolower($artist);
    $html = file_get_html('http://www.metrolyrics.com/'. $artist . '-lyrics.html');
    $song_links = array();
    $str = "";
    $song_size = 99;
    $massivesonglyrics = "";
    if(count($song_links > 99)){
        $song_size = 99;
    }
    else{
        $song_size = count($song_links);
    }
    echo $song_size;
    foreach($html->find('a') as $element) {
        if (strpos($element,'-lyrics-' . $artist) !== false) {
            $song_links[] = $element->href;
        }
    }
    for($x = 0; $x<$song_size; $x++){
        $htmlsong = file_get_html($song_links[$x]);
        foreach($htmlsong->find('div[id=lyrics-body-text]') as $lyrics ) {
            $str = preg_replace("/\[([^\[\]]++|(?R))*+\]/", "", $lyrics);
            $massivesonglyrics = $massivesonglyrics . $str;
            echo $str;

        }
    }
    return $massivesonglyrics;


}
function getSongsByWord($word, $artist){
    include_once('simple_html_dom.php');
    // Create DOM from URL or file
    $artist = str_replace(" ","-",$artist);
    $artist = strtolower($artist);
    $html = file_get_html('http://www.metrolyrics.com/'. $artist . '-lyrics.html');
    $song_links = array();
    $str = "";
    $song_size = 10;
    if(count($song_links > 10)){
        $song_size = 10;
    }
    else{
        $song_size = count($song_links);
    }
    foreach($html->find('a') as $element) {
        if (strpos($element,'-lyrics-' . $artist) !== false) {
            $song_links[] = $element->href;
        }
    }
    $array_songs = array();
    for($x = 0; $x<$song_size; $x++){
        $htmlsong = file_get_html($song_links[$x]);
        foreach($htmlsong->find('div[id=lyrics-body-text]') as $lyrics ) {
            $str = preg_replace("/\[([^\[\]]++|(?R))*+\]/", "", $lyrics);
            if (strpos($str, strtolower($word)) !== false || strpos($str, strtoupper($word)) !== false ){
                foreach ($htmlsong->find('span[class=title]') as $title) {
                    $array_songs[] = $title;
                }
            }
        }
    }
    return $array_songs;
}

$songs = getSongsByWord($toSearch, $theArtist);
/*
for($x = 0; $x<count($hello); $x++){
    echo $hello[$x] . "</br>";
}
exit;
#getLyricsByArtist();
*/
?>
<html>
<head>
	<title> LyriCloud </title>
	<link rel="stylesheet" href="cloudStyle.css">
</head>
<body>
<?php 
	for($x = 0; $x<count($songs); $x++){
		echo $songs[$x] . "</br>";
	}
?>
</body>
</html>