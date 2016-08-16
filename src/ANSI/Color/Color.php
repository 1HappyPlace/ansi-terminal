<?php


namespace ANSI\Color;

/**
 * This class is part of the Clio Open Source project, Clio.1happyplace.com
 * Copyright, Katie Ayres, katie@1happyplace.com
 *
 * Available through the MIT license
 * @license MIT
 *
 * The Color class represents one color and all the escape sequences that will generate it.
 *
 * @implements ColorInterface
 *
 * // Shortcut methods for all the W3C colors
 *
 *   @method static $this aliceblue()
 *   @method static $this antiquewhite()
 *   @method static $this aquamarine()
 *   @method static $this azure()
 *   @method static $this beige()
 *   @method static $this bisque()
 *   @method static $this black()
 *   @method static $this blanchedalmond()
 *   @method static $this blue()
 *   @method static $this blueviolet()
 *   @method static $this brown()
 *   @method static $this burlywood()
 *   @method static $this cadetblue()
 *   @method static $this chartreuse()
 *   @method static $this chocolate()
 *   @method static $this coral()
 *   @method static $this cornflowerblue()
 *   @method static $this cornsilk()
 *   @method static $this crimson()
 *   @method static $this cyan()
 *   @method static $this darkblue()
 *   @method static $this darkcyan()
 *   @method static $this darkgoldenrod()
 *   @method static $this darkgray()
 *   @method static $this darkgreen()
 *   @method static $this darkkhaki()
 *   @method static $this darkmagenta()
 *   @method static $this darkolivegreen()
 *   @method static $this darkorange()
 *   @method static $this darkorchid()
 *   @method static $this darkred()
 *   @method static $this darksalmon()
 *   @method static $this darkseagreen()
 *   @method static $this darkslateblue()
 *   @method static $this darkslategray()
 *   @method static $this darkturquoise()
 *   @method static $this darkviolet()
 *   @method static $this deeppink()
 *   @method static $this deepskyblue()
 *   @method static $this dimgray()
 *   @method static $this dodgerblue()
 *   @method static $this firebrick()
 *   @method static $this floralwhite()
 *   @method static $this forestgreen()
 *   @method static $this fuchsia()
 *   @method static $this gainsboro()
 *   @method static $this ghostwhite()
 *   @method static $this gold()
 *   @method static $this goldenrod()
 *   @method static $this gray()
 *   @method static $this green()
 *   @method static $this greenyellow()
 *   @method static $this honeydew()
 *   @method static $this hotpink()
 *   @method static $this indianred()
 *   @method static $this indigo()
 *   @method static $this ivory()
 *   @method static $this khaki()
 *   @method static $this lavender()
 *   @method static $this lavenderblush()
 *   @method static $this lawngreen()
 *   @method static $this lemonchiffon()
 *   @method static $this lightblue()
 *   @method static $this lightcoral()
 *   @method static $this lightcyan()
 *   @method static $this lightgoldenrodyellow()
 *   @method static $this lightgray()
 *   @method static $this lightgreen()
 *   @method static $this lightpink()
 *   @method static $this lightsalmon()
 *   @method static $this lightseagreen()
 *   @method static $this lightskyblue()
 *   @method static $this lightslategray()
 *   @method static $this lightsteelblue()
 *   @method static $this lightyellow()
 *   @method static $this lime()
 *   @method static $this limegreen()
 *   @method static $this linen()
 *   @method static $this magenta()
 *   @method static $this maroon()
 *   @method static $this mediumaquamarine()
 *   @method static $this mediumblue()
 *   @method static $this mediumorchid()
 *   @method static $this mediumpurple()
 *   @method static $this mediumseagreen()
 *   @method static $this mediumslateblue()
 *   @method static $this mediumspringgreen()
 *   @method static $this mediumturquoise()
 *   @method static $this mediumvioletred()
 *   @method static $this midnightblue()
 *   @method static $this mintcream()
 *   @method static $this mistyrose()
 *   @method static $this moccasin()
 *   @method static $this navajowhite()
 *   @method static $this navy()
 *   @method static $this oldlace()
 *   @method static $this olive()
 *   @method static $this olivedrab()
 *   @method static $this orange()
 *   @method static $this orangered()
 *   @method static $this orchid()
 *   @method static $this palegoldenrod()
 *   @method static $this palegreen()
 *   @method static $this paleturquoise()
 *   @method static $this palevioletred()
 *   @method static $this papayawhip()
 *   @method static $this peachpuff()
 *   @method static $this peru()
 *   @method static $this pink()
 *   @method static $this plum()
 *   @method static $this powderblue()
 *   @method static $this purple()
 *   @method static $this red()
 *   @method static $this rosybrown()
 *   @method static $this royalblue()
 *   @method static $this saddlebrown()
 *   @method static $this salmon()
 *   @method static $this sandybrown()
 *   @method static $this seagreen()
 *   @method static $this seashell()
 *   @method static $this sienna()
 *   @method static $this silver()
 *   @method static $this skyblue()
 *   @method static $this slateblue()
 *   @method static $this slategray()
 *   @method static $this snow()
 *   @method static $this springgreen()
 *   @method static $this steelblue()
 *   @method static $this tan()
 *   @method static $this teal()
 *   @method static $this thistle()
 *   @method static $this tomato()
 *   @method static $this turquoise()
 *   @method static $this violet()
 *   @method static $this wheat()
 *   @method static $this white()
 *   @method static $this whitesmoke()
 *   @method static $this yellow()
 *   @method static $this yellowgreen()
 *   @method static $this gray8()
 *   @method static $this gray18()
 *   @method static $this gray28()
 *   @method static $this gray38()
 *   @method static $this gray48()
 *   @method static $this gray58()
 *   @method static $this gray68()
 *   @method static $this gray78()
 *   @method static $this gray88()
 *   @method static $this gray98()
 *   @method static $this gray108()
 *   @method static $this gray118()
 *   @method static $this gray128()
 *   @method static $this gray138()
 *   @method static $this gray148()
 *   @method static $this gray158()
 *   @method static $this gray168()
 *   @method static $this gray178()
 *   @method static $this gray188()
 *   @method static $this gray198()
 *   @method static $this gray208()
 *   @method static $this gray218()
 *   @method static $this gray228()
 *   @method static $this gray238()
 */
