<?php

/**
 * Abstract class for CLI scripts.
 *
 * @author Ben Constable <benconstable@3ev.com>, 3ev
 * @package tev
 * @subpackage Cli
 */
abstract class Tx_Tev_Cli_AbstractScript extends \TYPO3\CMS\Core\Controller\CommandLineController
{
    /**
     * @var array $args Arguments array
     */
    private $args = null;

    /**
     * @var array $options
     */
    protected $options = array();

    /**
     * @var string $method Method to run
     */
    protected $method;

    /**
     * Constructor.
     *
     * Store arguments and method to run.
     */
    public function __construct()
    {
        // Remove non-params
        array_shift($_SERVER['argv']);
        $this->method = array_shift($_SERVER['argv']);

        // Populate args
        parent::__construct();
        $this->args = $this->parseArgs();
    }

    /**
     * Run the supplied method.
     */
    public function run()
    {
        if (!in_array($this->method . 'Runner', get_class_methods($this))) {
            $this->out('Method not found');
        } else {
            $this->banner("Running '{$this->method}'");

            $this->out('Starting...');
            $this->out('');

            $this->{$this->method . 'Runner'}();

            $this->out('');
            $this->out('...done.');
        }
    }

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
     * Get a command line arguement.
     *
     * @param string $key
     * @return string Value
     */
    protected function getArg($key)
    {
        return $this->args[$key];
    }

    /**
     * Parse CLI arguments in a nicer array.
     *
     * @return array
     */
    private function parseArgs()
    {
        $parsed = array();
        foreach ($this->cli_args as $key => $value) {
            $key = ltrim($key, '-');
            $parsed[$key] = isset($value[0]) ? $value[0] : null;
        }
        return $parsed;
    }
}
