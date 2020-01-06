<?php

use ANSI\Color\Mode;
use PHPUnit\Framework\TestCase;

use ANSI\Color\Color;


class ColorTest extends TestCase
{

    /**
     * @param $name
     * @return ReflectionMethod
     */
    protected static function getMethod($name) {

        // get a reflection of the class
        $class = new ReflectionClass("ANSI\\Color\\Color");

        // get the method of interest
        $method = $class->getMethod($name);

        // make that method accessible
        $method->setAccessible(true);

        // return the method
        return $method;
    }

    public function setUp(): void
    {


    }

    public function tearDown(): void
    {

    }



    /**
     * __construct($color)
     *
     * Color constructor.
     *
     * param ColorInterface | string | integer | int[] $color - Many options for initializing a color object
     *      - ColorInterface - another object implementing a ColorInterface
     *      - String - a W3C color index name "darkblue" or "Dark Blue"
     *      - integer - a number between 0-255 for the XTerm escape code
     *      - integer[] - RGB values in the format [R,G,B]
     *
     */
    public function test_construct(){
        
        // another color class
        $initColor = new Color("green");
        $color = new Color($initColor);
        $this->assertSame("green",$color->getName());
        
        $initColor = new Color("Antique White");
        $color = new Color($initColor);
        $this->assertSame("antiquewhite",$color->getName());
        

        // null
        $color = new Color(null);
        $this->assertSame(null,$color->getRGB());
        $this->assertSame(null,$color->getXTermCode());
        $this->assertSame(null,$color->getName());

        // strings
        $color = new Color("black");
        $this->assertSame([0,0,0],$color->getRGB());
        $this->assertSame(0,$color->getXTermCode());
        $this->assertSame(30,$color->getANSICode());
        $this->assertSame("black",$color->getName());

        $color = new Color("grey");
        $this->assertSame([128,128,128],$color->getRGB());
        $this->assertSame(244,$color->getXTermCode());
        $this->assertSame(90,$color->getANSICode());
        $this->assertSame("gray",$color->getName());

        $color = new Color("RED");
        $this->assertSame([255,0,0],$color->getRGB());
        $this->assertSame(9,$color->getXTermCode());
        $this->assertSame(91,$color->getANSICode());
        $this->assertSame("red",$color->getName());

        $color = new Color(" light     blue    ");
        $this->assertSame([173,216,230],$color->getRGB());
        $this->assertSame(152,$color->getXTermCode());
        $this->assertSame(94,$color->getANSICode());
        $this->assertSame("lightblue",$color->getName());

        $color = new Color("MAGNTA");
        $this->assertSame(null,$color->getRGB());
        $this->assertSame(null,$color->getXTermCode());
        $this->assertSame(null,$color->getANSICode());
        $this->assertSame(null,$color->getName());

        // integer
        // 88 is maroon
        $color = new Color(88);
        $this->assertSame([128,0,0],$color->getRGB());
        $this->assertSame(88,$color->getXTermCode());
        $this->assertSame(31,$color->getANSICode());
        $this->assertSame("maroon",$color->getName());

        // some xterm number that is not specified
        $color = new Color(254);
        $this->assertSame([228,228,228],$color->getRGB());
        $this->assertSame(254,$color->getXTermCode());
        $this->assertSame(97,$color->getANSICode());
        $this->assertSame("gray228",$color->getName());

        $color = new Color(1214);
        $this->assertSame(null,$color->getRGB());
        $this->assertSame(null,$color->getXTermCode());
        $this->assertSame(null,$color->getANSICode());
        $this->assertSame(null,$color->getName());


        // RGBs
        $color = new Color([255,0,255]);
        $this->assertSame([255,0,255],$color->getRGB());
        $this->assertSame(13,$color->getXTermCode());
        $this->assertSame(95,$color->getANSICode());
        $this->assertSame("fuchsia",$color->getName());

        $color = new Color([67,255,70]);
        $this->assertSame([67,255,70],$color->getRGB());
        $this->assertSame(2,$color->getXTermCode());
        $this->assertSame(32,$color->getANSICode());
        $this->assertSame("limegreen",$color->getName());

        $color = new Color([0,255,128]);
        $this->assertSame([0,255,128],$color->getRGB());
        $this->assertSame(48,$color->getXTermCode());
        $this->assertSame(92,$color->getANSICode());
        $this->assertSame("springgreen",$color->getName());


        // invalid types
        $color = new Color(new \stdClass());
        $this->assertSame(null,$color->getRGB());
        $this->assertSame(null,$color->getXTermCode());
        $this->assertSame(null,$color->getANSICode());
        $this->assertSame(null,$color->getName());

        $color = new Color(['white']);
        $this->assertSame(null,$color->getRGB());
        $this->assertSame(null,$color->getXTermCode());
        $this->assertSame(null,$color->getANSICode());
        $this->assertSame(null,$color->getName());

        $color = new Color(1.0);
        $this->assertSame(null,$color->getRGB());
        $this->assertSame(null,$color->getXTermCode());
        $this->assertSame(null,$color->getANSICode());
        $this->assertSame(null,$color->getName());

    }

