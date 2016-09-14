<?php


use ANSI\Color\Mode;
use ANSI\Terminal;
use ANSI\TerminalState;
use ANSI\TerminalStateInterface;
use PHPUnit\Framework\TestCase;


require 'TerminalStub.php';

class TerminalTest extends TestCase
{

    public $CSI = null;
    public $CSE = null;
    public $clear = null;

    public function setUp()
    {

        $this->CSI = "\\e[";
        $this->CSE = "m";
        $this->clear = "\\e[0m";


    }

    public function tearDown()
    {

    }

    /**
     * Set the state of the terminal directly
     *
     * @param TerminalStateInterface $state
     */
    public function test_setState() {
        $term = new TerminalStub(Mode::VT100);

        $state = new TerminalState();
        $state->setBold(true);
        $term->setState($state);

        $term->display("Bold Text");
        $output = "\\e[1mBold Text";

        $state->setBold(false)->setTextColor("ansicyan");
        $term->setState($state);
        $term->display("Cyan");
        $output .= "\\e[0;36mCyan";


        $term->display("Nothing new");
        $output .= "Nothing new";

        $term->setState(new TerminalState());
        $term->display("Clear");
        $output .= "\\e[0mClear";

        $this->expectOutputString($output);

    }

    /**
     * function getState()
     *
     * Gets the desired state of the terminal, note that this is not related to the actual state
     * of the terminal, rather, the desired state that will happen the next time text is output
     *
     * @return TerminalStateInterface
     */
    public function test_getState() {

        $term = new TerminalStub(Mode::XTERM);

        $state = $term->getState();
        $this->assertInstanceOf("\\ANSI\\TerminalStateInterface",$state);
        $this->assertFalse($state->isBold());
        $this->assertFalse($state->isUnderscore());
        $this->assertFalse($state->getTextColor()->isValid());
        $this->assertFalse($state->getFillColor()->isValid());

        $term->setBold();
        $state = $term->getState();
        $this->assertInstanceOf("\\ANSI\\TerminalStateInterface",$state);
        $this->assertTrue($state->isBold());
        $this->assertFalse($state->isUnderscore());
        $this->assertFalse($state->getTextColor()->isValid());
        $this->assertFalse($state->getFillColor()->isValid());

        $term->setUnderscore();
        $state = $term->getState();
        $this->assertInstanceOf("\\ANSI\\TerminalStateInterface",$state);
        $this->assertTrue($state->isBold());
        $this->assertTrue($state->isUnderscore());
        $this->assertFalse($state->getTextColor()->isValid());
        $this->assertFalse($state->getFillColor()->isValid());

        $term->setFillColor("white");
        $state = $term->getState();
        $this->assertInstanceOf("\\ANSI\\TerminalStateInterface",$state);
        $this->assertTrue($state->isBold());
        $this->assertTrue($state->isUnderscore());
        $this->assertFalse($state->getTextColor()->isValid());
        $this->assertTrue($state->getFillColor()->isValid());
        $this->assertSame("white",$state->getFillColor()->getName());

        $term->setTextColor("black");
        $state = $term->getState();
        $this->assertInstanceOf("\\ANSI\\TerminalStateInterface",$state);
        $this->assertTrue($state->isBold());
        $this->assertTrue($state->isUnderscore());
        $this->assertTrue($state->getTextColor()->isValid());
        $this->assertSame("black",$state->getTextColor()->getName());
        $this->assertTrue($state->getFillColor()->isValid());
        $this->assertSame("white",$state->getFillColor()->getName());

    }
    /////////////////////////////////////////////////////////////////////////////////////////
    //                                          Bold                                       //
    /////////////////////////////////////////////////////////////////////////////////////////