class Color implements ColorInterface
{
    /**
     * The color name
     * @var string
     */
    protected $name = null;

    /**
     * The code to be used for old ANSI escape sequences
     * @var integer - range: 30-37, 90-97 for foregrounds (add 10 for backgrounds)
     */
    protected $ANSICode = null;

    /**
     * The code to be used for escape sequences
     * @var integer - range: 0-255
     */
    protected $XTermCode = null;

    /**
     * The RGB for the color in the format [R,G,B]
     * @var array|null
     */
    protected $RGB = null;

    /**
     * Color constructor.
     * 
     * @param ColorInterface | string | integer | int[] $color - Many options for initializing a color object
     *      - ColorInterface - another object implementing a ColorInterface
     *      - String - a W3C color index name "darkblue" or "Dark Blue"
     *      - integer - a number between 0-255 for the XTerm escape code
     *      - integer[] - RGB values in the format [R,G,B]
     *
     */
    public function __construct($color = null)
    {
        $this->setColor($color);

    }

    /**
     * Set the color object to empty
     */
    public function setEmpty() {

        // set all properties to null
        $this->name = $this->ANSICode = $this->XTermCode = $this->RGB = null;
    }

    /**
     * Return whether the object is empty
     * @return bool
     */
    public function isEmpty() {

        // return true if all properties are null
        return (is_null($this->name) && is_null($this->ANSICode) && is_null($this->XTermCode) && is_null($this->RGB));

    }

