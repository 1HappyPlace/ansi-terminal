<?php

namespace ANSI;

use ANSI\Color\ColorInterface;
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

interface TerminalInterface
{

    /**
     * Set the state of the terminal directly
     *
     * @param TerminalStateInterface $state
     */
    public function setState(TerminalStateInterface $state);

    /**
     * Gets the desired state of the terminal, note that this is not related to the actual state
     * of the terminal, rather, the desired state that will happen the next time text is output
     * 
     * @return TerminalStateInterface
     */
    public function getState();


    /////////////////////////////////////////////////////////////////////////////////////////
    //                                 Abstract Methods                                    //
    /////////////////////////////////////////////////////////////////////////////////////////

    /**
     * 
     * All output goes to this function
     *
     * @param string $text
     */
    public function output($text);

    /**
     * Anytime the cursor is returned to the leftmost column, this is fired
     */
    public function carriageReturn();



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
    public function setBold($on = true);

    /**
     * Returns the current desired state of bolding, this may not represent what has
     * been commanded to the terminal, but rather the current intent.  Commanding only
     * happens with display
     * 
     * @return bool
     */
    public function getBold();


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
    public function setUnderscore($on = true);

    /**
     * Returns the current desired state of underscoring, this may not represent what has
     * been commanded to the terminal, but rather the current intent.  Commanding only
     * happens with display
     *
     * @return bool
     */
    public function getUnderscore();

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
    public function setTextColor($color);

    /**
     * Return the currently desired text color, keep in mind this may not be what has
     * been commanded to the terminal, the commanding only goes out the door with display
     * 
     * @return ColorInterface
     */
    public function getTextColor();


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
    public function setFillColor($color);

    /**
     * Return the currently desired fill color, keep in mind this may not be what has
     * been commanded to the terminal, the commanding only goes out the door with display
     *
     * @return ColorInterface
     */
    public function getFillColor();

    /**
     * Set both the fill and text colors
     *
     * @param $textColor int|string|null $color - can be either a Color constant Color::Blue or a string with the same spelling "blue", "Red", "LIGHT CYAN", etc
     * @param $fillColor int|string|null $color - can be either a Color constant Color::Blue or a string with the same spelling "blue", "Red", "LIGHT CYAN", etc
     * 
     * @return $this
     */
    public function setColors($textColor = null, $fillColor = null);


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
    public function clear($rightAway = false);

    /**
     * Send out the escape sequence which will accomplish the desired state
     */
    public function outputEscapeSequence();

    /**
     * Display the text.  This does not jump down to a new line.
     * If a temporary style is used, only the values that are not null will be used.
     *
     * @param $text
     *
     * @return $this
     */
    public function display($text);

    /**
     * Move the cursor to the next line
     * This is not an ANSI sequence, but rather the ASCII code 12 or \n
     *
     * @param int $count - the number of newlines to output
     * @return $this
     */
    public function newLine($count = 1);


    /**
     * Clear the screen and move cursor to the top.
     *
     * @return $this
     */
    public function clearScreen();
    

    /**
     * Produce a beep on the terminal, this is not part of ANSI, but rather and ASCII code
     * It may or may not work on other terminal emulators.
     */
    public function beep();

    /**
     * Override the default of ">" as the prompt caret.  Do not add a space (that is done automatically)
     *
     * @param string | null $caret - send in null to reset to '>'
     * @return $this
     */
    public function caret($caret = null);

    /**
     * Prompt for a value.
     *
     * @param $text - the prompt string
     * @return $this
     */
    public function prompt($text);


    /**
     * Helper function to call the php function readline, just for stubbing out stdin
     * @param string $prompt
     * @return string - the answer typed by the user
     * @codeCoverageIgnore
     */
    public function readUserInput($prompt);


    /////////////////////////////////////////////////////////////////////////////////////////
    //                                 Property Getters                                    //
    /////////////////////////////////////////////////////////////////////////////////////////
    
    
    /**
     * Get the current screen terminal type
     *
     * @return string - the terminal type
     */
    public static function getTerminalType();

    /**
     * Get the current screen height
     *
     * @uses errorHandler
     * @return int - the number of lines it holds
     * @throws RuntimeException
     */
    public static function getScreenHeight();

    /**
     * Get the current screen width
     *
     * @uses errorHandler
     * @return int - the number of characters that will fit across the screen
     * @throws RuntimeException
     */
    public static function getScreenWidth();

    /**
     * Get the current maximum colors
     *
     * @uses errorHandler
     * @return int - the maximum colors, so far, 8, 16 and 256 should be expected
     */
    public static function getScreenMaxColors();

}