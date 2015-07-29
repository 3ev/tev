<?php
namespace Tev\Tev\Command;

/**
 * Base class for CLI scripts.
 *
 * Extends the Extbase command controller with a couple of extra bits.
 *
 * Example command:
 *
 * class Tx_MyExt_Command_MycontrollerCommandController extends Tx_Tev_Command_BaseCommandController
 * {
 *     /**
 *      * My test command.
 *      *
 *      * @param string $param My test param
 *      * @param boolean $flaf My test flag
 *      *\/
 *     public function testRunner($param, $flag = false)
 *     {
 *         $this->out("You gave $param");
 *         $this->out("$flag " . ($flag ? 'is' : 'is not') . ' set');
 *     }
 * }
 *
 * Which can be run like:
 *
 * `bin/typo3 extabase mycontroller:test --param hello --flag`
 *
 * To see help:
 *
 * `bin/typo3 extabase help mycontroller:test`
 *
 * @author Ben Constable <benconstable@3ev.com>, 3ev
 * @package tev
 * @subpackage Cli
 */
class BaseCommandController extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController
{

    /**
     * Print a line to STDOUT.
     *
     * @param string  $msg     Message to print
     * @param int     $level   Indentation level
     * @param boolean $newLine Whether or not to add a new line. True by default
     */
    protected function out($msg = null, $level = 0, $newLine = true)
    {
        $msg = trim($msg, PHP_EOL) . ($newLine ? PHP_EOL : '');
        $msg = str_repeat('-', $level) . ($level ? ' ' : '') . $msg;
        fwrite(STDOUT, $msg);
    }

    /**
     * Print a banner to STDOUT.
     *
     * @param string $msg Message to print
     */
    protected function banner($msg)
    {
        $this->out(str_pad('', (strlen($msg) + 6), '#'));
        $this->out(str_pad(' ' . $msg . ' ', (strlen($msg) + 6), '#', STR_PAD_BOTH));
        $this->out(str_pad('', (strlen($msg) + 6), '#'));
        $this->out();
    }

    /**
     * Echo a nice 'starting script' message to STDOUT.
     *
     * @param string $message 'Running Script' by default
     */
    protected function startMessage($message = 'Running Script')
    {
        $this->banner($message);
        $this->out('Starting...');
        $this->out();
    }

    /**
     * Echo a nice 'script finished' message to STDOUT.
     */
    protected function endMessage()
    {
        $this->out();
        $this->out('...finished.');
    }
}
