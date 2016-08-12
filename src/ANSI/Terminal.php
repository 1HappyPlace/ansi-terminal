<?php

namespace ANSI;

use ANSI\Color\ColorInterface;
use ANSI\Color\Mode;
use RuntimeException;

/**
 * This class is part of the Clio Open Source project, Clio.1happyplace.com
 * Copyright, Katie Ayres, katie@1happyplace.com
 *
 * Available through the MIT license
 * @license MIT
 *
 * The Terminal class controls a terminal emulator such as bash.  It is an
 * abstract class with the following two abstract methods:
 *          abstract public function output($text); - determine where all the output goes
 *          abstract public function carriageReturn(); - fires whenever the carriage return is hit
 * 
 *
 */

abstract class Terminal
{
    
    /**
     * The current state of the terminal, bold, underscore, and colors
     * @var TerminalState
     */
    protected $currentState;
    
    /**
     * The desired state built during calls to set different styles of the terminal
     * The new styling is accumulated and sent out when a display is requested
     * 
     * @var TerminalState
     */
    protected $desiredState;

    /**
     * The generator of escape sequencing based on the mode of the terminal
     * @var EscapeSequenceGenerator
     */
    protected $generator;

    /**
     * The prompt caret shown after the text of the prompt
     * @var string - the character
     */
    protected $promptCaret = ">";


    /**
     * Clio constructor.
     * @param Mode | int | string $mode
     *      Mode
     *          send in a Mode object built already
     *      integer -
     *          send in the desired number of colors to pick the closest mode (<16 for VT100, >16 and <256 for xterm and > 256 for RGB)
     *      string -
     *          send in one of the constants Mode::VT100, Mode::XTERM, or Mode::RGB
     *          send in one of the actual string values for the constants (case insensitive) "vt100", "RGB", "xterm"
     */
    public function __construct($mode)
    {
        // save the mode
        $this->mode = new Mode($mode);

        // initialize the current and desired state to empty (no styling)
        $this->currentState = new TerminalState();
        $this->desiredState = new TerminalState();

        // create a new generator
        $this->generator = new EscapeSequenceGenerator($this->mode);


    }


    /////////////////////////////////////////////////////////////////////////////////////////
    //                                 Abstract Methods                                    //
    /////////////////////////////////////////////////////////////////////////////////////////

    /**
     * 
     * All output goes to this function
     *
     * @param string $text
     */
    abstract public function output($text);

    /**
     * Anytime the cursor is returned to the leftmost column, this is fired
     */
    abstract public function carriageReturn();



    /////////////////////////////////////////////////////////////////////////////////////////
    //                                          Bold                                       //
    /////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Set bolding on or off
     *
     * @param boolean $on
     * 
     * @return $this;
     */
    public function setBold($on = true) {
        
        // set the desired bold state
        $this->desiredState->setBold($on);

        // chaining
        return $this;
    }

    /**
     * Returns the current desired state of bolding, this may not represent what has
     * been commanded to the terminal, but rather the current intent.  Commanding only
     * happens with display
     * 
     * @return bool
     */
    public function getBold() {
        
        // return the desired state of bold
        return $this->desiredState->isBold();
    }


    /////////////////////////////////////////////////////////////////////////////////////////
    //                                      Underscore                                     //
    /////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Set underscoring on or off
     *
     * @param boolean $on
     *
     * @return $this;
     */
    public function setUnderscore($on = true) {

        // set the desired underscoring state
        $this->desiredState->setUnderscore($on);

        // chaining
        return $this;
    }

    /**
     * Returns the current desired state of underscoring, this may not represent what has
     * been commanded to the terminal, but rather the current intent.  Commanding only
     * happens with display
     *
     * @return bool
     */
    public function getUnderscore() {

        // return the desired state of bold
        return $this->desiredState->isUnderscore();
    }

    /////////////////////////////////////////////////////////////////////////////////////////
    //                                       Colors                                        //
    /////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Set the text color
     * 
     * @param ColorInterface | string | integer | array | null $color
     *      Color parameters can be:
     *          - Object adhering to the Color Interface
     *          - A color name "Antique White" or "antiquewhite"
     *          - Xterm integer from 0-255
     *          - [R,G,B]
     *          - null
     * 
     * @return $this
     */
    public function setTextColor($color) {
        
        // set the desired text color
        $this->desiredState->setTextColor($color);

        // chaining
        return $this;

    }

