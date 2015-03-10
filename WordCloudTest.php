<?php
/**
 * Created by PhpStorm.
 * User: SidManoj
 * Date: 3/8/15
 * Time: 10:20 PM
 */
require_once 'WordCloud.php';
class WordCloudTest extends PHPUnit_Framework_TestCase {
    public function testPushAndPop()
    {
        $a = new WordCloud();
        $b = $a->getLyricsByArtist("Kanye West");
        $this->assertEquals("", $b);
    }
}
 