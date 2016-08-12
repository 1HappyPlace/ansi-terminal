<?php

namespace ANSI;


class BasicTerminal extends Terminal
{

    /**
     *
     * All output goes to this function
     *
     * @param string $text
     */
    public function output($text)
    {
        // simply echo the text
        echo $text;
    }

    /**
     * Anytime the cursor is returned to the leftmost column, this is fired
     */
    public function carriageReturn()
    {
        // not interested 
    }
}