    /**
     * Return the currently desired text color, keep in mind this may not be what has
     * been commanded to the terminal, the commanding only goes out the door with display
     * 
     * @return ColorInterface
     */
    public function getTextColor() {
        
        // return the current desired text color
        return $this->desiredState->getTextColor();
    }


    /**
     * Set the fill color
     * 
     * @param ColorInterface | string | integer | array | null $color
     *     Color parameters can be:
     *          - Object adhering to the Color Interface
     *          - A color name "Antique White" or "antiquewhite"
     *          - Xterm integer from 0-255
     *          - [R,G,B]
     *          - null
     *
     * @return $this
     */
    public function setFillColor($color) {

        // remember the desired fill color
        $this->desiredState->setFillColor($color);

        // chaining
        return $this;
    }

    /**
     * Return the currently desired fill color, keep in mind this may not be what has
     * been commanded to the terminal, the commanding only goes out the door with display
     *
     * @return ColorInterface
     */
    public function getFillColor() {

        // return the current desired text color
        return $this->desiredState->getFillColor();
    }

    /**
     * Set both the fill and text colors
     *
     * @param $textColor int|string|null $color - can be either a Color constant Color::Blue or a string with the same spelling "blue", "Red", "LIGHT CYAN", etc
     * @param $fillColor int|string|null $color - can be either a Color constant Color::Blue or a string with the same spelling "blue", "Red", "LIGHT CYAN", etc
     * 
     * @return $this
     */
    public function setColors($textColor = null, $fillColor = null) {

        // set the desired text and fill
        $this->desiredState->setTextColor($textColor);
        $this->desiredState->setFillColor($fillColor);

        // chaining
        return $this;
    }


    /////////////////////////////////////////////////////////////////////////////////////////
    //                                       Display                                       //
    /////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Clear away all formatting - bold, underscore, text and fill color
     *
     * @param boolean $rightAway - whether to send out the escape sequence right away
     *          or allow the display to do it later
     * @return $this
     */
    public function clear($rightAway = false) {

        // clear the old settings
        $this->desiredState->clear();

        // if it desired to send out the clear sequence right away
        if ($rightAway) {
            
            // send it out
            $this->output(EscapeSequenceGenerator::generateClearSequence());

            // reset the two states to cleared
            $this->currentState = new TerminalState();
            $this->desiredState = new TerminalState();
        }


        // chaining
        return $this;
    }



    /**
     * Display the text.  This does not jump down to a new line.
     * If a temporary style is used, only the values that are not null will be used.
     *
     * @param $text
     *
     * @return $this
     */
    public function display($text) {

        // send out any escaping to implement anything sitting in the desired state
        $this->output($this->generator->generate($this->currentState, $this->desiredState));

        // copy the current state to the now achieved desired state
        $this->currentState = clone $this->desiredState;

        // Send out the text
        $this->output($text);

        // chaining
        return $this;
    }

    /**
     * Move the cursor to the next line
     * This is not an ANSI sequence, but rather the ASCII code 12 or \n
     *
     * @param int $count - the number of newlines to output
     * @return $this
     */
    public function newLine($count = 1) {

        // if the $count is greater than one
        if (is_int($count) && $count > 1) {

            // send out the \n $count times
            for ($i=0; $i<$count; ++$i) {

                // echo the newline character
                $this->output("\n");
            }
            
        } else {
            // the parameter might be one or something crazy, just output one
            // echo the new line character
            $this->output("\n");
        }
        
        // fire the handler that indicates the cursor is sent to the left margin
        $this->carriageReturn();

       // chaining
        return $this;
    }


    /**
     * Clear the screen and move cursor to the top.
     *
     * @return $this
     */
    public function clearScreen() {

        // escape sequences to clear screen and move it up
        $this->output(EscapeSequenceGenerator::generateClearScreenSequence());
        
        // fire the handler that indicates the cursor is sent to the left margin
        $this->carriageReturn();     

        // chaining
        return $this;
    }
    

