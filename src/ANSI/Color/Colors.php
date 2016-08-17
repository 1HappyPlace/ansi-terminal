<?php


namespace ANSI\Color;


/**
 * This class is part of the Clio Open Source project, Clio.1happyplace.com
 * Copyright, Katie Ayres, katie@1happyplace.com
 * 
 * Available through the MIT license
 * @license MIT
 * 
 * This class lists all of the W3C CSS color names as an index, than for every one of those colors, there
 * are three values, the RGB value, the human-readable name, and an index in the 256 ANSI color array that
 * it most closely resembles.
 *
 * There are a few differences in this array of W3C color names from the list in the specification.  All
 * Gray and Grey indices were reduced to Gray, the getter methods will replace any found grey with gray.
 * The last set of gray colors are not part of the W3C specification, but they are a part of the 256 ANSI
 * colors.  It is a nice addition to also be able to specify a wide array of gray shades as well.
 *
 */

class Colors
{

    /**
     * Array of W3C defined color names (with some grays added)
     *
     * This array is indexed by the W3C color names, then each has a value of an array holding:
     *      - The Red, Green, Blue settings needed for that color
     *      - A human readable version of the color
     *      - The escape code for xterm 256 colors that it most closely matches
     *      - The escape code of the original ANSI 16 
     *              The last two numbers were achieved first by matching the 256 RGB numbers mathematically
     *              and changing a few based just looking at the colors on a true color monitor and making a better match
     *              when the mathematics failed (generally on a edge of a large color change in the spectrum)
     *              This is very murky business, with different emulators having different interpretations.
     *
     * @var array
     */

