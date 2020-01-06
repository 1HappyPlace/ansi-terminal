<?php


use ANSI\BasicTerminal;
use PHPUnit\Framework\TestCase;



class BasicTerminalTest extends TestCase
{

    public $CSI = null;
    public $CSE = null;
    public $clear = null;

    public function setUp(): void
    {

        $this->CSI = "\\e[";
        $this->CSE = "m";
        $this->clear = "\\e[0m";


    }

    public function tearDown(): void
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





}