<?php


namespace ANSI\Color;

/**
 * This class is part of the Clio Open Source project, Clio.1happyplace.com
 * Copyright, Katie Ayres, katie@1happyplace.com
 *
 * Available through the MIT license
 * @license MIT
 *
 * The ColorInterface represents a color object that can generate any of the three styles of escape sequencing for terminal emulators.
 */
interface ColorInterface
{

    /**
     * Whether a color is valid
     *
     * @return boolean
     */
    public function isValid();


    /**
     * Get the name of the color
     *
     * If a name was sent in, it will be that name, if it is a XTerm code, it will be the code,
     * if it is an ANSI code, it will be ansi code, and finally if it is an RGB, it will be [R,G,B] in string form.
     *
     * @return string | null - either the name or null if not valid
     */
    public function getName();

    /**
     * Get the Human readable version of the name, "Antique White" versus "antiquewhite"
     *
     * @return string
     */
    public function getHumanName();

    /**
     * Get the ANSI code for a the particular color
     *
     * @return int | null - either an integer 30-37 or 90-97 or null if invalid color
     */
    public function getANSICode();

    /**
     * Get the xterm value for the particular color
     *
     * @return int | null - either the xterm code which is between 0-255 or null if color is invalid
     */
    public function getXTermCode();

    /**
     * Get the RGB value
     *
     * @return integer[] | null - array of three integers, in the form of [R,G,B] or null if the color is not valid
     */
    public function getRGB();

    /**
     * Return the best color to offset the currently stored color (black or white)
     *
     * @return Color - either a Color object that is white or black (black if problem occurs)
     */
    public function getContrastColor();

    /**
     * Generate a color coding based on the terminal type
     *
     * @param Mode $mode = the mode of the terminal, can just be set by $this->mode (allows it to be static for external use)
     * @param boolean $isFill - whether the color is a fill
     *
     * @return string
     */
    public function generateColorCoding($mode, $isFill = false);


}