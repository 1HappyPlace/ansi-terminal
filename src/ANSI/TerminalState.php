<?php

namespace ANSI;

use ANSI\Color\Color;
use ANSI\Color\ColorInterface;

/**
 * This class is part of the Clio Open Source project, Clio.1happyplace.com
 * Copyright, Katie Ayres, katie@1happyplace.com
 *
 * Available through the MIT license
 * @license MIT
 *
 * This class stores the state of a terminal, namely the styling
 * in effect at any time. This includes bold, underscore, text and fill colors.
 *
 */
class TerminalState implements TerminalStateInterface
{
    /**
     * Whether bolding is occurring
     * @var bool
     */
    public $bold;

    /**
     * Whether underscoring is occurring
     * @var bool
     */
    public $underscore;

    /**
     * The text color
     * @var Color
     */
    public $textColor;

    /**
     * The fill (background) color
     * @var Color
     */
    public $fillColor;

    /**
     * TerminalState constructor.
     */
    public function __construct()
    {
        // start with a blank slate
        $this->clear();

    }

    /**
     * Set the state to clear, no styling
     */
    public function clear() {

        // set bold and underscore to false
        $this->bold         = false;
        $this->underscore   = false;

        // set the text and fill color to empty colors
        $this->textColor    = new Color();
        $this->fillColor    = new Color(); 
    }

    /**
     * Return whether the terminal is in a cleared state (no styling)
     * @return bool
     */
    public function isClear() {

        // it is in a clear state if bold and underscore is off and text and fill colors are empty
        return (!$this->isBold() && !$this->isUnderscore() && $this->textColor->isEmpty() && $this->fillColor->isEmpty());
    }
    /**
     * Whether bolding is on
     * 
     * @return boolean
     */
    public function isBold()
    {
        return $this->bold;
    }

    /**
     * Turn on or off bolding
     * 
     * @param boolean $bold
     * @return $this
     */
    public function setBold($bold)
    {
        // get a boolean out of whatever is sent in and save it
        $this->bold = boolval($bold);
        
        // chaining
        return $this;
    }

    /**
     * Whether underscoring is on
     * 
     * @return boolean
     */
    public function isUnderscore()
    {
        return $this->underscore;
    }

    /**
     * Turn on or off underscoring
     * 
     * @param boolean $underscore
     * @return $this
     */
    public function setUnderscore($underscore)
    {
        // get a boolean out of whatever is sent in and save it
        $this->underscore = boolval($underscore);
        
        // chaining
        return $this;
    }

    /**
     * Get the current text color
     * 
     * @return Color
     */
    public function getTextColor()
    {
        return $this->textColor;
    }

    /**
     * Set the text color
     * 
     * @param ColorInterface | string | integer | array | null $textColor
     *     Color parameters can be:
     *          - Object adhering to the Color Interface
     *          - A color name "Antique White" or "antiquewhite"
     *          - Xterm integer from 0-255
     *          - [R,G,B]
     *          - null
     * 
     * @return $this
     */
    public function setTextColor($textColor)
    {
        // send whatever comes into the constructor of color which will sort it out
        $this->textColor = new Color($textColor);
        
        // chaining
        return $this;
    }

    /**
     * Get the current fill color
     * 
     * @return Color
     */
    public function getFillColor()
    {
        return $this->fillColor;
    }

    /**
     * Set the fill color
     * @param ColorInterface | string | integer | array | null $fillColor
     *     Color parameters can be:
     *          - Object adhering to the Color Interface
     *          - A color name "Antique White" or "antiquewhite"
     *          - Xterm integer from 0-255
     *          - [R,G,B]
     *          - null
     * 
     * @return $this
     */
    public function setFillColor($fillColor)
    {
        // send whatever comes into the constructor of color which will sort it out
        $this->fillColor = new Color($fillColor);
        
        // chaining
        return $this;
    }



    /**
     * Compare the desired state and capture any things that are going from off to on, if something is going
     * from on to off, then a clear needs to be sent along with all the desired state, in this case
     * this function returns null
     * 
     * @param TerminalStateInterface $desired
     * @return null | TerminalState - returns null if a clear is needed and the entire desired sequence needs to be created
     *                                otherwise it returns a TerminalState object that contains only the properties that are changing
     *                                between the actual and desired
     */
    public function findChanges(TerminalStateInterface $desired) {
        
        // create a Terminal State object that will hold the changes needed to achieve the desired state
        $ret = new self();
        
        // bold is currently off, and the desired is to turn it on
        if (!$this->isBold() && $desired->isBold()) {
            
            // turn bold on the changes
            $ret->setBold(true);

        // bold is going from on to off, the only way to do that is through an overall clear
        } else if ($this->isBold() && !$desired->isBold()) {

            // a clear is needed, so no new changed object is needed, all of desired will be used
            return null;

        }

        // underscore is currently off, and the desired is to turn it on
        if (!$this->isUnderscore() && $desired->isUnderscore()) {

            // turn bold on the changes
            $ret->setUnderscore(true);

        // the underscore is going from on to off
        }  else if ($this->isUnderscore() && !$desired->isUnderscore()) {

            // a clear is needed
            return null;

        }
        
        // shortcuts to the current and desired text color
        $currentTextColor = $this->getTextColor();
        $desiredTextColor = $desired->getTextColor();
        
        // if there is no text color and one is desired
        if (!$currentTextColor->isValid() && $desiredTextColor->isValid()) {
            
            // set the text color
            $ret->setTextColor($desiredTextColor);
            
        // The text color is getting turned off
        } else if ($currentTextColor->isValid() && !$desiredTextColor->isValid()) {

            // a clear is needed
            return null;

        // both are valid colors
        } else if ($currentTextColor->isValid() && $desiredTextColor->isValid()) {
            
            // if the two colors are different
            if ($currentTextColor != $desiredTextColor) {
                
                // set the text color
                $ret->setTextColor($desiredTextColor);
                
            }
        }

        // shortcuts to the current and desired fill colors
        $currentFillColor = $this->getFillColor();
        $desiredFillColor = $desired->getFillColor();

        // if there is no text color and one is desired
        if (!$currentFillColor->isValid() && $desiredFillColor->isValid()) {

            // set the text color
            $ret->setFillColor($desiredFillColor);

            // both are valid    
        } else if ($currentFillColor->isValid() && !$desiredFillColor->isValid()) {

            // a clear is needed
            return null;

        } else if ($currentFillColor->isValid() && $desiredFillColor->isValid()) {

            // if the two colors are different
            if ($currentFillColor != $desiredFillColor) {

                // set the text color
                $ret->setFillColor($desiredFillColor);

            }
        }

        // we got here, so no clear was needed, return the object with the changed properties
        return $ret;
        
    }


}