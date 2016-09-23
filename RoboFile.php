<?php
////////////////////////////////////////////////////////////////////////////////
// __________ __             ________                   __________
// \______   \  |__ ______  /  _____/  ____ _____ ______\______   \ _______  ___
//  |     ___/  |  \\____ \/   \  ____/ __ \\__  \\_  __ \    |  _//  _ \  \/  /
//  |    |   |   Y  \  |_> >    \_\  \  ___/ / __ \|  | \/    |   (  <_> >    <
//  |____|   |___|  /   __/ \______  /\___  >____  /__|  |______  /\____/__/\_ \
//                \/|__|           \/     \/     \/             \/            \/
// -----------------------------------------------------------------------------
//          Designed and Developed by Brad Jones <brad @="bjc.id.au" />
// -----------------------------------------------------------------------------
////////////////////////////////////////////////////////////////////////////////

/*
 * Include our local composer autoloader just in case
 * we are called with a globally installed version of robo.
 */
require_once(__DIR__.'/vendor/autoload.php');

class RoboFile extends Robo\Tasks
{
    /**
     * Runs unit tests, with code coverage report.
     */
    public function test()
    {
        exit
        (
            $this->taskPHPUnit()
            ->arg('./tests')
            ->option('coverage-clover', './build/logs/clover.xml')
            ->run()->getExitCode()
        );
    }

    /**
     * Generates the projects documentation.
     *
     * This is made up of reflected information, DocBlocks
     * and other human written text.
     */
    public function docGenerate()
    {
        $this->_exec('cd '.__DIR__.'/docs && composer install');
        $this->_exec(__DIR__.'/docs/build');
        $this->_exec(__DIR__.'/vendor/bin/couscous preview');
    }
}
