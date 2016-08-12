<?php

namespace ANSI\Color;

/**
 * This class is part of the Clio Open Source project, Clio.1happyplace.com
 * Copyright, Katie Ayres, katie@1happyplace.com
 *
 * Available through the MIT license
 * @license MIT
 *
 * This class holds a terminal mode, it will be one of the following:
 *      - VT100 - original mode from the 80's, 16 colors
 *      - xterm - very common mode, 256 colors
 *      - RGB - allowing for full RGB control
 *
 */
class Mode
{
    /**
     * VT100 mode, here mainly for legacy, or if there is a situation where it is the only choice.
     * This mode only support 16 colors that are somewhat random in that they exist because that was all hardware could
     * do in the 1980's, but has nothing to do with good color theory.
     */
    const VT100 = "VT100";

    /**
     * XTerm mode, where colors are defined by a number between 0-255.  This appears to be widely supported and a good bet
     */
    const XTERM = "XTERM";

    /**
     * RGB mode, the crown jewel, if you know that you are writing for one terminal emulator only and you ran
     * the ColorTest.php and saw the RGB working, you have all colors at your disposal
     */
    const RGB   = "RGB";

    /**
     * Array of constant strings to allow for the constructor to receive "VT100" or "xterm"
     * @var array
     */
    private static $constants = [
        self::VT100, self::XTERM, self::RGB
    ];

    /**
     * The terminal mode
     * @var string
     */
    protected $mode = null;

    /**
     * Mode constructor.
     * @param Mode | int | string $mode
     *      Mode 
     *          send in a Mode object built already
     *      integer -
     *          send in the desired number of colors to pick the closest mode (<16 for VT100, >16 and <256 for xterm and > 256 for RGB)
     *      string -
     *          send in one of the constants Mode::VT100, Mode::XTERM, or Mode::RGB
     *          send in one of the actual string values for the constants (case insensitive) "vt100", "RGB", "xterm"
     */
    public function __construct($mode = self::XTERM)
    {
        // simply call the setter
        $this->setMode($mode);
    }

    /**
     * Helper function to take a value and turn it into a valid constant integer value
     *
     * @param string | int $value 
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
    protected static function getModeConstant($value) {
        
        // if the value coming in, is a integer, ensure it is one of the constants
        if (is_int($value)) {

            // it can be the number of colors
            // if it is less than or equal to 16,
            if ($value <= 16) {

                // then it is the simple VT100
                return self::VT100;

            // if it is less than or equal to 256
            } else if ($value <= 256) {

                // then it is the middling xterm like terminal
                return self::XTERM;

            // if it is greater than 256
            } else {

                // then an attempt at the highest colors is made
                return self::RGB;
            }

        }
        // if the value coming in is a string
        else if (is_string($value)) {

            // trim the string
            $value = trim($value);

            // transform to uppercase
            $value = strtoupper($value);

            // make sure it matches one of the constant integer values
            if (in_array($value, self::$constants)) {

                // it is valid, return it
                return $value;

            } else {

                // not a valid string
                return self::XTERM;
            }

        } else {

            // something went wrong, return left
            return self::XTERM;
        }

    }

    /**
     * Return the mode which is one of the string constants
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->mode;
    }



    /**
     * @return string - one of the above constants VT100, XTERM or RGB 
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param Mode | int | string $mode
     *      Mode
     *          send in a Mode object built already
     *      integer -
     *          send in the desired number of colors to pick the closest mode (<16 for VT100, >16 and <256 for xterm and > 256 for RGB)
     *      string -
     *          send in one of the constants Mode::VT100, Mode::XTERM, or Mode::RGB
     *          send in one of the actual string values for the constants (case insensitive) "vt100", "RGB", "xterm"
     */
    public function setMode($mode)
    {
        // if it is an instance of this class
        if ($mode instanceof self) {
            
            // copy it
            $this->mode = $mode->getMode();
        
        // it is a normal parameter
        } else {
            
            // 
            $this->mode = self::getModeConstant($mode);           
        }

    }



}