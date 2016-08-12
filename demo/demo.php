<?php

require __DIR__ . "/../vendor/autoload.php";

use ANSI\BasicTerminal;
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

// catch any exceptions (such as invalid $TERM or exec is turned off in php.ini)
try {

    // output all the terminal settings
    echo "\n";
    echo "\$TERM  = " . BasicTerminal::getTerminalType() . "\n";
    echo "Height = " . BasicTerminal::getScreenHeight() . "\n"; 
    echo "Width  = " . BasicTerminal::getScreenWidth() . "\n";
    echo "Colors = " . BasicTerminal::getScreenMaxColors() . "\n\n";

// if anything goes wrong
} catch (\Exception $e) {

    // output the message
    echo $e->getMessage() . "\n";
}

$term = new BasicTerminal(Mode::XTERM);
$term->setFillColor("black")->setTextColor("Light Sea Green")->display("Off to the sea")->newLine(); 
$term->display("to watch ")->setBold(true)->display("dolphins")->newLine()->clear(true);
