<?php


use ANSI\Color\Color;
use ANSI\Color\Mode;
use ANSI\EscapeSequenceGenerator;
use ANSI\TerminalState;
use PHPUnit\Framework\TestCase;

class EscapeSequenceGeneratorTest extends TestCase
{

    /**
     * @param $name
     * @return ReflectionMethod
     */
    protected static function getMethod($name) {

        // get a reflection of the class
        $class = new ReflectionClass("ANSI\\EscapeSequenceGenerator");

        // get the method of interest
        $method = $class->getMethod($name);

        // make that method accessible
        $method->setAccessible(true);

        // return the method
        return $method;
    }
    
    public function setUp()
    {


    }

    public function tearDown()
    {

    }

    /**
     * public function __construct($mode)
     *
     * EscapeSequenceGenerator constructor.
     * param Mode | int | string $mode
     *      if Mode - copies the mode
     *      if int -
     *          if it a number, it interprets it as the desired number of colors and picks the closest mode
     *      if string -
     *          if it is one of the constants self::VT100, self::XTERM, or self::RGB, then it uses it
     *          otherwise, it defaults to XTERM
     *
     */
    public function test__construct() {

        $class = new ReflectionClass("\\ANSI\\EscapeSequenceGenerator");
        $prop = $class->getProperty("mode");

        // set it to a string
        $generator = new \ANSI\EscapeSequenceGenerator("vt100");

        // check it was set properly
        $mode = $prop->getValue($generator);
        $this->assertInstanceOf("\\ANSI\\Color\\Mode",$mode);
        $this->assertSame(Mode::VT100, $mode->getMode());

        // set it to another mode
        $generator = new \ANSI\EscapeSequenceGenerator(new Mode(Mode::RGB));

        // check it was set properly
        $mode = $prop->getValue($generator);
        $this->assertInstanceOf("\\ANSI\\Color\\Mode",$mode);
        $this->assertSame(Mode::RGB, $mode->getMode());

        // set it to a number
        $generator = new \ANSI\EscapeSequenceGenerator(256);

        // check it was set properly
        $mode = $prop->getValue($generator);
        $this->assertInstanceOf("\\ANSI\\Color\\Mode",$mode);
        $this->assertSame(Mode::XTERM, $mode->getMode());


    }


    /**
     * public static function generateClearSequence()
     *
     * Helper function that generates the clear sequence \033[0m
     *
     * return string
     */
    public function test_generateClearSequence() {

        // check that it does return the clear sequence
        $this->assertSame("\e[0m",EscapeSequenceGenerator::generateClearSequence());
    }

    /**
     * public static function generateBoldingSequence()
     *
     * Helper function that generates the bolding sequence \033[1m
     *
     * return string
     */
    public function test_generateBoldingSequence() {
        // check that it does return the clear sequence
        $this->assertSame("\e[1m",EscapeSequenceGenerator::generateBoldingSequence());
    }

    /**
     * public static function generateUnderscoringSequence()
     *
     * Helper function that generates the bolding sequence \033[1m
     *
     * return string
     */
    public function test_generateUnderscoringSequence() {
        // check that it does return the clear sequence
        $this->assertSame("\e[4m",EscapeSequenceGenerator::generateUnderscoringSequence());

    }

    /**
     * public static function generateTextColorSequence(ColorInterface $textColor, $mode)
     *
     * Static helper function to generate a text color sequence
     * param ColorInterface $textColor - the color desired
     * param Mode $mode - the terminal mode
     *
     * return string - the full escape sequence for the text color
     */
    public function test_generateTextColorSequence() {

        $lime = Color::lime();

        // we only have to ensure it makes the call appropriately to the color object and surrounds with CSI and CSE
        $sequence = EscapeSequenceGenerator::generateTextColorSequence($lime, new Mode("Rgb"));
        $this->assertSame("\e[38;2;0;255;0m",$sequence);

        // invalid color
        $sequence = EscapeSequenceGenerator::generateTextColorSequence(new Color("junk"),new Mode("VT100"));
        $this->assertSame("",$sequence);

        // invalid mode, defaults to XTERM
        $sequence = EscapeSequenceGenerator::generateTextColorSequence(new Color("red"),new Mode("junk"));
        $this->assertSame("\e[38;5;9m",$sequence);


    }