    private static $colors = [
        // the original ANSI colors, that don't make much sense in color theory, but did
        // for the hardware these codes controlled in the 70's
        "ansiblack"             =>  [[0,0,0],           "ANSI Black",               0,      30],
        "ansired"               =>  [[205,0,0],         "ANSI Red",                 1,      31],
        "ansigreen"             =>  [[0,205,0],         "ANSI Green",               2,      32],
        "ansiyellow"            =>  [[205,205,0],       "ANSI Yellow",              3,      33],
        "ansiblue"              =>  [[0,0,238],         "ANSI Blue",                4,      34],
        "ansimagenta"           =>  [[205,0,205],       "ANSI Magenta",             5,      35],
        "ansicyan"              =>  [[0,204,204],       "ANSI Cyan",                6,      36],
        "ansigray"              =>  [[229,229,299],     "ANSI Gray",                7,      37],
        "ansidarkgray"          =>  [[76,76,76],        "ANSI Dark Gray",           8,      90],
        "ansibrightred"         =>  [[255,0,0],         "ANSI Bright Red",          9,      91],
        "ansibrightgreen"       =>  [[0,255,0],         "ANSI Bright Green",        10,     92],
        "ansibrightyellow"      =>  [[255,255,0],       "ANSI Bright Yellow",       11,     93],
        "ansibrightblue"        =>  [[70,130,180],      "ANSI Bright Blue",         12,     94],
        "ansibrightmagenta"     =>  [[255,0,255],       "ANSI Bright Magenta",      13,     95],
        "ansibrightcyan"        =>  [[0,255,255],       "ANSI Bright Cyan",         14,     96],
        "ansiwhite"             =>  [[255,255,255],     "ANSI White",               15,     97],

        // W3C color names
        "aliceblue"             =>  [[240,248,255],     "Alice Blue",               15,     97],
        "antiquewhite"          =>  [[250,235,215],     "Antique White",            230,    97],
        "aqua"                  =>  [[0,255,255],       "Aqua",                     14,     96],
        "aquamarine"            =>  [[127,255,212],     "Aquamarine",               122,    96],
        "azure"                 =>  [[240,255,255],     "Azure",                    195,    97],
        "beige"	                =>  [[245,245,220],     "Beige",                    230,    97],
        "bisque"                =>	[[255,228,196],     "Bisque",                   223,    97],
        "black"                 =>	[[0,0,0],           "Black",                    0,      30],
        "blanchedalmond"        =>	[[255,235,205],     "Blanched Almond",          230,    97],
        "blue"                  =>  [[0,0,255],         "Blue",                     20,     34],
        "blueviolet"            =>	[[138,43,226],      "Blue Violet",              92,     35],
        "brown"                 =>	[[165,42,42],       "Brown",                    124,    31],
        "burlywood"	            =>  [[222,184,135],     "Burly Wood",               180,    33],
        "cadetblue"             =>	[[95,158,160],      "Cadet Blue",               73,     94],
        "chartreuse"            =>	[[127,255,0],       "Chartreuse",               118,    92],
        "chocolate"             =>	[[210,105,30],      "Chocolate",                166,    31],
        "coral"                 =>  [[255,127,80],      "Coral",                    209,    31],
        "cornflowerblue"        =>  [[100,149,237],     "Cornflower Blue",          68,     94],
        "cornsilk"              =>  [[255,248,220],     "Cornsilk",                 230,    97],
        "crimson"               =>  [[220,20,60],       "Crimson",                  160,    31],
        "cyan"                  =>	[[0,255,255],       "Cyan",                     14,     96],
        "darkblue"              =>	[[0,0,139],         "Dark Blue",                18,     34],
        "darkcyan"              =>	[[0,139,139],       "Dark Cyan",                30,     36],
        "darkgoldenrod"         =>	[[184,134,11],      "Dark Goldenrod",           136,    33],
        "darkgray"	            =>  [[169,169,169],     "Dark Gray",                248,    37],
        "darkgreen"             =>  [[0,100,0],         "Dark Green",               22,     32],
        "darkkhaki"             =>  [[189,183,107],     "Dark Khaki",               143,    33],
        "darkmagenta"           =>  [[139,0,139],       "Dark Magenta",             90,     35],
        "darkolivegreen"        =>  [[85,107,47],       "Dark Olive Green",         58,     32],
        "darkorange"            =>  [[255,140,0],       "Dark Orange",              208,    33],
        "darkorchid"            =>	[[153,50,204],      "Dark Orchid",              128,    35],
        "darkred"	            =>  [[139,0,0],         "Dark Red",                 124,    31],
        "darksalmon"            =>  [[233,150,122],     "Dark Salmon",              173,    31],
        "darkseagreen"          =>  [[143,188,143],     "Dark Sea Green",           108,    32],
        "darkslateblue"         =>	[[72,61,139],       "Dark Slate Blue",          18,     90],
        "darkslategray"	        =>  [[47,79,79],        "Dark Slate Gray",          239,    90],
        "darkturquoise"         =>	[[0,206,209],       "Dark Turquoise",           6,      36],
        "darkviolet"            =>	[[148,0,211],       "Dark Violet",              91,     35],
        "deeppink"              =>  [[255,20,147],      "Deep Pink",                198,    95],
        "deepskyblue"           =>  [[0,191,255],       "Deep Sky Blue",            45,     36],
        "dimgray"               =>  [[105,105,105],     "Dim Gray",                 242,    90],
        "dodgerblue"            =>	[[30,144,255],      "Dodger Blue",              33,     94],
        "firebrick"             =>	[[178,34,34],       "Fire Brick",               124,    31],
        "floralwhite"           =>  [[255,250,240],     "Floral White",             15,     97],
        "forestgreen"           =>  [[34,139,34],       "Forest Green",             28,     32],
        "fuchsia"               =>  [[255,0,255],       "Fuchsia",                  13,     95],
        "gainsboro"             =>  [[220,220,220],     "Gainsboro",                253,    37],
        "ghostwhite"            =>	[[248,248,255],     "Ghost White",              15,     97],
        "gold"                  =>  [[255,215,0],       "Gold",                     220,    33],
        "goldenrod"             =>	[[218,165,32],      "Goldenrod",                179,    33],
        "gray"                  =>	[[128,128,128],     "Gray",                     244,    90],
        "green"                 =>  [[0,128,0],         "Green",                    28,     92],
        "greenyellow"           =>  [[173,255,47],      "Green Yellow",             154,    92],
        "honeydew"              =>  [[240,255,240],     "Honeydew",                 15,     97],
        "hotpink"               =>  [[255,105,180],     "Hot Pink",                 205,    95],
        "indianred"             => 	[[205,92,92],       "Indian Red",               167,    31],
        "indigo"                =>	[[75,0,130],        "Indigo",                   54,     34],
        "ivory"                 =>	[[255,255,240],     "Ivory",                    15,     97],
        "khaki"                 =>	[[240,230,140],     "Khaki",                    229,    97],
        "lavender"              =>  [[230,230,250],     "Lavender",                 189,    37],
        "lavenderblush"         =>	[[255,240,245],     "Lavender Blush",           225,    97],
        "lawngreen"             =>  [[124,252,0],       "Lawn Green",               118,    92],
        "lemonchiffon"          =>  [[255,250,205],     "Lemon Chiffon",            230,    97],
        "lightblue"             =>  [[173,216,230],     "Light Blue",               152,    94],
        "lightcoral"            =>	[[240,128,128],     "Light Coral",              210,    91],
        "lightcyan"             =>	[[224,255,255],     "Light Cyan",               195,    97],
        "lightgoldenrodyellow"  =>  [[250,250,210],     "Light Goldenrod Yellow",   230,    97],
        "lightgray"             =>  [[211,211,211],     "Light Gray",               252,    37],
        "lightgreen"            =>	[[144,238,144],     "Light Green",              120,    92],
        "lightpink"             =>	[[255,182,193],     "Light Pink",               218,    91],
        "lightsalmon"           =>  [[255,160,122],     "Light Salmon",             216,    31],
        "lightseagreen"         =>  [[32,178,170],      "Light Sea Green",          37,     36],
        "lightskyblue"          =>  [[135,206,250],     "Light Sky Blue",           117,    96],
        "lightslategray"        =>	[[119,136,153],     "Light Slate Gray",         102,    90],
        "lightsteelblue"        =>	[[176,196,222],     "Light Steel Blue",         110,    37],
        "lightyellow"           =>  [[255,255,224],     "Light Yellow",             230,    97],
        "lime"                  =>  [[0,255,0],         "Lime",                     10,     92],
        "limegreen"             =>  [[50,205,50],       "Lime Green",               2,      32],
        "linen"                 =>  [[250,240,230],     "Linen",                    255,    97],
        "magenta"               =>  [[255,0,255],       "Magenta",                  13,     95],
        "maroon"                =>	[[128,0,0],         "Maroon",                   88,     31],
        "mediumaquamarine"      =>  [[102,205,170],     "Medium Aquamarine",        79,     36],
        "mediumblue"            =>	[[0,0,205],         "Medium Blue",              20,     34],
        "mediumorchid"          =>  [[186,85,211],      "Medium Orchid",            134,    35],
        "mediumpurple"          =>  [[147,112,219],     "Medium Purple",            135,    35],
        "mediumseagreen"        =>	[[60,179,113],      "Medium Sea Green",         71,     32],
        "mediumslateblue"       =>  [[123,104,238],     "Medium Slate Blue",        99,     94],
        "mediumspringgreen"     =>	[[0,250,154],       "Medium Spring Green",      48,     92],
        "mediumturquoise"       =>	[[72,209,204],      "Medium Turquoise",         80,     36],
        "mediumvioletred"       => 	[[199,21,133],      "Medium Violet Red",        162,    35],
        "midnightblue"          =>  [[25,25,112],       "Midnight Blue",            17,     34],
        "mintcream"             =>	[[245,255,250],     "Mint Cream",               15,     97],
        "mistyrose"             =>	[[255,228,225],     "Misty Rose",               224,    97],
        "moccasin"              =>	[[255,228,181],     "Moccasin",                 223,    97],
        "navajowhite"           =>  [[255,222,173],     "Navajo White",             223,    97],
        "navy"                  =>  [[0,0,128],         "Navy",                     18,     34],
        "oldlace"               =>  [[253,245,230],     "Old Lace",                 230,    97],
        "olive"                 =>	[[128,128,0],       "Olive",                    100,    33],
        "olivedrab"             =>  [[107,142,35],      "Olive Drab",               64,     32],
        "orange"                =>	[[255,165,0],       "Orange",                   214,    93],
        "orangered"             =>  [[255,69,0],        "Orange Red",               202,    91],
        "orchid"                =>	[[218,112,214],     "Orchid",                   170,    95],
        "palegoldenrod"         =>  [[238,232,170],     "Pale Goldenrod",           223,    97],
        "palegreen"             =>  [[152,251,152],     "Pale Green",               120,    92],
        "paleturquoise"         =>  [[175,238,238],     "Pale Turquoise",           159,    96],
        "palevioletred"         =>  [[219,112,147],     "Pale Violet Red",          168,    95],
        "papayawhip"            =>	[[255,239,213],     "Papaya Whip",              230,    97],
        "peachpuff"             =>	[[255,218,185],     "Peach Puff",               223,    97],
        "peru"                  =>  [[205,133,63],      "Peru",                     172,    33],
        "pink"                  =>  [[255,192,203],     "Pink",                     218,    95],
        "plum"                  =>  [[221,160,221],     "Plum",                     182,    95],
        "powderblue"            =>	[[176,224,230],     "Powder Blue",              159,    96],
        "purple"                =>	[[128,0,128],       "Purple",                   90,     35],
        "red"                   =>  [[255,0,0],         "Red",                      9,      91],
        "rosybrown"             =>  [[188,143,143],     "Rosy Brown",               138,    31],
        "royalblue"             =>  [[65,105,225],      "Royal Blue",               33,     94],
        "saddlebrown"           =>  [[139,69,19],       "Saddle Brown",             137,    90],
        "salmon"                =>	[[250,128,114],     "Salmon",                   210,    91],
        "sandybrown"            =>	[[244,164,96],      "Sandy Brown",              215,    33],
        "seagreen"              =>  [[46,139,87],       "Sea Green",                29,     32],
        "seashell"              =>  [[255,245,238],     "Seashell",                 255,    97],
        "sienna"                =>	[[160,82,45],       "Sienna",                   130,    31],
        "silver"                =>	[[192,192,192],     "Silver",                   251,    37],
        "skyblue"               =>  [[135,206,235],     "Sky Blue",                 117,    36],
        "slateblue"             =>  [[106,90,205],      "Slate Blue",               61,     94],
        "slategray"             =>  [[112,128,144],     "Slate Gray",               244,    37],
        "snow"                  =>  [[255,250,250],     "Snow",                     15,     97],
        "springgreen"           =>  [[0,255,127],       "Spring Green",             48,     92],
        "steelblue"             =>  [[70,130,180],      "Steel Blue",               12,     94],
        "tan"                   =>  [[210,180,140],     "Tan",                      180,    33],
        "teal"                  =>  [[0,128,128],       "Teal",                     30,     94],
        "thistle"               =>  [[216,191,216],     "Thistle",                  182,    95],
        "tomato"                =>	[[255,99,71],       "Tomato",                   203,    91],
        "turquoise"             =>  [[64,224,208],      "Turquoise",                86,     36],
        "violet"                =>  [[238,130,238],     "Violet",                   213,    95],
        "wheat"                 =>  [[245,222,179],     "Wheat",                    223,    97],
        "white"                 =>  [[255,255,255],     "White",                    15,     97],
        "whitesmoke"            =>	[[245,245,245],     "White Smoke",              255,    97],
        "yellow"                =>	[[255,255,0],       "Yellow",                   226,    93],
        "yellowgreen"           =>  [[154,205,50],      "Yellow Green",             112,    33],

        // the grays of the XTerm color scheme
        "gray8"                 =>  [[8,8,8],           "Gray 8",                   232,    30],
        "gray18"                =>  [[18,18,18],        "Gray 18",                  233,    30],
        "gray28"                =>  [[28,28,28],        "Gray 28",                  234,    30],
        "gray38"                =>  [[38,38,38],        "Gray 38",                  235,    30],
        "gray48"                =>  [[48,48,48],        "Gray 48",                  236,    30],
        "gray58"                =>  [[58,58,58],        "Gray 58",                  237,    30],
        "gray68"                =>  [[68,68,68],        "Gray 68",                  238,    90],
        "gray78"                =>  [[78,78,78],        "Gray 78",                  239,    90],
        "gray88"                =>  [[88,88,88],        "Gray 88",                  240,    90],
        "gray98"                =>  [[98,98,98],        "Gray 98",                  241,    90],
        "gray108"               =>  [[108,108,108],     "Gray 108",                 242,    90],
        "gray118"               =>  [[118,118,118],     "Gray 118",                 243,    90],
        "gray128"               =>  [[128,128,128],     "Gray 128",                 244,    90],
        "gray138"               =>  [[138,138,138],     "Gray 138",                 245,    90],
        "gray148"               =>  [[148,148,148],     "Gray 148",                 246,    90],
        "gray158"               =>  [[158,158,158],     "Gray 158",                 247,    90],
        "gray168"               =>  [[168,168,168],     "Gray 168",                 248,    90],
        "gray178"               =>  [[178,178,178],     "Gray 178",                 249,    90],
        "gray188"               =>  [[188,188,188],     "Gray 188",                 250,    37],
        "gray198"               =>  [[198,198,198],     "Gray 198",                 251,    37],
        "gray208"               =>  [[208,208,208],     "Gray 208",                 252,    37],
        "gray218"               =>  [[218,218,218],     "Gray 218",                 253,    37],
        "gray228"               =>  [[228,228,228],     "Gray 228",                 254,    97],
        "gray238"               =>  [[238,238,238],     "Gray 238",                 255,    97]
    ];