    /**
     * The variety of ways to set a color
     * @param ColorInterface | string | integer | int[] $color - Many options for initializing a color object - SEE CONSTRUCTOR
     */
    public function setColor($color) {

        // if null is passed in, then just leave everything null
        if (!is_null($color)) {

            // if it an instance of another color
            if ($color instanceof ColorInterface) {

                // save the name
                $this->name = $color->getName();

                // save the xterm code
                $this->XTermCode = $color->getXTermCode();

                // save the RGB
                $this->RGB = $color->getRGB();

                // save the ansi code
                $this->ANSICode = $color->getANSICode();

                // if it is string, then it is a color name (maybe)
            } else if (is_string($color)) {

                if (Colors::isValidColorName($color)) {

                    $this->name = Colors::stripName($color);

                    // get the code for that name
                    $this->XTermCode = Colors::getXTermCode($this->name);

                    // save the RGB
                    $this->RGB = Colors::getRGB($this->name);

                    // get the ANSI code
                    $this->ANSICode = Colors::getANSICode($this->name);

                }

                // if it is an integer, then it is likely a xterm code
            } else if (is_int($color)) {

                // if it is between 0 and 255
                if ($color >= 0 && $color <= 255) {

                    // save this code
                    $this->XTermCode = $color;

                    // get the RGB for it
                    $this->name = Colors::getColorIndexForXTermCode($this->XTermCode);

                    // get the RGB
                    $this->RGB = Colors::getRGB($this->name);

                    // get the ANSI Code
                    $this->ANSICode = Colors::getANSICode($this->name);
                }

                // if it is an RGB array
            } else if (is_array($color)) {

                // there must be three items in the array
                if (count($color) === 3) {

                    // save the RGB
                    $this->RGB = $color;

                    // match this RGB to some code
                    $this->name = Colors::matchRGB($this->RGB);

                    // get the nearest ANSI Code
                    $this->ANSICode = Colors::getANSICode($this->name);

                    // get the nearest XTerm code
                    $this->XTermCode = Colors::getXTermCode($this->name);

                }
            }

        // null was passed in
        } else {

            // set the color to be empty
            $this->setEmpty();
        }
    }

    /**
     * Whether a color is valid
     * 
     * @return boolean
     */
    public function isValid() {
    
        // it is valid if a name is set
        return !is_null($this->name);
    }
    

    /**
     * Get the name of the color 
     * 
     * If a name was sent in, it will be that name, if it is a XTerm code, it will be the code,
     * if it is an ANSI code, it will be ansi code, and finally if it is an RGB, it will be [R,G,B] in string form.
     * 
     * @return string | null - either the name or null if not valid
     */
    public function getName()
    {
        // return the name, if there is one
        return $this->name;
    }

    /**
     * Get the Human readable version of the name, "Antique White" versus "antiquewhite"
     * 
     * @return string
     */
    public function getHumanName() {
       
        // ask the Colors object for the human name, it will return "Unknown" if it is not a valid name
        return Colors::getHumanName($this->name);
    }

    /**
     * Get the ANSI code for a the particular color
     *
     * @return int | null - either an integer 30-37 or 90-97 or null if invalid color
     */
    public function getANSICode()
    {
        return $this->ANSICode;
    }
    
    /**
     * Get the xterm value for the particular color
     * 
     * @return int | null - either the xterm code which is between 0-255 or null if color is invalid
     */
    public function getXTermCode()
    {
        return $this->XTermCode;
    }
    

    /**
     * Get the RGB value
     *
     * @return integer[] | null - array of three integers, in the form of [R,G,B] or null if the color is not valid
     */
    public function getRGB()
    {
        // return the RGB value
        return $this->RGB;
    }

    /**
     * Return the best color to offset the currently stored color (black or white)
     * 
     * @return Color - either a Color object that is white or black (black if problem occurs)
     */
    public function getContrastColor()
    {
        // if there is a code...
        if (!is_null($this->XTermCode)) {

            // check to see if the code is in the array of colors that need white
            if (in_array($this->XTermCode,Colors::$needsWhite256)) {

                // return a new copy of the color object initialized to white
                return new self("white");

            // then it needs black
            } else {

                // return a new copy of the color object initialized to black
                return new self("black");
            }

        // the code is null
        } else {

            // return black as a default
            return new self("black");

        }
        
    }

    /**
     * __call - magic method to create shortcuts to all W3C colors, the function names are case independent
     * PLEASE NOTE: if the name does not match a W3C color, it will be ignored and switched to black
     * @param $name
     * @param $arguments - there are no arguments used
     *
     * @return Color
     */
    public static function __callStatic($name, $arguments)
    {
        // set the name to lower case
        $name = strtolower($name);

        // check that it is a valid color
        if (Colors::isValidColorName($name))
        {
            // set the color to the name
            return new self($name);
            
        }

        // chaining
        return new self("black");

    }

