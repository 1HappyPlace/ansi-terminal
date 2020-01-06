<?php

use ANSI\Color\Color;
use ANSI\TerminalState;
use PHPUnit\Framework\TestCase;



class TerminalStateTest extends TestCase
{

    public function setUp(): void
    {


    }

    public function tearDown(): void
    {

    }



    /**
     * function __construct($mode)
     * 
     * TerminalState constructor.
     *
     *    int $mode - the mode of the terminal
     */
    public function test_construct() {

        $state = new TerminalState();

        // ensure bold and underscore are turned off
        $this->assertFalse($state->isBold());
        $this->assertFalse($state->isUnderscore());

        // ensure the text color is not valid
        $textColor = $state->getTextColor();
        $this->assertInstanceOf("ANSI\\Color\\Color", $textColor);
        $this->assertFalse($textColor->isValid());

        // ensure the fill color is not valid
        $fillColor = $state->getFillColor();
        $this->assertInstanceOf("ANSI\\Color\\Color", $fillColor);
        $this->assertFalse($fillColor->isValid());

    }

    /**
     * public function clear()
     * public function isClear();
     * 
     * Set the state to clear, no styling
     */
    public function test_clearIsClear() {
        
        $state = new TerminalState();
        
        $this->assertTrue($state->isClear());
        
        $state->setBold(true);
        $this->assertFalse($state->isClear());
        $state->clear();
        $this->assertTrue($state->isClear());
        
        $state = new TerminalState();
        $state->setUnderscore(true);
        $this->assertFalse($state->isClear());
        $state->clear();
        $this->assertTrue($state->isClear());
        
        $state = new TerminalState();
        $state->setTextColor('green');
        $this->assertFalse($state->isClear());
        $state->clear();
        $this->assertTrue($state->isClear());
        
        $state = new TerminalState();
        $state->setFillColor('black');
        $this->assertFalse($state->isClear());
        
        $state->clear();
        $this->assertTrue($state->isClear());
        
        $state->setBold(true)->setTextColor("green");
        $this->assertFalse($state->isClear());


        $state->clear();
        $this->assertTrue($state->isClear());
        
        
    } 
    
    /**
     * function isBold()
     * function setBold($bold)
     * 
     * Whether bolding is on
     *
     * return boolean
     */
    public function test_isGetBold() {

        $state = new TerminalState();

        // initial value is off
        $this->assertFalse($state->isBold());

        // set bold to on
        $state->setBold(true);
        $this->assertTrue($state->isBold());

        // set bold to off
        $state->setBold(false);
        $this->assertFalse($state->isBold());

        // some other type
        $state->setBold("bold");
        $this->assertTrue($state->isBold());
        
    }

    /**
     * function isUnderscore()
     * function setUnderscore($underscore)
     * 
     * 
     * Whether underscoring is on
     *
     * return boolean
     */
    public function test_isGetUnderscore() {

        $state = new TerminalState();

        // initial state is off
        $this->assertFalse($state->isUnderscore());

        // set underscore to on
        $state->setUnderscore(true);
        $this->assertTrue($state->isUnderscore());

        // set it to off
        $state->setUnderscore(false);
        $this->assertFalse($state->isUnderscore());
        
        // some other type than boolean
        $state->setUnderscore(19);
        $this->assertTrue($state->isUnderscore());
        
    }

    /**
     * function getTextColor()
     * function setTextColor($textColor)
     *   ColorInterface | string | integer | array | null $textColor
     *     Color parameters can be:
     *          - Object adhering to the Color Interface
     *          - A color name "Antique White" or "antiquewhite"
     *          - Xterm integer from 0-255
     *          - [R,G,B]
     *          - null
     */
    public function test_getSetTextColor() {

        $state = new TerminalState();

        // initial value is not valid (null color)
        $textColor = $state->getTextColor();
        $this->assertInstanceOf("ANSI\\Color\\Color", $textColor);
        $this->assertFalse($textColor->isValid());

        // some colors to play with
        $red = Color::red();
        $blue = Color::blue();

        // set text color to the string red
        $state->setTextColor("red");
        $this->assertEquals($red,$state->getTextColor());

        // set to an object blue
        $state->setTextColor($blue);
        $this->assertEquals($blue,$state->getTextColor());

        // chaining
        $color = $state->setTextColor("black")->setTextColor("blue")->getTextColor();
        $this->assertEquals($blue,$color);

        // invalid
        $state->setTextColor("NoColor");
        $this->assertFalse($state->getTextColor()->isValid());

        
    }