    /**
     * Array of the xterm 256 colors, with the 0-255 index and the corresponding RGB color
     *
     * @var array[]
     */
    private static $XTermColors = [

        // original VT100 16 colors
        [0,0,0],    [205,0,0], [0,205,0], [205,205,0], [0,0,238],    [205,0,205], [0,204,204], [229,229,299],
        [76,76,76], [255,0,0], [0,255,0], [255,255,0],   [70,130,180], [255,0,255], [0,255,255], [255,255,255],

        // the mathematical pattern that divides up the RGB spectrum for a large portion of the 256 numbers
        [0,0,0],   [0,0,95],   [0,0,135],   [0,0,175],   [0,0,215],   [0,0,255],
        [0,95,0],  [0,95,95],  [0,95,135],  [0,95,175],  [0,95,215],  [0,95,255],
        [0,135,0], [0,135,95], [0,135,135], [0,135,175], [0,135,215], [0,135,255],
        [0,175,0], [0,175,95], [0,175,135], [0,175,175], [0,175,215], [0,175,255],
        [0,215,0], [0,215,95], [0,215,135], [0,215,175], [0,215,215], [0,215,255],
        [0,255,0], [0,255,95], [0,255,135], [0,255,175], [0,255,215], [0,255,255],

        [95,0,0],   [95,0,95],   [95,0,135],   [95,0,175],   [95,0,215],   [95,0,255],
        [95,95,0],  [95,95,95],  [95,95,135],  [95,95,175],  [95,95,215],  [95,95,255],
        [95,135,0], [95,135,95], [95,135,135], [95,135,175], [95,135,215], [95,135,255],
        [95,175,0], [95,175,95], [95,175,135], [95,175,175], [95,175,215], [95,175,255],
        [95,215,0], [95,215,95], [95,215,135], [95,215,175], [95,215,215], [95,215,255],
        [95,255,0], [95,255,95], [95,255,135], [95,255,175], [95,255,215], [95,255,255],

        [135,0,0],   [135,0,95],   [135,0,135],   [135,0,175],   [135,0,215],   [135,0,255],
        [135,95,0],  [135,95,95],  [135,95,135],  [135,95,175],  [135,95,215],  [135,95,255],
        [135,135,0], [135,135,95], [135,135,135], [135,135,175], [135,135,215], [135,135,255],
        [135,175,0], [135,175,95], [135,175,135], [135,175,175], [135,175,215], [135,175,255],
        [135,215,0], [135,215,95], [135,215,135], [135,215,175], [135,215,215], [135,215,255],
        [135,255,0], [135,255,95], [135,255,135], [135,255,175], [135,255,215], [135,255,255],

        [175,0,0],   [175,0,95],   [175,0,135],   [175,0,175],   [175,0,215],   [175,0,255],
        [175,95,0],  [175,95,95],  [175,95,135],  [175,95,175],  [175,95,215],  [175,95,255],
        [175,135,0], [175,135,95], [175,135,135], [175,135,175], [175,135,215], [175,135,255],
        [175,175,0], [175,175,95], [175,175,135], [175,175,175], [175,175,215], [175,175,255],
        [175,215,0], [175,215,95], [175,215,135], [175,215,175], [175,215,215], [175,215,255],
        [175,255,0], [175,255,95], [175,255,135], [175,255,175], [175,255,215], [175,255,255],

        [215,0,0],   [215,0,95],   [215,0,135],   [215,0,175],   [215,0,215],   [215,0,255],
        [215,95,0],  [215,95,95],  [215,95,135],  [215,95,175],  [215,95,215],  [215,95,255],
        [215,135,0], [215,135,95], [215,135,135], [215,135,175], [215,135,215], [215,135,255],
        [215,175,0], [215,175,95], [215,175,135], [215,175,175], [215,175,215], [215,175,255],
        [215,215,0], [215,215,95], [215,215,135], [215,215,175], [215,215,215], [215,215,255],
        [215,255,0], [215,255,95], [215,255,135], [215,255,175], [215,255,215], [215,255,255],

        [255,0,0],   [255,0,95],   [255,0,135],   [255,0,175],   [255,0,215],   [255,0,255],
        [255,95,0],  [255,95,95],  [255,95,135],  [255,95,175],  [255,95,215],  [255,95,255],
        [255,135,0], [255,135,95], [255,135,135], [255,135,175], [255,135,215], [255,135,255],
        [255,175,0], [255,175,95], [255,175,135], [255,175,175], [255,175,215], [255,175,255],
        [255,215,0], [255,215,95], [255,215,135], [255,215,175], [255,215,215], [255,215,255],
        [255,255,0], [255,255,95], [255,255,135], [255,255,175], [255,255,215], [255,255,255],

        // gray spectrum
        [8,8,8],       [18,18,18],    [28,28,28],    [38,38,38],    [48,48,48],    [58,58,58],
        [68,68,68],    [78,78,78],    [88,88,88],    [98,98,98],    [108,108,108], [118,118,118],
        [128,128,128], [138,138,138], [148,148,148], [158,158,158], [168,168,168], [178,178,178],
        [188,188,188], [198,198,198], [208,208,208], [218,218,218], [228,228,228], [238,238,238]

    ];