    /**
     * public static function generateFillColorSequence(ColorInterface $fillColor, $mode)
     *
     * Static helper function to generate a fill color sequence
     * param ColorInterface $fillColor - the color desired
     * param Mode $mode - the terminal mode
     *
     * return string - the full escape sequence for the text color
     */
    public function test_generateFillColorSequence() {

        $lime = Color::lime();

        // we only have to ensure it makes the call appropriately to the color object and surrounds with CSI and CSE
        $sequence = EscapeSequenceGenerator::generateFillColorSequence($lime, new Mode("Rgb"));
        $this->assertSame("\e[48;2;0;255;0m",$sequence);

        // invalid color
        $sequence = EscapeSequenceGenerator::generateFillColorSequence(new Color("junk"),new Mode("VT100"));
        $this->assertSame("",$sequence);

        // invalid mode, defaults to XTERM
        $sequence = EscapeSequenceGenerator::generateFillColorSequence(new Color("red"),new Mode("junk"));
        $this->assertSame("\e[48;5;9m",$sequence);
    }

    /**
     * public static function generateClearSequence()
     *
     * Helper function that generates the clear sequence \033[0m
     *
     * return string
     */
    public function test_generateClearScreenSequence() {

        // check that it does return the clear sequence
        $this->assertSame("\e[H\e[2J",EscapeSequenceGenerator::generateClearScreenSequence());
    }

    /**
     * protected function generateSequence(TerminalState $state, $reset)
     *
     * Generate the escape sequencing for a particular state
     *
     * param TerminalState $state - the state to achieve
     * param boolean $reset - whether the zero reset code needs to start this sequence
     * return string
     */
    public function test_generateSequence() {
        
        $method = self::getMethod("generateSequence");
        
        $generator = new EscapeSequenceGenerator("VT100");
        $state = new TerminalState();
        
        $sequence = $method->invokeArgs($generator,[$state, false]);
        $this->assertSame("",$sequence);

        $sequence = $method->invokeArgs($generator,[$state, true]);
        $this->assertSame("\e[0m",$sequence);

        $state->setBold(true);
        $sequence = $method->invokeArgs($generator,[$state, true]);
        $this->assertSame("\e[0;1m",$sequence);

        $state->setUnderscore(true);
        $sequence = $method->invokeArgs($generator,[$state, false]);
        $this->assertSame("\e[1;4m",$sequence);

        $state->setTextColor("ansired");
        $sequence = $method->invokeArgs($generator,[$state, false]);
        $this->assertSame("\e[1;4;31m",$sequence);

        $state->setFillColor("ansiblack");
        $sequence = $method->invokeArgs($generator,[$state, false]);
        $this->assertSame("\e[1;4;31;40m",$sequence);



    }

    /**
     * public function generate(TerminalStateInterface $currentState, TerminalState $desiredState)
     *
     * Generate an escape sequence based on the current state and the new desired state
     *
     * param TerminalStateInterface $currentState
     * param TerminalState $desiredState
     * return string
     */
    public function test_generate() {

        $generator = new EscapeSequenceGenerator("vt100");

        $currentState = new TerminalState();
        $desiredState = new TerminalState();

        // nothing to do yet
        $sequence = $generator->generate($currentState, $desiredState);
        $this->assertSame("",$sequence);

        // turn on bold
        $desiredState->setBold(true);
        $sequence = $generator->generate($currentState, $desiredState);
        // pretend the current state was updated
        $currentState->setBold(true);

        // ensure bold was turned on
        $this->assertSame("\e[1m",$sequence);

        // turn off bold, but turn on underscore
        $desiredState->setBold(false)->setUnderscore(true);
        $sequence = $generator->generate($currentState, $desiredState);
        $this->assertSame("\e[0;4m",$sequence);
        $currentState = clone $desiredState;

        // just turn on text color
        $desiredState->setTextColor("ansigreen");
        $sequence = $generator->generate($currentState, $desiredState);
        $this->assertSame("\e[32m",$sequence);
        $currentState = clone $desiredState;


        // change the text color and add a fill
        $desiredState->setFillColor("ansiblack")->setTextColor("ansiblue");
        $sequence = $generator->generate($currentState, $desiredState);
        $this->assertSame("\e[34;40m",$sequence);
        $currentState = clone $desiredState;

        // turn off underscore, should cause a rest
        $desiredState->setUnderscore(false)->setBold(true);
        $sequence = $generator->generate($currentState, $desiredState);
        $this->assertSame("\e[0;1;34;40m",$sequence);
        $currentState = clone $desiredState;

        // turn back on underscore
        $desiredState->setUnderscore(true);
        $sequence = $generator->generate($currentState, $desiredState);
        $this->assertSame("\e[4m",$sequence);
        $currentState = clone $desiredState;

        // clear out the text color
        $desiredState->setTextColor(null);
        $sequence = $generator->generate($currentState, $desiredState);
        $this->assertSame("\e[0;1;4;40m",$sequence);

    }

}