    /**
     * public function setBold($on = true)
     * public function getBold()
     *
     * Set bolding on or off
     *
     * param boolean $on
     *
     * return $this;
     */
    public function test_setGetBold() {

        $term = new TerminalStub("VT100");
        $this->assertFalse($term->getBold());

        // now set the desired bolding to true (but don't command the terminal)
        $term->setBold(true);
        $this->assertTrue($term->getBold());

        // simply set the mode
        $term->setBold(true)->display("");
        $output = "\\e[1m";
        $this->assertTrue($term->getBold());

        // chaining
        $term->setBold(true)->setBold(false)->display("");
        $output .= $this->clear;
        $this->assertFalse($term->getBold());

        // bad mode
        $term->setBold("junk")->display("");
        $output .= "\\e[1m";
        $this->assertTrue($term->getBold());


        $this->expectOutputString($output);

    }


    /////////////////////////////////////////////////////////////////////////////////////////
    //                                      Underscore                                     //
    /////////////////////////////////////////////////////////////////////////////////////////

    /**
     * public function setUnderscore($on = true)
     * public function getUnderscore()
     *
     * Set underscoring on or off
     *
     * param boolean $on
     *
     * return $this;
     */
    public function test_setGetUnderscore() {

        $term = new TerminalStub("VT100");
        $this->assertFalse($term->getUnderscore());

        // now set the desired underscoring to true (but don't command the terminal)
        $term->setUnderscore(true);
        $this->assertTrue($term->getUnderscore());

        // simply set the underscore
        $term->setUnderscore(true)->display("");
        $output = "\\e[4m";
        $this->assertTrue($term->getUnderscore());

        // chaining
        $term->setUnderscore(true)->setUnderscore(false)->display("");
        $output .= $this->clear;
        $this->assertFalse($term->getUnderscore());


        // bad mode
        $term->setUnderscore("junk")->display("");
        $output .= "\\e[4m";
        $this->assertTrue($term->getUnderscore());


        $this->expectOutputString($output);
        return;



    }



    /////////////////////////////////////////////////////////////////////////////////////////
    //                                       Colors                                        //
    /////////////////////////////////////////////////////////////////////////////////////////

    /**
     * public function setTextColor($color)
     * public function getTextColor()
     *
     * Set the text color
     *
     * param ColorInterface | string | integer | array | null $color
     *      Color parameters can be:
     *          - Object adhering to the Color Interface
     *          - A color name "Antique White" or "antiquewhite"
     *          - Xterm integer from 0-255
     *          - [R,G,B]
     *          - null
     *
     * return $this
     */
    public function test_setTextColor() {

        $term = new TerminalStub("XTERM");
        $textColor = $term->getTextColor();
        $this->assertFalse($textColor->isValid());

        $term->setTextColor("blue");
        $textColor = $term->getTextColor();
        $this->assertSame("blue",$textColor->getName());


        $term->setTextColor(null)->display("");
        $textColor = $term->getTextColor();
        $this->assertFalse($textColor->isValid());

        // set a new color from a null color
        $term->setTextColor("blue")->display("");
        $output = "\\e[38;5;20m";
        $textColor = $term->getTextColor();
        $this->assertSame("blue",$textColor->getName());

        $term = new TerminalStub("RGB");

        // set the same color again, chaining
        $term->setTextColor("green")->setTextColor("red")->display("");
        $output .= "\\e[38;2;255;0;0m";
        $textColor = $term->getTextColor();
        $this->assertSame("red",$textColor->getName());

        $term = new TerminalStub("VT100");

        // set a new color from an old color
        $term->setTextColor("ansired")->display("")->setTextColor(null)->setTextColor("ansiblack")->display("");
        $output .= "\\e[31m\\e[30m";
        $textColor = $term->getTextColor();
        $this->assertSame("ansiblack",$textColor->getName());



        $this->expectOutputString($output);



    }