    /**
     * The 256 colors that need an opposing white for contrast
     *
     * @var integer[]
     */
    public static $needsWhite256 = [0,1,4,5,8,9,12,13,16,17,18,19,20,21,22,23,24,25,26,27,28,52,53,
        54,55,56,57,58,59,60,61,62,63,64,88,89,90,91,92,93,94,95,96,97,98,99,124,125,126,127,128,129,
        130,131,132,133,134,135,160,161,162,163,164,165,166,167,168,196,197,198,199,200,201,202,232,
        233,234,235,236,237,238,239,240,241,242,243,244,245];


    /**
     * Helper function to get the array value for a particular index
     *
     * @param string $name
     * @return null | array
     */
    private static function getArray($name) {

        // strip out any blanks, make lower case and watch for grey/gray
        $name = self::stripName($name);

        // if the key exists...
        if (array_key_exists($name,self::$colors)) {

            // return the array value
            return self::$colors[$name];

            // it was not in the index
        } else {

            // return null to indicate something is wrong
            return null;

        }
    }

    /**
     * Calculates the difference between two RGBs
     *
     * Calculates the distance between each number and adding those up, this is far
     * from precise, it tends to fail when colors are at a hue edge, but
     * for now, it'll have to do, maybe someone can come up with something better!
     *
     * @param integer[] $RGB1
     * @param integer[] $RGB2
     * @return integer
     */
    private static function distance ($RGB1, $RGB2) {

        // take the absolute value of the difference between the Red number
        $distance = abs($RGB1[0]-$RGB2[0]);

        // blue
        $distance += abs($RGB1[1]-$RGB2[1]);

        // green
        $distance += abs($RGB1[2]-$RGB2[2]);

        // return the total of all three
        return $distance;
    }


