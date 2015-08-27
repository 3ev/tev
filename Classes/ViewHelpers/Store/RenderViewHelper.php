<?php
namespace Tev\Tev\ViewHelpers\Store;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * View helper to render values from the template store.
 */
class RenderViewHelper extends AbstractViewHelper
{
    /**
     * Template store.
     *
     * @var \Tev\Tev\Services\TemplateStore
     * @inject
     */
    protected $store;

    /**
     * {@inheritdoc}
     */
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument(
            'name',
            'string',
            'Section name',
            true
        );
    }

    /**
     * Render the template store specified by the 'name' argument.
     *
     * @return string
     */
    public function render()
    {
        return $this->store->get($this->arguments['name']);
    }
}
