<?php

/**
 * This class is used to replace the escape with a printable escape
 * Class TerminalStub
 */
class TerminalStub extends \ANSI\Terminal
{

    /**
     *
     * All output goes to this function
     *
     * @param string $text
     */
    public function output($text)
    {
        echo str_replace("\e","\\e",$text);
    }

    /**
     * Anytime the cursor is returned to the leftmost column, this is fired
     */
    public function carriageReturn()
    {
        echo "CR";

    }
}