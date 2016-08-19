<?php

require __DIR__ . "/../vendor/autoload.php";

use ANSI\BasicTerminal;
use ANSI\Color\Color;
use ANSI\Color\Colors;
use ANSI\Color\Mode;


/**
 * This demo Clio Open Source project, Clio.1happyplace.com
 * Copyright, Katie Ayres, katie@1happyplace.com
 *
 * Available through the MIT license
 * @license MIT
 *
 * Outputs the $TERM value, height, width and max colors
 *
 */

$term = new BasicTerminal(Mode::RGB);

// set up two columns
$col1 = 12;
$col2 = 18;

// display the title
$term->newLine();
$term->setColors("white","royalblue")->setBold();
$term->display(str_pad("Terminal Attributes",$col1+$col2))->clear();

// catch any exceptions (such as invalid $TERM or exec is turned off in php.ini)
try {

    // Value of $TERM
    $term->setFillColor("gray228")->display(str_pad("\$TERM",$col1));
    $term->display(str_pad(BasicTerminal::getTerminalType(),$col2))->clear()->newLine();

    // Height
    $term->setFillColor("white")->display(str_pad("Height",$col1));
    $term->display(str_pad(BasicTerminal::getScreenHeight(),$col2))->newLine();

    // Width
    $term->setFillColor("gray228")->display(str_pad("Width",$col1));
    $term->display(str_pad(BasicTerminal::getScreenWidth(),$col2))->clear()->newLine();

    // Number of colors
    $term->setFillColor("white")->display(str_pad("Colors",$col1));
    $term->display(str_pad(BasicTerminal::getScreenMaxColors(),$col2))->newLine(2);

// if anything goes wrong
} catch (\Exception $e) {

    // output the message
    $term->display($e->getMessage())->newLine();

}


$term->setColors("Light sea green","black");

$term->display("Off to the sea to watch ");
$term->setBold(true);
$term->display("dolphins")->clear(true)->newLine(3);

// go through the modes
$modes = [Mode::VT100, Mode::XTERM, Mode::RGB];

// build some empty space
$emptySpace = str_pad("",20);

// initialize royal blue
$blue = Color::royalblue();

// go through each mode
foreach ($modes AS $mode) {

    // create the terminal with the mode
    $term = new BasicTerminal($mode);

    // set the fill color to the royal blue
    $term->setFillColor($blue);

    // display the color name
    $term->display($blue->getHumanName() . $emptySpace);

    // clear out the styling and go to the next line
    $term->clear(true)->newLine();
}