    /**
     * public function setEmpty()
     * public function isEmpty()
     *
     * Set the color object to empty
     */
    public function test_setIsEmpty() {

        // default is empty
        $color = new Color();
        $this->assertTrue($color->isEmpty());

        $color = new Color(null);
        $this->assertTrue($color->isEmpty());

        $color->setColor("blue");
        $this->assertFalse($color->isEmpty());

        $color->setEmpty();
        $this->assertTrue($color->isEmpty());

    }

    /**
     * function isValid()
    *
     * Whether a color is valid
     *
     * return boolean
     */
    public function test_isValid() {

        $color = new Color("red");
        $this->assertTrue($color->isValid());

        $color = new Color("junk");
        $this->assertFalse($color->isValid());


    }

    /**
     * function getName()
    *
     * Get the name of the color
     *
     * If a name was sent in, it will be that name, if it is a XTerm code, it will be the code,
     * if it is an ANSI code, it will be ansi code, and finally if it is an RGB, it will be [R,G,B] in string form.
     *
     * return string | null - either the name or null if not valid
     */
    public function test_getName() {
        // valid
        $color = new Color(122);
        $this->assertSame("aquamarine",$color->getName());

        // null
        $color = new Color(null);
        $this->assertSame(null,$color->getName());

        // invalid
        $color = new Color("junk");
        $this->assertSame(null,$color->getName());
    }

    /**
     * function getHumanName()
     *
     * Get the Human readable version of the name, "Antique White" versus "antiquewhite"
     *
     * return string
     */
    public function test_getHumanName() {
        // valid
        $color = new Color(122);
        $this->assertSame("Aquamarine",$color->getHumanName());

        // null
        $color = new Color(null);
        $this->assertSame("Unknown",$color->getHumanName());

        // invalid
        $color = new Color("antiquewhite");
        $this->assertSame("Antique White",$color->getHumanName());
    }

    /**
     * getANSICode()
     *
     * Get the ANSI code for a the particular color
     *
     * return int | null - either an integer 30-37 or 90-97 or null if invalid color
     */
    public function test_getANSICode() {
        // valid
        $color = new Color(8);
        $this->assertSame(90,$color->getANSICode());

        // null
        $color = new Color(null);
        $this->assertSame(null,$color->getANSICode());

        // invalid
        $color = new Color("junk");
        $this->assertSame(null,$color->getANSICode());
    }



    /**
     * function getXTermCode()
     *
     * return int | null - either the xterm code which is between 0-255 or null if color is invalid
     */
    public function test_getXTermCode() {
        // valid
        $color = new Color([128,0,0]);
        $this->assertSame(88,$color->getXTermCode());

        // null
        $color = new Color(null);
        $this->assertSame(null,$color->getXTermCode());

        // invalid
        $color = new Color("junk");
        $this->assertSame(null,$color->getXTermCode());
    }


