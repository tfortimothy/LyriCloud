<?php
require_once 'WordCloud.php';
class WordCloudTest extends PHPUnit_Framework_TestCase {
    public function testGetLyricsBySongReturnsLyricsIfValidSong()
    {
        $provider = new WordCloud();
        $lyrics = $provider->getLyricsBySong("testartist", "testsong", "test", "test/");
        $this->assertEquals("<div id=\"lyrics-body-text\">These are test lyrics</div>", $lyrics);
    }
	
	public function testGetLyricsBySongReturnsEmptyIfInvalidSong()
    {
        $provider = new WordCloud();
        $lyrics = $provider->getLyricsBySong("testartist", "invalidSong", "test", "test/");
        $this->assertEquals("", $lyrics);
    }
}
 