    /**
     * public function setFillColor($color)
     * public function getFillColor()
     *
     * Set the fill color
     *
     * param ColorInterface | string | integer | array | null $color
     *     Color parameters can be:
     *          - Object adhering to the Color Interface
     *          - A color name "Antique White" or "antiquewhite"
     *          - Xterm integer from 0-255
     *          - [R,G,B]
     *          - null
     *
     * return $this
     */
    public function test_setGetFillColor() {

        $term = new TerminalStub("XTERM");
        $fillColor = $term->getFillColor();
        $this->assertFalse($fillColor->isValid());

        $term->setFillColor("blue");
        $fillColor = $term->getFillColor();
        $this->assertSame("blue",$fillColor->getName());

        $term->setFillColor(null)->display("");
        $fillColor = $term->getFillColor();
        $this->assertFalse($fillColor->isValid());

        // set a new color from a null color
        $term->setFillColor("blue")->display("");
        $output = "\\e[48;5;20m";
        $fillColor = $term->getFillColor();
        $this->assertSame("blue",$fillColor->getName());

        $term = new TerminalStub("RGB");

        // set the same color again, chaining
        $term->setFillColor("green")->setFillColor("red")->display("");
        $output .= "\\e[48;2;255;0;0m";
        $fillColor = $term->getFillColor();
        $this->assertSame("red",$fillColor->getName());

        $term = new TerminalStub("VT100");

        // set a new color from an old color
        $term->setFillColor("ansired")->display("")->setFillColor(null)->setFillColor("ansiblack")->display("");
        $output .= "\\e[41m\\e[40m";
        $fillColor = $term->getFillColor();
        $this->assertSame("ansiblack",$fillColor->getName());


        $this->expectOutputString($output);

    }


    /**
     * public function setColors($textColor = null, $fillColor = null)
     *
     * Set both the fill and text colors
     *
     * param $textColor int|string|null $color - can be either a Color constant Color::Blue or a string with the same spelling "blue", "Red", "LIGHT CYAN", etc
     * param $fillColor int|string|null $color - can be either a Color constant Color::Blue or a string with the same spelling "blue", "Red", "LIGHT CYAN", etc
     *
     * return $this
     */
    public function test_setColors() {
        $term = new TerminalStub("XTERM");


        // set just a text color
        $term->setColors("red",null)->display("");
        $output = "\\e[38;5;9m";

        // set just a fill color
        $term->setColors(null,"blue")->display("");
        $output .= "\\e[0;48;5;20m";

        // now both
        $term->setColors("red","blue")->display("");
        $output .= "\\e[38;5;9m";

        // chaining
        $term->setColors("orchid","antiqueWhite")->setColors(null,null)->display("");
        $output .= "\\e[0m";
        $this->expectOutputString($output);

    }


    /////////////////////////////////////////////////////////////////////////////////////////
    //                                       Display                                       //
    /////////////////////////////////////////////////////////////////////////////////////////

    /**
     * public function clear()
     *
     * Clear away all formatting - bold, underscore, text and fill color
     *
     * return $this
     */
    public function test_clear() {

        // simply call it, it just produces esc[0m
        $term = new TerminalStub("XTERM");
        $term->display("");
        $term->setBold()->display("")->clear()->display("");
        $output = "\\e[1m\\e[0m";

        // chaining (and underscore should have no effect)
        $term->setTextColor("green")->display("")->clear()->setBold()->display("");
        $output .= "\\e[38;5;28m" . "\\e[0;1m";

        // right away
        $term->clear(true);
        $output .= "\\e[0m";

        $term->setBold()->clear(true)->display("");
        $output .= "\\e[0m";

        $this->expectOutputString($output);


    }

    /**
     * public function outputEscapeSequence()
     *
     * Send out the escape sequence which will accomplish the desired state
     */
    public function test_outputEscapeSequence() {

        $clio = new TerminalStub("VT100");
        $clio->setTextColor("red");
        $clio->outputEscapeSequence();
        $output = "\\e[91m";


        $clio->setFillColor("black");
        $clio->outputEscapeSequence();
        $output .= "\\e[40m";

        // it should ignore the green
        $clio->setTextColor("green")->setColors("cyan","white");
        $clio->outputEscapeSequence();
        $output .= "\\e[96;107m";

        // bold
        $clio->setBold();
        $clio->outputEscapeSequence();
        $output .= "\\e[1m";

        // because bold went off, the entire sequence should be sent
        $clio->setBold(false)->setUnderscore();
        $clio->outputEscapeSequence();
        $output .= "\\e[0;4;96;107m";

        // clear it out and set bold and green, but shouldn't see separate clear sequence
        $clio->clear()->setBold(true)->setTextColor("green");
        $clio->outputEscapeSequence();
        $output .= "\\e[0;1;92m";

        // the clear goes out, bold is set on and off, and no further sequencing should go out
        $clio->clear(true)->setBold(true)->setBold(false)->display("hello");
        $clio->outputEscapeSequence();
        $output .= "\\e[0mhello";

        $this->expectOutputString($output);

    }

