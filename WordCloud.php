<?php
class WordCloud
{
	function get_string_between($string, $start, $end){
		$string = " ".$string;
		$ini = strpos($string,$start);
		if ($ini == 0) return "";
		$ini += strlen($start);
		$len = strpos($string,$end,$ini) - $ini;
		return substr($string,$ini,$len);
	}
	
    function getLyricsByArtist($artist, $site, $upperSongLimit)
    {
        include_once('simple_html_dom.php');
        // Create DOM from URL or file
        $artist = str_replace(" ", "-", $artist);
        $artist = strtolower($artist);
		
		try {
			$html = file_get_html($site . $artist . '-lyrics.html');
		} catch (Exception $e) {
			return "<div>Invalid Artist</div>";
		}
        
        $song_links = array();
        $str = "";
        $massivesonglyrics = "";

        foreach ($html->find('a') as $element) {
            if (strpos($element, '-lyrics-' . $artist) !== false) {
                $song_links[] = $element->href;
            }
        }
		
		$song_size = count($song_links);
		if ($song_size > $upperSongLimit) {
            $song_size = $upperSongLimit;
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
	
    function getSongsByWord($_word, $_artist, $_site, $upperSongLimit)
    {
        include_once('simple_html_dom.php');
        // Create DOM from URL or file
        $artist = $_artist;
        $word = $_word;
        $artist = str_replace(" ", "-", $artist);
        $artist = strtolower($artist);
        $html = file_get_html($_site . $artist . '-lyrics.html');
        $song_links = array();
        $str = "";
		
        foreach ($html->find('a') as $element) {
            if (strpos($element, '-lyrics-' . $artist) !== false) {
                $song_links[] = $element->href;
            }
        }
		
		$song_size = count($song_links);
		if ($song_size > $upperSongLimit) {
            $song_size = $upperSongLimit;
        } 
		
        $array_songs = array();
        for ($x = 0; $x < $song_size; $x++) {
            $htmlsong = file_get_html($song_links[$x]);
            foreach ($htmlsong->find('div[id=lyrics-body-text]') as $lyrics) {
                $str = preg_replace("/\[([^\[\]]++|(?R))*+\]/", "", $lyrics);
                if (stripos($str, strtolower($word)) !== false || stripos($str, strtoupper($word)) !== false || stripos($str, $word) !== false) {
                    foreach ($htmlsong->find('title') as $title) {
                        $finaltitle = $this->get_string_between($title->plaintext, "-", "Lyrics");
                        $array_songs[] = $finaltitle;
                    }
                }
            }
        }
        return $array_songs;
    }
	
    function getLyricsBySong($_artist, $_song, $_word, $_site)
    {
        include_once('simple_html_dom.php');
        // Create DOM from URL or file
        $artist = $_artist;
        $artist = str_replace(" ", "-", $artist);
        $artist = strtolower($artist);
        $song = $_song;
        #$song = str_replace(" ", "-", $song);
        $song = strtolower($song);
        $html = file_get_html($_site . $artist . '-lyrics.html');
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
		if($song_links == "") {
			return "";
		}
        $htmlsong = file_get_html($song_links);
        foreach ($htmlsong->find('div[id=lyrics-body-text]') as $lyrics) {
            $str = preg_replace("/\[([^\[\]]++|(?R))*+\]/", "", $lyrics);
            $massivesonglyrics = $massivesonglyrics . $str;
        }
        return $massivesonglyrics;
    }
}
?>