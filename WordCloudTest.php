<?php
include 'WordCloud.php';

class WordCloudTest extends PHPUnit_Framework_TestCase {
	
	/*
	I changed the parameters of two of the functions to take in a base URL. In production, that parameter is 'metrolyrics.com'.
	In these test situations, it's simply a route to a local folder called "test". The test folder contains three fake html pages.
	The first is 'testArtist's list of fake songs. The other two are fake lyric pages for those songs.
	These tests hit those fake html pages so that we can define the data that we expect back.
	This ensures that we are testing our own functions, not the dependency on metrolyrics
	
	The branch cases are a little dumb, it just tests the upperLimit parameter I added.
	If we only ask for the data of one song, it should hit the switch statement that alters the upper limit based on parameter.
	
	should probably delete this comment once you do the write-up.
	*/
	
	public function testGetLyricsBySongReturnsLyricsIfValidSong()
    {
        $provider = new WordCloud;
        $lyrics = $provider->getLyricsBySong("testartist", "testsong", "test", "test/");
        $this->assertEquals("<div id=\"lyrics-body-text\">These are test lyrics</div>", $lyrics);
    }
	
	public function testGetLyricsBySongReturnsEmptyIfInvalidSong()
    {
        $provider = new WordCloud;
        $lyrics = $provider->getLyricsBySong("testartist", "invalidSong", "test", "test/");
        $this->assertEquals("", $lyrics);
    }
	
	public function testGetLyricsByArtistReturnsLyricsIfValidArtist() {
		$provider = new WordCloud;
		$lyrics = $provider->getLyricsByArtist("testartist", "test/", 2);
		$this->assertEquals("<div id=\"lyrics-body-text\">These are test lyrics</div><div id=\"lyrics-body-text\">These are the second test lyrics</div>", $lyrics);
	}
	
	public function testGetLyricsByArtistReturnsLyricsIfValidArtistBranchCaseLimitOfOne() {
		$provider = new WordCloud;
		$lyrics = $provider->getLyricsByArtist("testartist", "test/", 1);
		$this->assertEquals("<div id=\"lyrics-body-text\">These are test lyrics</div>", $lyrics);
	}
	
	public function testGetLyricsByArtistReturnsEmptyIfInvalidArtist() {
		$provider = new WordCloud;
		$lyrics = $provider->getLyricsByArtist("invalidArtist", "test/", 2);
		$this->assertEquals("<div>Invalid Artist</div>", $lyrics);
	}
	
	public function testGetSongsByWordReturnsSongsIfValidWord() {
		$provider = new WordCloud;
		$lyrics = $provider->getSongsByWord("test", "testArtist", "test/", 2);
		$expectedResults = array(
			0 => "testOneTitle ",
			1 => "testTwoTitle "
		);
		$this->assertEquals($expectedResults, $lyrics);
	}
	
	public function testGetSongsByWordReturnsSongsIfValidWordBranchCaseLimitOfOne() {
		$provider = new WordCloud;
		$lyrics = $provider->getSongsByWord("test", "testArtist", "test/", 1);
		$expectedResults = array(
			0 => "testOneTitle "
		);
		$this->assertEquals($expectedResults, $lyrics);
	}
	
	public function testGetSongsByWordReturnsEmptyArrayIfInvalidWord() {
		$provider = new WordCloud;
		$lyrics = $provider->getSongsByWord("foo", "testArtist", "test/", 1);
		$expectedResults = array();
		$this->assertEquals($expectedResults, $lyrics);
	}
}
?>
 