    /**
     * Helper function to reduce names to a key e.g. "Red" -> "red", "Light Blue" -> "lightblue", "DARK blue" -> "darkblue"
     *
     * @param string $name
     * @return string
     */
    public static function stripName($name) {

        // trim off any leading and trailing blanks
        $name = trim($name);

        // replace any extra empty space between the two words
        $name = preg_replace('/\s+/','',$name);

        // make the color uppercase to match the keys
        $name =  strtolower($name);

        // now replace grey with gray, if found
        $name = str_replace("grey","gray",$name);

        // returned the stripped down index name
        return $name;
    }

    /**
     * Whether a string is a valid color name
     *
     * @param string $name
     * @return bool
     */
    public static function isValidColorName($name) {

        // make sure it is a string
        if (is_string($name)) {

            // strip the name
            $name = self::stripName($name);

            // get all the valid names
            $names = self::getColorIndex();

            // return whether it is in that array of names
            return in_array($name, $names);
            
        } else {

            // not a string
            return false;
        }
        

    }

    /**
     * Get the full index of all colors
     *
     * @return string[]
     */
    public static function getColorIndex() {

        // get all the keys
        return array_keys(self::$colors);
    }

    /**
     * Get just the index for the ANSI colors
     *
     * @return string[]
     */
    public static function getANSIIndex() {
        
        // get all the keys
        $keys = array_keys(self::$colors);

        // just return the first 16
        return array_slice($keys,0,16);
    
    }

