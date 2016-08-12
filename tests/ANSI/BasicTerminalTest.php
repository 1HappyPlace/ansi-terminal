<?php


use ANSI\BasicTerminal;
use PHPUnit\Framework\TestCase;



class BasicTerminalTest extends TestCase
{

    public $CSI = null;
    public $CSE = null;
    public $clear = null;

    public function setUp()
    {

        $this->CSI = "\\e[";
        $this->CSE = "m";
        $this->clear = "\\e[0m";


    }

    public function tearDown()
    {

    }

    /**
     * public function output($text)
     *
     * All output goes to this function
     *
     * param string $text
     */
    public function test_output()
    {
        $term = new BasicTerminal("vt100");

        $term->setBold()->setUnderscore()->setTextColor("ansiCyan")->setFillColor("black")->display("Hello World!")->clear(true);

        $this->expectOutputString("\e[1;4;36;40mHello World!\e[0m");
    }

    /**
     * public function carriageReturn()
     *
     * Anytime the cursor is returned to the leftmost column, this is fired
     */
    public function test_carriageReturn() {

        // it is so simple it doesn't care about this trigger
        $term = new BasicTerminal("rgb");
        $term->newLine();

    }



}