    /**
     * Produce a beep on the terminal, this is not part of ANSI, but rather and ASCII code
     * It may or may not work on other terminal emulators.
     */
    public function beep() {
        
        // sequence for beep
        $this->output("\007");

        // chaining
        return $this;
    }

    /**
     * Override the default of ">" as the prompt caret.  Do not add a space (that is done automatically)
     *
     * @param string | null $caret - send in null to reset to '>'
     * @return $this
     */
    public function caret($caret = null) {

        // if it is a string (even one with no length)
        if (is_string($caret)) {

            // save it
            $this->promptCaret = $caret;

        } else {

            // reset caret to the default
            $this->promptCaret = ">";
        }

        // chaining
        return $this;
    }

    /**
     * Prompt for a value.
     *
     * @param $text - the prompt string
     * @return $this
     */
    public function prompt($text) {

        // save off the prompt string
        $prompt = $text  . $this->promptCaret . " ";

        // prompt and return the answer
        return $this->readUserInput($prompt);

    }


    /**
     * Helper function to call the php function readline, just for stubbing out stdin
     * @param string $prompt
     * @return string - the answer typed by the user
     * @codeCoverageIgnore
     */
    public function readUserInput($prompt) {
        return readline($prompt);
    }


    /////////////////////////////////////////////////////////////////////////////////////////
    //                                 Property Getters                                    //
    /////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Error handler to catch errors when using the exec() function
     * @param int $errno
     * @param string $errstr
     * @throws RuntimeException
     */
    private static function errorHandler($errno, $errstr) {

        // generate the error (this has to be global to the class)
        // build the message
        $message = "The PHP CLI php.ini file has disable_function = exec, or an invalid \$TERM, it cannot determine screen attributes.\n";

        // add the error number if there is one
        if ($errno) {

            // append the error number to the string
            $message .= "[PHP #{$errno}] {$errstr}";
        }

        // throw the exception that can be caught
        throw new RuntimeException($message);

    }
    
    /**
     * Get the current screen terminal type
     *
     * @return string - the terminal type
     */
    public static function getTerminalType() {

        // return the value of the $TERM environment variable
        return getenv("TERM");


    }

    /**
     * Get the current screen height
     *
     * @uses errorHandler
     * @return int - the number of lines it holds
     * @throws RuntimeException
     */
    public static function getScreenHeight() {

        // set a simple error handler that indicates the exec function was disabled
        set_error_handler("self::errorHandler", E_WARNING);

        // initialize the array for the output of the execute
        $output = [];

        // execute the bash command tput cols to determine the screen width
        $height = exec("tput lines 2>&1", $output);

        // if the height is zero, then something went wrong
        if ($height == 0 || $height == "" || is_null($height)) {

            // use the error handler to raise the exception
            self::errorHandler(null,null );

        } 


        // put back the error handler
        restore_error_handler();

        // return the width
        return intval($height);



    }

    /**
     * Get the current screen width
     *
     * @uses errorHandler
     * @return int - the number of characters that will fit across the screen
     * @throws RuntimeException
     */
    public static function getScreenWidth() {

        // set a simple error handler that indicates the exec function was disabled
        set_error_handler("self::errorHandler", E_WARNING);

        // initialize the array for the output of the execute
        $output = [];

        // execute the bash command tput cols to determine the screen width
        $width = exec("tput cols 2>&1", $output);

        // if the height is zero, then something went wrong
        if (count($output) == 0 ||$width == 0 || $width == "" || is_null($width)) {

            // use the error handler to raise the exception
            self::errorHandler(null,null);


        }

        // put back the error handler
        restore_error_handler();

        // return the height
        return intval($width);


    }

    /**
     * Get the current maximum colors
     *
     * @uses errorHandler
     * @return int - the maximum colors, so far, 8, 16 and 256 should be expected
     */
    public static function getScreenMaxColors() {

        // set a simple error handler that indicates the exec function was disabled
        set_error_handler("self::errorHandler", E_WARNING);

        // execute the bash command tput cols to determine the screen width
        $maxColors = exec('tput colors');

        // put back the error handler
        restore_error_handler();

        // return the max colors
        return intval($maxColors);

    }

}