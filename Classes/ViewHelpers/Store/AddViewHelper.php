<?php
namespace Tev\Tev\ViewHelpers\Store;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * View helper to store tag content in the template store, to be rendered later
 * by the render view helper.
 */
class AddViewHelper extends AbstractViewHelper
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
     * Store the tag children in the template store, and don't render anything
     * directly.
     *
     * @return string
     */
    public function render()
    {
        $this->store->append($this->arguments['name'], $this->renderChildren());

        return '';
    }
}
