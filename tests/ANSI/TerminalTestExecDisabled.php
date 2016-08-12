<?php


use PHPUnitColors\Display;
use ANSI\Terminal;

class TerminalTestExecDisabled extends PHPUnit_Framework_TestCase
{

//*** NOTE TO FULLY RUN THIS, the php.ini should be changed to
// disable_functions=exec to test the exception handler ***/

    public function setUp()
    {
        // get the functions that are disabled in the php.ini
        $originalSetting = ini_get("disable_functions");

        // check if exec is in there
        $pos = stripos($originalSetting,"exec");

        // if it has been found
        if ($pos === false) {

            // warn that it must be turned on for this test case
            echo Display::warning("Exec is turned on, for this test case, it must be disallowed.");

            exit;

        }


    }

    public function tearDown()
    {

    }




    /**
     * static function getScreenHeight()
     *
     * Get the current screen height
     * @return int - the number of lines it holds
     */
    public function test_getScreenHeight() {
        
        putenv("TERM=xterm");

        // just test for the exception
        $this->expectException(RuntimeException::class);
        Terminal::getScreenHeight();

    }

    /**
     * static function getScreenWidth()
     *
     * Get the current screen width
     * @return int - the number of characters that will fit across the screen
     */
    public function test_getScreenWidth() {
        
        putenv("TERM=xterm");

        // just test for the exception
        $this->expectException(RuntimeException::class);
        Terminal::getScreenWidth();
        

    }

    /**
     * static function getScreenMaxColors()
     *
     * Get the current maximum colors
     * @return int - the maximum colors, so far, 8, 16 and 256 should be expected
     */
    public function test_getScreenMaxColors() {

        putenv("TERM=xterm");

        // just test for the exception
        $this->expectException(RuntimeException::class);
        Terminal::getScreenMaxColors();


    }
}


