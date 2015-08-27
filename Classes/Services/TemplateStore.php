<?php
namespace Tev\Tev\Services;

use TYPO3\CMS\Core\SingletonInterface;

/**
 * Stores data that can be rendered in templates later, via view helpers.
 */
class TemplateStore implements SingletonInterface
{
    /**
     * Storage.
     *
     * @var array
     */
    private $store;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->store = [];
    }

    /**
     * Set a template value.
     *
     * @param  string                          $key
     * @param  string                          $value
     * @return \Tev\Tev\Services\TemplateStore
     */
    public function set($key, $value)
    {
        $this->store[$key] = $value;

        return $this;
    }

    /**
     * Append to an exsting template value.
     *
     * $key will be created if it doesn't already exist.
     *
     * @param  string                          $key
     * @param  string                          $value
     * @return \Tev\Tev\Services\TemplateStore
     */
    public function append($key, $value)
    {
        if (!isset($this->store[$key])) {
            $this->store[$key] = '';
        }

        $this->store[$key] .= $value;

        return $this;
    }

    /**
     * Get a template value.
     *
     * @param  string $key
     * @return string
     */
    public function get($key)
    {
        if (!isset($this->store[$key])) {
            $this->store[$key] = '';
        }

        return $this->store[$key];
    }
}