    /**
     * Get the index for just the W3C colors
     *
     * @return string[]
     */
    public static function getW3CIndex() {
        
        // get all the colors
        $keys = array_keys(self::$colors);

        // remove the ANSI colors
        $keys = array_slice($keys,16);
        
        // remove the grays
        return array_slice($keys, 0, count($keys) - 24);
    
    }

    /**
     * Get the index to the final sequence of grays
     *
     * @return string[]
     */
    public static function getGraysIndex() {
        
        // get all the keys
        $keys = array_keys(self::$colors);

        // return only the grays
        return array_slice($keys, count($keys) - 24, 24);       
    }
    



    /**
     * Get the human readable name for a particular color (and in pleasant case)
     *
     * @param string $name - this can either be the exact index "palegoldenrod", or the more human readable "Pale Goldenrod" (case independent)
     * @return string - the name or "Unknown" if it is not found
     */
    public static function getHumanName($name) {

        // check that the name is a valid index
        if ($arr = self::getArray($name)) {

            // return the name in the array of values
            return $arr[1];

        // not a valid index
        } else {

            // return unknown
            return "Unknown";

        }
    }


    /**
     * Get the ANSI code for the specified color
     *
     * @param string $name - this can either be the exact index "palegoldenrod", or the more human readable "Pale Goldenrod" (case independent)
     * @return integer | null - the index or null if something went wrong
     */
    public static function getANSICode($name) {

        // check that the name is a valid index
        if ($arr = self::getArray($name)) {

            // get the ANSI escape code that is closest to the RGB
            return $arr[3];

            // not a valid index
        } else {

            // return null as an error
            return null;

        }
    }