    /**
     * Generate a color coding based on the terminal type
     *
     * @param Mode | int | string $mode
     *      Mode
     *          send in a Mode object built already
     *      integer -
     *          send in the desired number of colors to pick the closest mode (<16 for VT100, >16 and <256 for xterm and > 256 for RGB)
     *      string -
     *          send in one of the constants Mode::VT100, Mode::XTERM, or Mode::RGB
     *          send in one of the actual string values for the constants (case insensitive) "vt100", "RGB", "xterm"
     * @param boolean $isFill - whether the color is a fill
     *
     * @return string
     */
    public function generateColorCoding($mode, $isFill = false) {

        // initialize the returned code
        $codes = "";

        // ensure the color has a value
        if ($this->isValid()) {
            
            // cast the mode into the class 
            $mode = new Mode($mode);

            // generally you add 10 to escape numbers to switch to fill
            $base = 0;

            // if is fill
            if ($isFill) {

                // use a base of 10
                $base = 10;
            }

            // go through the different terminal modes
            switch ($mode->getMode()) {

                // legacy mode, uses straight-up ansi codes
                case Mode::VT100:

                    // return the coding for old style color (and make it a string like the rest)
                    $codes = ($base + $this->getANSICode()) . "";
                    break;

                
                // Full RGB color, starts with 38;2 for text, or 48;2 for fill followed by R;G;B numbers
                case Mode::RGB:

                    // get the [R,G,B]
                    $RGB = $this->getRGB();

                    // return the full RGB coding
                    $codes  =($base + 38) . ";2;" . $RGB[0] . ";" . $RGB[1] . ";" . $RGB[2];
                    break;

                // Xterm codes, start with 38;5 for text and 48;5 for fill followed by a number from 0-255 for different colors
                case Mode::XTERM:

                    // return the coding for xterm colors
                    $codes = ($base + 38) . ";5;" . $this->getXTermCode();
                    break;

            }
        }

        // return the sequence
        return $codes;

    }

    /**
     * Return the next name on the main Colors name index
     * @return string | null - return null if this color is not valid, otherwise, return the next name or
     * the first name, if this is the last name
     */
    public function next() {


        // if this is a valid name
        if ($this->isValid()) {

            // find it on the index of colors
            $colorNames = Colors::getW3CIndex();

            // get the position of the name in the color index
            $pos = array_search($this->name,$colorNames);

            // if it was found on the array
            if ($pos !== false) {

                // if is the last item on the list
                if ($pos === (count($colorNames)-1)) {

                    // return the first item
                    return $colorNames[0];

                // it is not last
                } else {

                    // simply return the next item on the list
                    return $colorNames[$pos+1];
                }

            // name not found in list
            } else {
                // cannot happen (if name is not valid, it is nulled out), but here just in case
                // @codeCoverageIgnoreStart
                return null;
                // @codeCoverageIgnoreEnd
            }

        // invalid color
        } else {
            return null;
        }
        

        
    }

    /**
     * Return the previous name on the main Colors name index
     * @return string | null - return null if this color is not valid, otherwise, return the previous name
     * or the last name, if this is the first name
     */
    public function previous() {

        // if this is a valid name
        if ($this->isValid()) {

            // find it on the index of colors
            $colorNames = Colors::getW3CIndex();

            // get the position of the name in the color index
            $pos = array_search($this->name,$colorNames);

            // if it was found on the array
            if ($pos !== false) {

                // if is the first item on the list
                if ($pos === 0) {

                    // return the last item
                    return $colorNames[count($colorNames)-1];

                    // it is not first
                } else {

                    // simply return the previous item on the list
                    return $colorNames[$pos-1];
                }

            // name is not on the list
            } else {
                // cannot happen (constructor will null out invalid names), but here just in case
                // @codeCoverageIgnoreStart
                return null;
                // @codeCoverageIgnoreEnd
            }
        }
        // the color is not valid (name is null)
        else {
            // this color object is not valid
            return null;
        }



    }

}