<?php

use ANSI\Color\Mode;
use PHPUnit\Framework\TestCase;



class ModeTest extends TestCase
{

    /**
     * @param $name
     * @return ReflectionMethod
     */
    protected static function getMethod($name) {

        // get a reflection of the class
        $class = new ReflectionClass("ANSI\\Color\\Mode");

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
     * public function __construct($mode = self::XTERM)
     *
     * Mode constructor.
     * param int | string $mode
     *      if int -
     *          if it is any other number, it tries to ascertain the mode based on the number of colors
     *      if string -
     *          if it is one of the constants Mode::XTERM, then it returns that mode
     *          it matches the constant names (such as "xterm" or "RGB") case-insensitive, if that
     *          does not work, it defaults to xterm
     */
    public function test__construct() {

        $mode = new Mode();

        // check the default
        $this->assertSame(Mode::XTERM,$mode->getMode());

        // quick check, the constructor calls the setter, so no need for extensive testing
        $mode = new Mode("rgb");
        $this->assertSame(Mode::RGB,$mode->getMode());

        $newMode = new Mode($mode);
        $this->assertSame(Mode::RGB, $newMode->getMode());


    }

    /**
     * protected static function getModeConstant($value)
     *
     * Helper function to take a value and turn it into a valid constant integer value
     *
     * param string | int $value
     *      if int -
     *          if it is any other number, it tries to ascertain the mode based on the number of colors
     *      if string -
     *          if it is one of the constants Mode::XTERM, then it returns that mode
     *          it matches the constant names (such as "xterm" or "RGB") case-insensitive, if that
     *          does not work, it defaults to xterm
     *
     *
     * @return int - the constant or the $default parameter value if something went wrong
     */
    public function test_getModeConstant() {

        $method = self::getMethod('getModeConstant');
        $mode = new Mode();

        // test integers

        $answer = $method->invokeArgs($mode,[0]);
        $this->assertSame(Mode::VT100,$answer);

        $answer = $method->invokeArgs($mode,[-1]);
        $this->assertSame(Mode::VT100,$answer);

        $answer = $method->invokeArgs($mode,[1]);
        $this->assertSame(Mode::VT100,$answer);

        $answer = $method->invokeArgs($mode,[16]);
        $this->assertSame(Mode::VT100,$answer);

        $answer = $method->invokeArgs($mode,[17]);
        $this->assertSame(Mode::XTERM,$answer);

        $answer = $method->invokeArgs($mode,[256]);
        $this->assertSame(Mode::XTERM,$answer);

        $answer = $method->invokeArgs($mode,[257]);
        $this->assertSame(Mode::RGB,$answer);

        $answer = $method->invokeArgs($mode,[12345678]);
        $this->assertSame(Mode::RGB,$answer);


        // strings
        $answer = $method->invokeArgs($mode,["rGb"]);
        $this->assertSame(Mode::RGB,$answer);

        $answer = $method->invokeArgs($mode,["VT100"]);
        $this->assertSame(Mode::VT100,$answer);

        $answer = $method->invokeArgs($mode,["junk"]);
        $this->assertSame(Mode::XTERM,$answer);



        // other types
        $answer = $method->invokeArgs($mode,[127.12]);
        $this->assertSame(Mode::XTERM,$answer);

        $answer = $method->invokeArgs($mode,[new \stdClass]);
        $this->assertSame(Mode::XTERM,$answer);


    }


    /**
     * public function __toString()
     *
     * Return the mode which is one of the string constants
     *
     * @return string
     */
    public function test__toString() {

        $mode = new Mode();
        $this->assertSame(Mode::XTERM,strval($mode));

        $mode->setMode("RGB");
        $this->assertSame(Mode::RGB,$mode . "");

        $mode->setMode(1);
        $this->assertSame(Mode::VT100,strval($mode));

    }



    /**
     * public function getMode()
     * public function setMode($mode)
     *
     * param int | string $mode
     *      if int -
     *          if it is any other number, it tries to ascertain the mode based on the number of colors
     *      if string -
     *          it matches the constant names (such as "xterm" or "RGB") case-insensitive, if that
     *          does not work, it defaults to xterm
     */
    public function test_setGetMode() {

        // not a lot to test here, most of the code is in the get constant method
        $mode = new Mode();
        $this->assertSame(Mode::XTERM, $mode->getMode());

        $mode->setMode("vt100");
        $this->assertSame(Mode::VT100, $mode->getMode());

        $mode->setMode("junk");
        $this->assertSame(Mode::XTERM, $mode->getMode());

        $mode->setMode(new Mode("rgb"));
        $this->assertSame(Mode::RGB, $mode->getMode());



    }

}


