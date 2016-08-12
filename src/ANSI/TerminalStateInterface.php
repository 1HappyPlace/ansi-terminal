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
 * Class interface for the storage and retrieval of terminal styling,
 * namely bold, underscore, text and fill colors
 *
 */

interface TerminalStateInterface
{
    /**
     * @return boolean
     */
    public function isBold();

    /**
     * @param boolean $bold
     */
    public function setBold($bold);

    /**
     * @return boolean
     */
    public function isUnderscore();

    /**
     * @param boolean $underscore
     */
    public function setUnderscore($underscore);

    /**
     * @return Color
     */
    public function getTextColor();

    /**
     * @param ColorInterface | string | integer | array | null $textColor
     *     Color parameters can be:
     *          - Object adhering to the Color Interface
     *          - A color name "Antique White" or "antiquewhite"
     *          - Xterm integer from 0-255
     *          - [R,G,B]
     *          - null
     */
    public function setTextColor($textColor);

    /**
     * @return Color
     */
    public function getFillColor();

    /**
     * @param ColorInterface | string | integer | array | null $fillColor
     *     Color parameters can be:
     *          - Object adhering to the Color Interface
     *          - A color name "Antique White" or "antiquewhite"
     *          - Xterm integer from 0-255
     *          - [R,G,B]
     *          - null
     */
    public function setFillColor($fillColor);
    

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
    public function findChanges(TerminalStateInterface $desired);
    

}