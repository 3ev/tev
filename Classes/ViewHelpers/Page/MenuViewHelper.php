<?php
namespace Tev\Tev\ViewHelpers\Page;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Subclasses the VHS Menu view helper to add an extra class option for menu
 * items.
 */
class MenuViewHelper extends AbstractViewHelper
{
    /**
     * Add the new 'classItem' option.
     *
     * @return void
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

        for ($i = 2; $i <= 10; $i++) {
            $this->registerArgument(
                'classItem' . $i,
                'string',
                'Optional extra class to add to each link (and wrapper) element (level ' . $i . '. Use ' .
                ':level in the class name to add the current level number to the class.'
            );
        }
    }

    /**
     * Append item class before rendering.
     *
     * @param  array  $menu
     * @param  int    $level
     * @return string
     */
    protected function autoRender($menu, $level = 1)
    {
        $className = 'classItem' . ($level > 1 ? $level : '');

        if ($this->arguments[$className] !== null) {
            $ci = $this->arguments[$className];
        } else {
            $ci = $this->arguments['classItem'];
        }

        if ($ci) {
            foreach ($menu as &$page) {
                $page['class'] .= ' ' . str_replace(':level', $level, $ci);
            }
        }

        return parent::autoRender($menu, $level);
    }

    /**
     * Fix error with hidden pages not showing correctly with shortcuts.
     *
     * @param  array $page
     * @param  array $rootLine
     * @return array
     */
    protected function getMenuItemEntry($page, $rootLine)
    {
        $page = parent::getMenuItemEntry($page, $rootLine);
        $page['hasSubPages'] = (count($this->getSubmenu($page['uid'])) > 0) ? 1 : 0;
        $page['class'] = implode(' ', $this->getItemClass($page));
        return $page;
    }
}
