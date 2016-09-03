<?php


namespace ANSI;


use ANSI\Color\ColorInterface;
use ANSI\Color\Mode;

/**
 * This class is part of the Clio Open Source project, Clio.1happyplace.com
 * Copyright, Katie Ayres, katie@1happyplace.com
 *
 * Available through the MIT license
 * @license MIT
 *
 * This class generates in-band signalling in the form of escape sequences that
 * control bold, underscore, text and fill in terminal emulator output.
 * 
 * The particular escape sequencing for colors will be different depending on 
 * the Mode that must be specified in the constructor.  For example, to
 * start a text color of red, this is the escape sequence for each mode:
 *      - VT100: \e[91m
 *      - xterm: \e[38,5,9m
 *      - RGB:   \e[38,2,255;0;0m
 *
 * Bold and underscore are the same in any mode:
 *      - Bold: \e[1m
 *      - Underscore: \e[4m
 */

class EscapeSequenceGenerator
{
    /**
     * Shortcut for the opening escape sequence needed to set colors and style
     */
    const ESC = "\033";

    /**
     * Control Sequence Introducer, starts a sequence to tell the terminal to change the styling
     */
    const CSI = "\033[";
    /**
     * Control Sequence Ending, ends a sequence to tell the terminal to change the styling after one or more codes
     */
    const CSE = "m";

    /**
     * Shortcut for the code needed for shutting down all current styles and colors
     */
    const CLEAR = 0;

    /**
     * The code needed for bold
     */
    const BOLD = 1;

    /**
     * The code needed for underscore
     */
    const UNDERSCORE = 4;

    /**
     * The code needed for reverse
     */
    const REVERSE = 7;


    /**
     * Holds the color mode, VT100 (16 colors), XTERM (256 colors), RGB (millions)
     * @var Mode
     */
    public $mode;

    /**
     * EscapeSequenceGenerator constructor.
     * @param Mode | int | string $mode
     *      Mode
     *          send in a Mode object built already
     *      integer -
     *          send in the desired number of colors to pick the closest mode (<16 for VT100, >16 and <256 for xterm and > 256 for RGB)
     *      string -
     *          send in one of the constants Mode::VT100, Mode::XTERM, or Mode::RGB
     *          send in one of the actual string values for the constants (case insensitive) "vt100", "RGB", "xterm"
     *
     */
    public function __construct($mode)
    {
        $this->mode = new Mode($mode);
    }
    
    

    /**
     * Helper function that generates the clear sequence \033[0m
     *
     * @return string
     */
    public static function generateClearSequence() {

        // return the sequence \033[0m
        return self::CSI . self::CLEAR . self::CSE;
    }



    /**
     * Helper function that generates the bolding sequence \033[1m
     *
     * @return string
     */
    public static function generateBoldingSequence() {

        // return the sequence \033[0m
        return self::CSI . self::BOLD . self::CSE;
    }

    /**
     * Helper function that generates the bolding sequence \033[1m
     *
     * @return string
     */
    public static function generateUnderscoringSequence() {

        // return the sequence \033[4m
        return self::CSI . self::UNDERSCORE . self::CSE;
    }

    /**
     * Static helper function to generate a text color sequence
     * @param ColorInterface $textColor - the color desired
     * @param Mode $mode - the terminal mode
     *
     * @return string - the full escape sequence for the text color, or an empty string if color or mode is not valid
     */
    public static function generateTextColorSequence(ColorInterface $textColor, $mode) {

        $code = $textColor->generateColorCoding($mode);

        // if a code came back
        if ($code !== "") {
            // return the full sequence
            return self::CSI . $code . self::CSE;
        
        // no valid color code
        } else {
            
            // return nothing
            return "";
        }

    }

    /**
     * Static helper function to generate a fill color sequence
     * @param ColorInterface $fillColor - the color desired
     * @param Mode $mode - the terminal mode
     *
     * @return string - the full escape sequence for the text color
     */
    public static function generateFillColorSequence(ColorInterface $fillColor, $mode) {

        $code = $fillColor->generateColorCoding($mode, true);

        // if a code came back
        if ($code !== "") {
            
            // return the full sequence
            return self::CSI . $code . self::CSE;

            // no valid color code
        } else {

            // return nothing
            return "";
        }
    }

    /**
     * Helper function that generates the clear sequence \033[0m
     *
     * @return string
     */
    public static function generateClearScreenSequence() {

        // return the sequence \033[0m
        return self::ESC . "[H". self::ESC ."[2J";
    }

    /**
     * Generate the escape sequencing for a particular state
     * 
     * @param TerminalState $state - the state to achieve
     * @param boolean $reset - whether the zero reset code needs to start this sequence
     * @return string
     */
    public function generateSequence(TerminalState $state, $reset) {

        // this will return null if there are no active styles
        $sequence = "";

        // build an array of the currently active style codes
        $styles = [];
        if ($state->isBold())          {$styles[] = self::BOLD;}
        if ($state->isUnderscore())    {$styles[] = self::UNDERSCORE;}
        if ($state->getTextColor()->isValid())     {$styles[] = $state->getTextColor()->generateColorCoding($this->mode);}
        if ($state->getFillColor()->isValid())     {$styles[] = $state->getFillColor()->generateColorCoding($this->mode, true);}

        // if there is anything in the style array
        if (count($styles)) {

            // start the sequence with the control sequence introducer and a clear code
            $sequence = self::CSI;
            
            // if a reset was desired
            if ($reset) {
                
                // add the clear code
                $sequence .= self::CLEAR . ";";
            } 

            // go through the array of style codes
            for ($i = 0; $i < count($styles); ++$i) {

                // append the code
                $sequence .= $styles[$i];

                // ensure this is not the last code
                if ($i < (count($styles) - 1)) {

                    // add the semi-colon separator (but not after the last one)
                    $sequence .= ";";

                }
            }

            // append the closing sequence
            $sequence .= self::CSE;

        } else {

            // if nothing is changing, only need to send something if the reset was requested
            if ($reset) {
                
                // it may be that just one thing is turning off, send the clear code
                $sequence .= self::generateClearSequence();  
                
            }

        }

        return $sequence;
    }


    /**
     * Generate an escape sequence based on the current state and the new desired state
     *
     * @param TerminalStateInterface $currentState
     * @param TerminalState $desiredState
     * @return string
     */
    public function generate(TerminalStateInterface $currentState, TerminalState $desiredState) {

        // get a state object with anything that is changing
        $changes = $currentState->findChanges($desiredState);

        // if an object is returned, then just positive changes are occurring
        if ($changes) {
            
            // if there are really no changes
            if ($changes->isClear()) {

                // return an empty string
                return "";
               
            // there are some changes
            } else {

                // generate the sequence for the things that are actually changing
                return $this->generateSequence($changes, false);

            }


        // if null is returned, then something is getting turned off
        } else {

            // must generate a sequence with a clear
            return $this->generateSequence($desiredState, true);
        }



    }


}