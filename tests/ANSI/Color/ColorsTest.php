<?php

use PHPUnit\Framework\TestCase;

use ANSI\Color\Colors;



class ColorsTest extends TestCase
{


    public function setUp()
    {


    }

    public function tearDown()
    {

    }



    /**
     * static function stripName($name)
     *
     * Helper function to reduce names to a key e.g. "Red" -> "red", "Light Blue" -> "lightblue", "DARK blue" -> "darkblue"
     *
     * param string $name
     * return string
     */
    public function test_stripName() {

        // trimming
        $this->assertSame("red",Colors::stripName("red"));
        $this->assertSame("red",Colors::stripName("   red"));
        $this->assertSame("red",Colors::stripName("red   "));
        $this->assertSame("lightred",Colors::stripName(" light   red  "));

        // eliminating any empty space
        $this->assertSame("darkblue",Colors::stripName("darkblue"));
        $this->assertSame("darkblue",Colors::stripName("dark blue"));
        $this->assertSame("darkblue",Colors::stripName("dark             blue"));

        // lower case
        $this->assertSame("purple",Colors::stripName("purple"));
        $this->assertSame("purple",Colors::stripName("Purple"));
        $this->assertSame("purple",Colors::stripName("purPle"));
        $this->assertSame("purple",Colors::stripName("PURPLE"));

        // switch grey with gray
        $this->assertSame("purplegray",Colors::stripName("purplegray"));
        $this->assertSame("purplegray",Colors::stripName("purplegrey"));
        $this->assertSame("gray",Colors::stripName("grey"));

    }

    /**
     * static function isValidColorName($name)
     *
     * Whether a string is a valid color name
     *
     * param string $name
     * return bool
     */
    public function test_isValidColorName() {

        $this->assertTrue(Colors::isValidColorName("purple"));
        $this->assertTrue(Colors::isValidColorName("Navy "));
        $this->assertTrue(Colors::isValidColorName("AntiQUE WHITE "));

        $this->assertFalse(Colors::isValidColorName(null));
        $this->assertFalse(Colors::isValidColorName(19));
        $this->assertFalse(Colors::isValidColorName("junk"));

    }

    /**
     * static function getColorIndex()
     *
     * Get the full index of all colors
     *
     * return string[]
     */
    public function test_getColorIndex() {
        
        $index = Colors::getColorIndex();

        $this->assertSame(180,count($index));
        $this->assertContains("purple",$index);
        $this->assertSame("ansiblack",$index[0]);
        $this->assertSame("gray238",$index[179]);

    }

    /**
     * static function getANSIIndex()
     *
     * Get just the index for the ANSI colors
     *
     * return string[]
     */
    public function test_getANSIIndex() {

        $index = Colors::getANSIIndex();

        $this->assertSame(16,count($index));
        $this->assertContains("ansibrightred",$index);
        $this->assertSame("ansiblack",$index[0]);
        $this->assertSame("ansiwhite",$index[15]);

    }

    /**
     * static function getW3CIndex()
     *
     * Get the index for just the W3C colors
     *
     * return string[]
     */
    public function test_getW3CIndex() {
        $index = Colors::getW3CIndex();

        $this->assertSame(140,count($index));
        $this->assertContains("violet",$index);
        $this->assertSame("aliceblue",$index[0]);
        $this->assertSame("yellowgreen",$index[139]);
    }

    /**
     * static function getGraysIndex()
     *
     * Get the index to the final sequence of grays
     *
     * return string[]
     */
    public function test_getGraysIndex() {

        $index = Colors::getGraysIndex();

        $this->assertSame(24,count($index));
        $this->assertContains("gray128",$index);
        $this->assertSame("gray8",$index[0]);
        $this->assertSame("gray238",$index[23]);

    }



    /**
     * static function getHumanName($name)
     *
     * Get the human readable name for a particular color (and in pleasant case)
     *
     * param string $name - this can either be the exact index "palegoldenrod", or the more human readable "Pale Goldenrod" (case independent)
     * return string - the name or "Unknown" if it is not found
     */
    public function test_getHumanName() {
        // null
        $this->assertSame("Unknown", Colors::getHumanName(null));

        // good value
        $this->assertSame("Gray",Colors::getHumanName("grey"));
        $this->assertSame("Saddle Brown",Colors::getHumanName(" saddle BROWN"));

        // invalid value
        $this->assertSame("Unknown", Colors::getHumanName("junk"));
    }

    /**
     * static function getANSICode($name)
     *
     * Get the ANSI code for the specified color
     *
     * param string $name - this can either be the exact index "palegoldenrod", or the more human readable "Pale Goldenrod" (case independent)
     * return integer | null - the index or null if something went wrong
     */
    public function test_getANSICode() {
        // null
        $this->assertNull(Colors::getANSICode(null));

        // good value
        $this->assertSame(91,Colors::getANSICode("Red"));
        $this->assertSame(96,Colors::getANSICode("ANSI Bright cyan"));

        // invalid value
        $this->assertNull(Colors::getANSICode("junk"));
    }