    /**
     * public function display($text)
     *
     * Display the text.  This does not jump down to a new line.
     * If a temporary style is used, only the values that are not null will be used.
     *
     * param $text
     *
     * return $this
     */
    public function test_display() {
        $carriageReturnFire = "CR";


        $clio = new TerminalStub("VT100");

        // display nothing
        $clio->display(null);
        $clio->display("");


        // display simple text
        $clio = new TerminalStub("VT100");

        // display simple text
        $clio->display("Text");
        $output = "Text";

        // chaining
        $clio->display("Hello ")->display("World!");
        $output .= "Hello World!";


        // display types
        $clio = new TerminalStub("VT100");

        // boolean
        $clio->display(true)->newLine();
        $output .= "1\n" . $carriageReturnFire ;

        $clio->display(false)->newLine();
        $output .= "\n" . $carriageReturnFire;

        // integer
        $clio->display(125)->newLine();
        $output .= "125\n" . $carriageReturnFire;

        // double
        $clio->display(1.5)->newLine();
        $output .= "1.5\n" . $carriageReturnFire;

        $this->expectOutputString($output);

        // chaining
    }

    /**
     * public function newLine($count = 1)
     *
     * Move the cursor to the next line
     * This is not an ANSI sequence, but rather the ASCII code 12 or \n
     *
     * param int $count - the number of newlines to output
     * return $this
     */
    public function test_newLine() {
        $carriageReturnFire = "CR";


        // simply call it, it just produces \n
        (new TerminalStub("VT100"))->newLine();
        $output = "\n" . $carriageReturnFire;

        // chaining
        $clio = new TerminalStub("VT100");
        $clio->newLine()->newLine();
        $output .= "\n" . $carriageReturnFire . "\n" . $carriageReturnFire;

        // two new lines
        $clio->newLine(2);
        $output .= "\n\n" . $carriageReturnFire;

        // invalid data, put out one newline
        $clio->newLine(-2);
        $output .= "\n" . $carriageReturnFire;
        $clio->newLine("two");
        $output .= "\n" . $carriageReturnFire;


        // chaining
        // ensure the cursor is set back to zero after the clear screen
        $clio->display("a")->newLine()->display("b")->newLine();
        $output .= "a" .  "\n" . $carriageReturnFire . "b\n" . $carriageReturnFire;

        $this->expectOutputString($output);

    }


    /**
     * public function clearScreen()
     *
     * Clear the screen and move cursor to the top.
     *
     * return $this
     */
    public function test_clearScreen() {

        $clearSeq = $this->CSI . "H" . $this->CSI . "2J";
        $carriageReturnFire = "CR";

        // generate the clear screen sequence
        (new TerminalStub("VT100"))->clearScreen();
        $output = $clearSeq . $carriageReturnFire;

        // test that any pending styling is sent out
        $clio = new TerminalStub("VT100");
        $clio->setBold(true);

        $clio->clearScreen()->display("Clear")->clearScreen();
        $output .= "\\e[1m" . $clearSeq  . $carriageReturnFire . "Clear" . $clearSeq . $carriageReturnFire;


        // chaining
        $clio = new TerminalStub("VT100");

        $clio->clearScreen()->display("Clear")->clearScreen();
        $output .= $clearSeq  . $carriageReturnFire . "Clear" . $clearSeq . $carriageReturnFire;

        $this->expectOutputString($output);




    }


    /**
     * public function beep()
     *
     * Produce a beep on the terminal, this is not part of ANSI, but rather and ASCII code
     * It may or may not work on other terminal emulators.
     */
    public function test_beep() {

        // generate the clear screen sequence
        (new TerminalStub("VT100"))->beep();
        $output = "\007";


        // chaining
        $clio = new TerminalStub("VT100");
        $clio->beep()->beep();
        $output .= "\007\007";

        $this->expectOutputString($output);


    }

