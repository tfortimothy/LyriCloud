<?php

$toSearch = $_GET['word'];
$theArtist = $_GET['artist'];

function getLyricsByArtist($_artist)
{
    $artist= $_artist;
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
function getSongsByWord($_word, $_artist){
    include_once('simple_html_dom.php');
    // Create DOM from URL or file
    $artist= $_artist;
    $word = $_word;
    $artist = str_replace(" ","-",$artist);
    $artist = strtolower($artist);
    $html = file_get_html('http://www.metrolyrics.com/'. $artist . '-lyrics.html');
    $song_links = array();
    $str = "";
    $song_size = 30;
    if(count($song_links > 30)){
        $song_size = 30;
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
            if (stripos($str, strtolower($word)) !== false || stripos($str, strtoupper($word)) !== false || stripos($str, $word) !== false){
                foreach ($htmlsong->find('title') as $title) {
                    $finaltitle = get_string_between($title->plaintext, "-", "Lyrics");
                    $array_songs[] = $finaltitle;
                }
            }
        }
    }
    return $array_songs;
}
$songs = array();
$songs = getSongsByWord($toSearch, $theArtist);
function get_string_between($string, $start, $end){
    $string = " ".$string;
    $ini = strpos($string,$start);
    if ($ini == 0) return "";
    $ini += strlen($start);
    $len = strpos($string,$end,$ini) - $ini;
    return substr($string,$ini,$len);
}

?>
<html>
<body>
<?php 
	$formattedArtistName = str_replace(" ","%20",$theArtist);
    $formattedWord = $toSearch;
	for($x = 0; $x<count($songs); $x++){
        $formattedSongName = $songs[$x];
		echo "<a href=\"lyricsPage.php?artist=$formattedArtistName&song=$formattedSongName&word=$formattedWord\">$songs[$x]</a><br>";
	}
?>
</body>
</html>