    /**
     * static function getXTermCode($name)
     *
     * Get the 256 color index for a particular color
     *
     * param string $name - this can either be the exact index "palegoldenrod", or the more human readable "Pale Goldenrod" (case independent)
     * return integer | null - the index or null if something went wrong
     */
    public function test_getXTermCode() {

        // null
        $this->assertNull(Colors::getXTermCode(null));

        // good value
        $this->assertSame(218,Colors::getXTermCode("Pink"));
        $this->assertSame(79,Colors::getXTermCode("Medium Aquamarine"));

        // invalid value
        $this->assertNull(Colors::getXTermCode("junk"));

    }



    /**
     * static function getRGB($name)
     *
     * Get the RGB array for a particular color name
     *
     * param string $name - this can either be the exact index "palegoldenrod", or the more human readable "Pale Goldenrod" (case independent)
     * return integer[] | null - array of three numbers indicating [R,G,B] or null if not found
     */
    public function test_getRGB() {

        // null
        $this->assertNull(Colors::getRGB(null));

        // good value
        $this->assertSame([255,0,0],Colors::getRGB("red"));
        $this->assertSame([106,90,205],Colors::getRGB("Slate   blue   "));

        // invalid value
        $this->assertNull(Colors::getRGB("junk"));

    }

    /**
     * static function needsWhiteContrast($xtermIndex)
     *
     * Determines whether a particular color needs a white contrast
     *
     * param integer $xtermCode - number between 0 - 255 for the XTerm 256 colors
     * return boolean - whether the color needs white
     */
    public function test_needsWhiteContrast()
    {
        $this->assertTrue(Colors::needsWhiteContrast(0));
        $this->assertFalse(Colors::needsWhiteContrast(15));
        
        $this->assertNull(Colors::needsWhiteContrast(-2));
        
    }
    


    /**
     * function matchRGB($RGB)
     *
     * For any given RGB, find the closest match in the color array
     *
     * param integer[] $RGB - array of three numbers [R,G,B]
     * return string | null - the index to the color array ("darkblue"), or null if something went wrong
     */
    public function test_matchRGB() {

        $this->assertSame("fuchsia",Colors::matchRGB([255,0,255]));
        $this->assertSame("mediumslateblue",Colors::matchRGB([142,100,255]));
        $this->assertSame("mediumturquoise",Colors::matchRGB([73,209,202]));
        $this->assertSame("black",Colors::matchRGB([1,1,4]));
        $this->assertSame("mintcream",Colors::matchRGB([245,260,252]));
    }

    /**
     * static function getColorIndexForXTermCode($index)
     *
     * Get the color name index for a particular xterm code
     *
     * param integer $index
     * return string | null - color name in the index or null if not found
     */
    public function test_getColorIndexForXTermColor() {

        $this->assertSame("deepskyblue",Colors::getColorIndexForXTermCode(45));
        $this->assertSame("linen",Colors::getColorIndexForXTermCode(255));
        $this->assertSame("ansiwhite",Colors::getColorIndexForXTermCode(15));
        $this->assertSame("orchid",Colors::getColorIndexForXTermCode(169));

        $this->assertSame(null,Colors::getColorIndexForXTermCode(256));
        $this->assertSame(null,Colors::getColorIndexForXTermCode(-1));

        
    }

    /**
     * public static function getRGBForXTermCode($index)
     *
     * Get the RGB for a particular xterm code
     *
     * @param integer $index
     * @return int[] | null - either the [R,G,B] or null
     */
    public function test_getRGBForXTermCode() {

        // first
        $answer = Colors::getRGBForXTermCode(0);
        $this->assertSame([0,0,0],$answer);

        // middle
        $answer = Colors::getRGBForXTermCode(3);
        $this->assertSame([205,205,0],$answer);

        // last
        $answer = Colors::getRGBForXTermCode(254);
        $this->assertSame([238,238,238],$answer);

        // invalid
        $answer = Colors::getRGBForXTermCode(256);
        $this->assertNull($answer);
    }

    public function test_getRGBForVT100() {

        // 30
        $answer = Colors::getRGBForVT100Code(30);
        $this->assertSame([0,0,0],$answer);

        // 33
        $answer = Colors::getRGBForVT100Code(33);
        $this->assertSame([205,205,0],$answer);

        // 37
        $answer = Colors::getRGBForVT100Code(37);
        $this->assertSame([229,229,299],$answer);

        // 38 - invalid
        $answer = Colors::getRGBForVT100Code(38);
        $this->assertNull($answer);

        // 90
        $answer = Colors::getRGBForVT100Code(90);
        $this->assertSame([76,76,76],$answer);

        // 95
        $answer = Colors::getRGBForVT100Code(95);
        $this->assertSame([255,0,255],$answer);

        // 97
        $answer = Colors::getRGBForVT100Code(97);
        $this->assertSame([255,255,255],$answer);

        // 98 - invalid
        $answer = Colors::getRGBForVT100Code(98);
        $this->assertNull($answer);
    }
}


