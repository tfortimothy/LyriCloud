<?php
include 'WordCloud.php';

$toSearch = $_GET['word'];
$theArtist = $_GET['artist'];
$provider = new WordCloud;

$songs = array();
$songs = $provider->getSongsByWord($toSearch, $theArtist);

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
<head>
<link rel="stylesheet" href="css/specificWord.css">
</head>
<header>
	<div id="header">LyricFloat</div>
	<div id="songName"> <?php echo strtoupper($toSearch) ?> </div>
</header>
<body>
<?php 
	$formattedArtistName = str_replace(" ","%20",$theArtist);
    $formattedWord = $toSearch;
	for($x = 0; $x<count($songs); $x++){
        $formattedSongName = $songs[$x];
		echo "<div id=\"songLink\"><a href=\"lyricsPage.php?artist=$formattedArtistName&song=$formattedSongName&word=$formattedWord\">$songs[$x]</a></div>";
	}
?>

<a href="index.html"><button id="back">Back</button></a>
</body>
</html>