    /**
     * function getRGB()
     *
     * return integer[] | null - array of three integers, in the form of [R,G,B] or null if the color is not valid
     */
    public function test_getRGB() {

        // valid
        $color = new Color("CORNSILK");
        $this->assertSame([255,248,220],$color->getRGB());

        // null
        $color = new Color(null);
        $this->assertSame(null,$color->getRGB());

        // invalid
        $color = new Color("junk");
        $this->assertSame(null,$color->getRGB());

    }






    /**
     * function getContrastColor()
     *
     * return Color - either a Color object that is white or black (black if problem occurs)
     */
    public function test_getContrastColor() {

        $color = new Color("black");
        $contrastColor = $color->getContrastColor();
        $this->assertSame("white",$contrastColor->getName());

        $color = new Color("darkblue");
        $contrastColor = $color->getContrastColor();
        $this->assertSame("white",$contrastColor->getName());

        $color = new Color("white");
        $contrastColor = $color->getContrastColor();
        $this->assertSame("black",$contrastColor->getName());

        $color = new Color("yellow");
        $contrastColor = $color->getContrastColor();
        $this->assertSame("black",$contrastColor->getName());

        $color = new Color(null);
        $contrastColor = $color->getContrastColor();
        $this->assertSame("black",$contrastColor->getName());
    }
    
    /**
     * public static function __callStatic($name, $arguments)
     *
     * __call - magic method to create shortcuts to all W3C colors, the function names are case independent
     * PLEASE NOTE: if the name does not match a W3C color, it will be ignored and switched to black
     * param $name
     * param $arguments - there are no arguments used
     *
     * return Color
     */
    public function test__callStatic() {

        $color = Color::black();
        $this->assertSame("black",$color->getName());

        $color = Color::darkblue();
        $this->assertSame("darkblue",$color->getName());
        
        // returns Color object, chain
        $this->assertSame("green",Color::green()->getName());


        // bad data
        /** @noinspection PhpUndefinedMethodInspection */
        $color = Color::junk();
        /** @noinspection PhpUndefinedMethodInspection */
        $this->assertSame("black",$color->getName());


    }

    /**
     * public function generateColorCoding($mode, $isFill = false)
     * 
     * Generate a color coding based on the terminal type
     *
     * param int $mode = the mode of the terminal, can just be set by $this->mode (allows it to be static for external use)
     * param boolean $isFill - whether the color is a fill
     *
     * return string
     */
    public function test_generateColorCoding() {


        $color = new Color();

        // invalid color
        $this->assertSame("",$color->generateColorCoding(Mode::VT100));

        // valid color
        $color->setColor("ansigreen");
        $this->assertSame("32",$color->generateColorCoding(Mode::VT100));

        // invalid mode, goes to XTERM
        $this->assertSame("38;5;2",$color->generateColorCoding(45));

        // valid fill color
        $color->setColor("orchid");
        $this->assertSame("48;5;170",$color->generateColorCoding(Mode::XTERM,true));

        // valid fill color, different mode
        $this->assertSame("48;2;218;112;214",$color->generateColorCoding(Mode::RGB,true));
    }

    /**
     * public function next()
     * public function previous()
     *
     * Return the next name on the main Colors name index
     * @return string | null - return null if this color is not valid, otherwise, return the next name or
     * the first name, if this is the last name
     */
    public function test_next_previous() {

        // empty color, no next or previous
        $starting = new Color();
        $this->assertNull($starting->next());
        $this->assertNull($starting->previous());

        // bad color, no next or previous
        $starting = new Color("junk");
        $this->assertNull($starting->next());
        $this->assertNull($starting->previous());

        // random color
        $starting = new Color("violet");
        $this->assertSame("wheat",$starting->next());
        $this->assertSame("turquoise",$starting->previous());

        // first color
        $starting = new Color("aliceblue");
        $this->assertSame("antiquewhite",$starting->next());
        $this->assertSame("yellowgreen",$starting->previous());

        // last color
        $starting = new Color("yellowgreen");
        $this->assertSame("aliceblue",$starting->next());
        $this->assertSame("yellow",$starting->previous());

        // color that is not a W3C color
        $starting = new Color("gray218");
        $this->assertNull($starting->next());
        $this->assertNull($starting->previous());

    }


}