    /**
     * function getFillColor()
     * function setFillColor($fillColor)
     *    ColorInterface | string | integer | array | null $fillColor
     *     Color parameters can be:
     *          - Object adhering to the Color Interface
     *          - A color name "Antique White" or "antiquewhite"
     *          - Xterm integer from 0-255
     *          - [R,G,B]
     *          - null
     * 
     * Get the current fill color
     *
     * @return Color
     */
    public function test_getSetFillColor() {
        $state = new TerminalState();

        // initial value is not valid (null color)
        $fillColor = $state->getFillColor();
        $this->assertInstanceOf("ANSI\\Color\\Color", $fillColor);
        $this->assertFalse($fillColor->isValid());

        // some colors to play with
        $red = Color::red();
        $blue = Color::blue();

        // set fill color to the string red
        $state->setFillColor("red");
        $this->assertEquals($red,$state->getFillColor());

        // set to an object blue
        $state->setFillColor($blue);
        $this->assertEquals($blue,$state->getFillColor());

        // chaining
        $color = $state->setFillColor("black")->setFillColor("blue")->getFillColor();
        $this->assertEquals($blue,$color);

        // invalid
        $state->setFillColor("NoColor");
        $this->assertFalse($state->getFillColor()->isValid());
    }

 
    /**
     * public function findChanges(TerminalStateInterface $desired)
     * 
     * Compare the desired state and capture any things that are going from off to on, if something is going
     * from on to off, then a clear needs to be sent along with all the desired state, in this case
     * this function returns null
     *
     * param TerminalStateInterface $desired
     * return null | TerminalState - returns null if a clear is needed and the entire desired sequence needs to be created
     *                                otherwise it returns a TerminalState object that contains only the properties that are changing
     *                                between the actual and desired
     */
    public function test_findChanges() {

        $state = new TerminalState();
        $desired = new TerminalState();

        // the two states are the same, nothing will be set in the returned TerminalState
        $changes = $state->findChanges($desired);
        $this->assertFalse($changes->isBold());
        $this->assertFalse($changes->isUnderscore());
        $this->assertInstanceOf("\\ANSI\\Color\\Color", $changes->getTextColor());
        $this->assertFalse($changes->getTextColor()->isValid());
        $this->assertInstanceOf("\\ANSI\\Color\\Color", $changes->getFillColor());
        $this->assertFalse($changes->getFillColor()->isValid());
        
        // turn on bold
        $desired->setBold(true);
        $changes = $state->findChanges($desired);
        $this->assertTrue($changes->isBold());
        $this->assertFalse($changes->isUnderscore());
        $this->assertInstanceOf("\\ANSI\\Color\\Color", $changes->getTextColor());
        $this->assertFalse($changes->getTextColor()->isValid());
        $this->assertInstanceOf("\\ANSI\\Color\\Color", $changes->getFillColor());
        $this->assertFalse($changes->getFillColor()->isValid());


        // turn on underscore
        $desired->setUnderscore(true);
        $changes = $state->findChanges($desired);
        $this->assertTrue($changes->isBold());
        $this->assertTrue($changes->isUnderscore());
        $this->assertInstanceOf("\\ANSI\\Color\\Color", $changes->getTextColor());
        $this->assertFalse($changes->getTextColor()->isValid());
        $this->assertInstanceOf("\\ANSI\\Color\\Color", $changes->getFillColor());
        $this->assertFalse($changes->getFillColor()->isValid());

        // set a text color
        $desired->setTextColor("orange");
        $changes = $state->findChanges($desired);
        $this->assertTrue($changes->isBold());
        $this->assertTrue($changes->isUnderscore());
        $this->assertInstanceOf("\\ANSI\\Color\\Color", $changes->getTextColor());
        $this->assertSame("orange",$changes->getTextColor()->getName());
        $this->assertInstanceOf("\\ANSI\\Color\\Color", $changes->getFillColor());
        $this->assertFalse($changes->getFillColor()->isValid());

        // make the current state also set to orange, but a different instance of Color, still should find no changes
        $state->setTextColor("orange");
        $changes = $state->findChanges($desired);
        $this->assertNull($changes->getTextColor()->getName());

        // now use the exact same blue
        $blue = new Color("blue");
        $state->setTextColor($blue);
        $desired->setTextColor($blue);
        $changes = $state->findChanges($desired);
        $this->assertNull($changes->getTextColor()->getName());


        // set a different text color
        $state->setTextColor("orange");
        $desired->setTextColor("blue");
        $changes = $state->findChanges($desired);
        $this->assertTrue($changes->isBold());
        $this->assertTrue($changes->isUnderscore());
        $this->assertInstanceOf("\\ANSI\\Color\\Color", $changes->getTextColor());
        $this->assertSame("blue",$changes->getTextColor()->getName());
        $this->assertInstanceOf("\\ANSI\\Color\\Color", $changes->getFillColor());
        $this->assertFalse($changes->getFillColor()->isValid());

        // set a fill color
        $desired->setFillColor("green");
        $changes = $state->findChanges($desired);
        $this->assertTrue($changes->isBold());
        $this->assertTrue($changes->isUnderscore());
        $this->assertInstanceOf("\\ANSI\\Color\\Color", $changes->getTextColor());
        $this->assertSame("blue",$changes->getTextColor()->getName());
        $this->assertInstanceOf("\\ANSI\\Color\\Color", $changes->getFillColor());
        $this->assertSame("green",$changes->getFillColor()->getName());

        // set a different fill color
        $state->setFillColor("green");
        $desired->setFillColor("black");
        $changes = $state->findChanges($desired);
        $this->assertTrue($changes->isBold());
        $this->assertTrue($changes->isUnderscore());
        $this->assertInstanceOf("\\ANSI\\Color\\Color", $changes->getTextColor());
        $this->assertSame("blue",$changes->getTextColor()->getName());
        $this->assertInstanceOf("\\ANSI\\Color\\Color", $changes->getFillColor());
        $this->assertSame("black",$changes->getFillColor()->getName());

        // make the current state also set to black, but a different instance of Color, still should find no changes
        $state->setFillColor("black");
        $changes = $state->findChanges($desired);
        $this->assertNull($changes->getFillColor()->getName());

        // now use the exact same blue
        $blue = new Color("blue");
        $state->setFillColor($blue);
        $desired->setFillColor($blue);
        $changes = $state->findChanges($desired);
        $this->assertNull($changes->getFillColor()->getName());



        // now set the actual to the desired
        $state = clone $desired;
        $changes = $state->findChanges($desired);
        $this->assertFalse($changes->isBold());
        $this->assertFalse($changes->isUnderscore());
        $this->assertInstanceOf("\\ANSI\\Color\\Color", $changes->getTextColor());
        $this->assertFalse($changes->getTextColor()->isValid());
        $this->assertInstanceOf("\\ANSI\\Color\\Color", $changes->getFillColor());
        $this->assertFalse($changes->getFillColor()->isValid());

         // now turn off underscore
        $desired->setUnderscore(false);
        $this->assertNull($state->findChanges($desired));

        // turn off fill color
        $state = clone $desired;
        $desired->setFillColor(null);
        $this->assertNull($state->findChanges($desired));

        // turn off bold
        $state = clone $desired;
        $desired->setBold(false);
        $this->assertNull($state->findChanges($desired));

        // turn off the text color
        $state = clone $desired;
        $desired->setTextColor(null);
        $this->assertNull($state->findChanges($desired));


        // set a case where only the text color is changing from a valid text color
        $state = new TerminalState();
        $desired = new TerminalState();;
        $state->setTextColor("blue");
        $desired->setTextColor("red");
        $changes = $state->findChanges($desired);
        $this->assertFalse($changes->isBold());
        $this->assertFalse($changes->isUnderscore());
        $this->assertInstanceOf("\\ANSI\\Color\\Color", $changes->getTextColor());
        $this->assertSame("red",$changes->getTextColor()->getName());
        $this->assertInstanceOf("\\ANSI\\Color\\Color", $changes->getFillColor());
        $this->assertFalse($changes->getFillColor()->isValid());

        // set a case where only the fill color is changing from a valid fill color
        $state = new TerminalState();
        $desired = new TerminalState();
        $state->setFillColor("green");
        $desired->setFillColor("orange");
        $changes = $state->findChanges($desired);
        $this->assertFalse($changes->isBold());
        $this->assertFalse($changes->isUnderscore());
        $this->assertInstanceOf("\\ANSI\\Color\\Color", $changes->getTextColor());
        $this->assertFalse($changes->getTextColor()->isValid());
        $this->assertInstanceOf("\\ANSI\\Color\\Color", $changes->getFillColor());
        $this->assertSame("orange",$changes->getFillColor()->getName());

    }
}