    /**
     * Get the 256 color index for a particular color
     *
     * @param string $name - this can either be the exact index "palegoldenrod", or the more human readable "Pale Goldenrod" (case independent)
     * @return integer | null - the index or null if something went wrong
     */
    public static function getXTermCode($name) {

        // check that the name is a valid index
        if ($arr = self::getArray($name)) {

            // get the index in the array of 256 extended ANSI colors that is closest to the RGB
            return $arr[2];

        // not a valid index
        } else {

            // return null as an error
            return null;

        }
    }

    /**
     * Get the RGB array for a particular color name
     *
     * @param string $name - this can either be the exact index "palegoldenrod", or the more human readable "Pale Goldenrod" (case independent)
     * @return integer[] | null - array of three numbers indicating [R,G,B] or null if not found
     */
    public static function getRGB($name) {

        // check that the name is a valid index
        if ($arr = self::getArray($name)) {

            // return the RGB in the array of values
            return $arr[0];

            // not a valid index
        } else {

            // return null as an error
            return null;

        }
    }


    /**
     * Determines whether a particular color needs a white contrast
     *
     * @param integer $xtermCode - number between 0 - 255 for the XTerm 256 colors
     * @return boolean - whether the color needs white
     */
    public static function needsWhiteContrast($xtermCode) {

        // check that the name is a valid index
        if (($xtermCode >= 0) && ($xtermCode <= 255)) {
            
            // return whether the code is then listed in the array of codes that need white
            return in_array($xtermCode, self::$needsWhite256);

            // not a valid index
        } else {

            // return null as an error
            return null;

        }
    }


