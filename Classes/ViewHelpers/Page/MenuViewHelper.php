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
     * Append item class before rendering.
     *
     * @see Tx_Vhs_ViewHelpers_Page_Menu_Abstract_MenuViewHelper
     * @param array $menu
     * @param integer $level
     * @return string
     */
    protected function autoRender($menu, $level = 1)
    {
        if ($ci = $this->arguments['classItem']) {
            foreach ($menu as &$page) {
                $page['class'] .= ' ' . str_replace(':level', $level, $ci);
            }
        }

        return parent::autoRender($menu, $level);
    }
}
