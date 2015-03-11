<?php
include 'WordCloud.php';
$artist = $_GET['artist'];
$song =  $_GET['song'];
$provider = new WordCloud;
$lyrics = $provider->getLyricsBySong($artist, $song, $_GET['word'], 'http://www.metrolyrics.com/');
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