    /**
     * For any given RGB, find the closest match in the color array
     * 
     * @param integer[] $RGB - array of three numbers [R,G,B]
     * @return string | null - the index to the color array ("darkblue"), or null if something went wrong 
     */
    public static function matchRGB($RGB) {
        
        // get the index of W3C colors
        $colors = self::getW3CIndex();
        
        // initialize the smallest distance to the greatest number
        $smallestDistance = 256*3;
        
        // keep track of the index that had the smallest distance
        $smallestIndex = null;

        // go through the colors
        foreach ($colors AS $color) {

            // get the next RGB
            $next = self::getRGB($color);
            
            // calculate the distance between the two RGB numbers
            $distance = self::distance($next, $RGB);

            // if this is smaller than the last stored distance
            if ($distance < $smallestDistance) {

                // store it
                $smallestDistance = $distance;

                // if it is an exact match
                if ($smallestDistance === 0) {
                    
                    // return the color index
                    return $color;
                }
                
                // keep track of this current closet match
                $smallestIndex = $color;
            }
        }

        // return match
        return $smallestIndex;

    }


    
    /**
     * Get the color name index for a particular xterm code
     * 
     * @param integer $index
     * @return string | null - color name in the index or null if not found
     */
    public static function getColorIndexForXTermCode($index) {

        // ensure the index is in between 0 and 255
        if (($index >= 0) && ($index <= 255))
        {
            
            // first go through all the colors and see if there is an exact match already
            // get the index of W3C colors
            $colors = self::getColorIndex();
            
            // go through each color
            foreach ($colors AS $color) {
                
                // get the xterm code
                $next = self::getXTermCode($color);
                
                // if you have a match
                if ($next === $index) {
                    
                    // return the color name
                    return $color;
                }
            }
            
            // there was not an exact match, try the RGB
            
            // get the RGB for that particular xterm color
            $RGB = self::$XTermColors[$index];
            
            // now return the closest match
            return self::matchRGB($RGB);

        // invalid index
        } else {

            // return null to indicate an error
            return null;

        }

    }

    /**
     * Get the RGB for a particular xterm code.  This is based on what
     * the xterm codes are supposed to represent, it may actually be
     * different for each terminal emulator.  IT was correct for
     * PHPStorm's terminal emulator.
     *
     * @param integer $index
     * @return int[] | null - either the [R,G,B] or null if the index is not
     * between 0 and 255
     */
    public static function getRGBForXTermCode($index) {

        // ensure the index is in between 0 and 255
        if (($index >= 0) && ($index <= 255))
        {

            // get the RGB for that particular xterm color
            return self::$XTermColors[$index];

            
        // invalid index
        } else {

            // return null to indicate an error
            return null;

        }

    }

    /**
     * Get the RGB for a particular VT-100 code.  This is based on
     * documentation of what those early colors were supposed
     * to be, but it is up to each terminal emulator to determine.
     * The colors reported here were measured on PHPStorm's terminal
     * emulator.
     *
     * @param integer $index
     * @return int[] | null - either the [R,G,B] or null
     */
    public static function getRGBForVT100Code($index) {
        
        // check for the lower 8 codes
        if (($index >= 30) && ($index <= 37)) {
            
            // subtract out the 30 to get the 0...7
            return self::$XTermColors[$index - 30];

        // check for the upper 8 codes    
        } else if (($index >= 90) && ($index <= 97)) {

            // subtract out 82 to get 8..15
            return self::$XTermColors[$index - 82];
            
        // invalid index
        } else {

            // return null to indicate an error
            return null;

        }

    }
}