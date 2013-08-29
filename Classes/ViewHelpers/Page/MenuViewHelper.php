<?php

/**
 * Subclasses the VHS Menu view helper to add an extra class option for menu
 * items.
 *
 * @author Ben Constable <benconstable@3ev.com>, 3ev
 * @package tev
 * @subpackage ViewHelpers\Page
 */
class Tx_Tev_ViewHelpers_Page_MenuViewHelper
    extends Tx_Vhs_ViewHelpers_Page_MenuViewHelper
{
    /**
     * @var int $currentLevel Current menu level being rendered
     */
    protected $currentLevel = 0;

    /**
     * Add the new 'classItem' option.
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument(
            'classItem',
            'string',
            'Optional extra class to add to each link (and wrapper) element. Use ' .
            ':level in the class name to add the current level number to the class.'
        );
    }

    /**
     * Adds 'classItem' to the array if set.
     *
     * @see Tx_Vhs_ViewHelpers_Page_Menu_Abstract_MenuViewHelper
     * @param array $pageRow
     * @return array
     */
    protected function getItemClass($pageRow)
    {
        $classes = parent::getItemClass($pageRow);
        if ($ci = $this->arguments['classItem']) {
            $classes[] = str_replace(':level', $this->currentLevel + 1, $ci);
        }
        return $classes;
    }

    /**
     * Track the current menu level before rendering.
     *
     * @see Tx_Vhs_ViewHelpers_Page_Menu_Abstract_MenuViewHelper
     * @param array $menu
     * @param integer $level
     * @return string
     */
    protected function autoRender($menu, $level = 1)
    {
        $this->currentLevel = $level;
        return parent::autoRender($menu, $level);
    }
}
