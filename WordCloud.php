<?php
/**
 * Created by PhpStorm.
 * User: SidManoj
 * Date: 2/26/15
 * Time: 8:09 PM
 */

class WordCloud
{
    function getLyricsByArtist($artist)
    {
        include_once('simple_html_dom.php');
        // Create DOM from URL or file
        $artist = str_replace(" ", "-", $artist);
        $artist = strtolower($artist);
        $html = file_get_html('http://www.metrolyrics.com/' . $artist . '-lyrics.html');
        $song_links = array();
        $str = "";
        $song_size = 10;
        $massivesonglyrics = "";
        if (count($song_links > 10)) {
            $song_size = 10;
        } else {
            $song_size = count($song_links);
        }

        foreach ($html->find('a') as $element) {
            if (strpos($element, '-lyrics-' . $artist) !== false) {
                $song_links[] = $element->href;
            }
        }
        for ($x = 0; $x < $song_size; $x++) {
            $htmlsong = file_get_html($song_links[$x]);
            foreach ($htmlsong->find('div[id=lyrics-body-text]') as $lyrics) {
                $str = preg_replace("/\[([^\[\]]++|(?R))*+\]/", "", $lyrics);
                $massivesonglyrics = $massivesonglyrics . $str;
            }
        }
        return $massivesonglyrics;
    }


    function getSongsByWord($_word, $_artist)
    {
        include_once('simple_html_dom.php');
        // Create DOM from URL or file
        $artist = $_artist;
        $word = $_word;
        $artist = str_replace(" ", "-", $artist);
        $artist = strtolower($artist);
        $html = file_get_html('http://www.metrolyrics.com/' . $artist . '-lyrics.html');
        $song_links = array();
        $str = "";
        $song_size = 10;
        if (count($song_links > 10)) {
            $song_size = 10;
        } else {
            $song_size = count($song_links);
        }
        foreach ($html->find('a') as $element) {
            if (strpos($element, '-lyrics-' . $artist) !== false) {
                $song_links[] = $element->href;
            }
        }
        $array_songs = array();
        for ($x = 0; $x < $song_size; $x++) {
            $htmlsong = file_get_html($song_links[$x]);
            foreach ($htmlsong->find('div[id=lyrics-body-text]') as $lyrics) {
                $str = preg_replace("/\[([^\[\]]++|(?R))*+\]/", "", $lyrics);
                if (stripos($str, strtolower($word)) !== false || stripos($str, strtoupper($word)) !== false || stripos($str, $word) !== false) {
                    foreach ($htmlsong->find('title') as $title) {
                        $finaltitle = get_string_between($title->plaintext, "-", "Lyrics");
                        $array_songs[] = $finaltitle;
                    }
                }
            }
        }
        return $array_songs;
    }

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
                if (stripos($element, strtolower($song)) !== false || stripos($element, strtoupper($song)) !== false || stripos($element, $song) !== false) {
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
}
?>