    /**
     * public function caret($caret = null)
     *
     * Override the default of ">" as the prompt caret.  Do not add a space (that is done automatically)
     *
     * param string | null $caret - send in null to reset to '>'
     * return $this
     */
    public function test_caret() {

        /**
         * @var Terminal $stub
         */
        $stub = $this->getMockBuilder('TerminalStub')->setMethods(["readUserInput"])->getMock();
        /** @noinspection PhpUndefinedMethodInspection */
        $stub->method('readUserInput')
            ->will($this->returnArgument(0));

        $answer = $stub->caret(":")->prompt("Using colon");
        $this->assertEquals("Using colon: ", $answer);

        $answer = $stub->caret("")->prompt("Using nothing");
        $this->assertEquals("Using nothing ",$answer);

        $answer = $stub->caret(null)->prompt("Using null");
        $this->assertEquals("Using null> ",$answer);

        // chaining
        $answer = $stub->caret(">>")->caret(":")->prompt("Using colon");
        $this->assertEquals("Using colon: ", $answer);

    }

    /**
     * public function prompt($text)
     *
     * Prompt for a value.
     *
     * param $text - the prompt string
     * return $this
     */
    public function test_prompt() {

        /**
         * @var Terminal $stub
         */
        $stub = $this->getMockBuilder('TerminalStub')->setMethods(["readUserInput"])->getMock();
        /** @noinspection PhpUndefinedMethodInspection */
        $stub->method('readUserInput')
            ->will($this->returnArgument(0));

        $answer = $stub->prompt("This is a prompt");
        $this->assertEquals("This is a prompt> ",$answer);

        // be sure the prompt sends out the bold escape sequencing
        $stub->setBold();
        $answer = $stub->prompt("This is a prompt");
        $this->assertEquals("This is a prompt> ",$answer);
        $this->expectOutputString("\\e[1m");

    }


    /////////////////////////////////////////////////////////////////////////////////////////
    //                                 Property Getters                                    //
    /////////////////////////////////////////////////////////////////////////////////////////

    /**
     * static function getTerminalType
     *
     * Get the current screen terminal type
     *
     * @return string - the terminal type
     */
    public function test_getTerminalType() {


        putenv("TERM=xterm");

        // test for the normal case
        $this->assertSame("xterm",Terminal::getTerminalType());

        putenv("TERM=junk");

        $this->assertSame("junk",Terminal::getTerminalType());


    }

    /**
     * static function getScreenHeight()
     *
     * Get the current screen height
     * @return int - the number of lines it holds
     */
    public function test_getScreenHeight() {

        putenv("TERM=xterm");

        // test the normal case
        $height = Terminal::getScreenHeight();
        $this->assertEquals($height, 24);

        // bad $TERM
        putenv("TERM=junk");
        $this->expectException(RuntimeException::class);
        Terminal::getScreenHeight();
    }

    /**
     * static function getScreenWidth()
     *
     * Get the current screen width
     * @return int - the number of characters that will fit across the screen
     */
    public function test_getScreenWidth() {

        putenv("TERM=xterm");

        // test the normal case
        $width = Terminal::getScreenWidth();
        $this->assertEquals($width, 80);

        // create a bad TERM value
        putenv("TERM=junk");

        // it will throw an exception
        $this->expectException(RuntimeException::class);
        Terminal::getScreenWidth();


    }

    /**
     * static function getScreenMaxColors()
     *
     * Get the current maximum colors
     * @return int - the maximum colors, so far, 8, 16 and 256 should be expected
     */
    public function test_getScreenMaxColors() {

        putenv("TERM=xterm");

        // test the normal case
        $colors = Terminal::getScreenMaxColors();
        $this->assertEquals($colors, 8);

        putenv("TERM=xterm-256color");
        $colors = Terminal::getScreenMaxColors();
        $this->assertEquals($colors, 256);

    }

}