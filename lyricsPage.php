<?php

function getLyricsBySong($_artist, $_song)
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

$lyrics = getLyricsBySong($_GET['artist'], $_GET['song']);

echo $lyrics;
?>