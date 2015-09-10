<?php
namespace Tev\Tev\ViewHelpers\Page;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * View helper to load menu item titles from arbitrary related database rows.
 *
 * The config for this is set on each page record in the CMS.
 *
 * Usage:
 *
 *     {namespace tev=Tev\Tev\ViewHelpers}
 *
 *     <tev:page.menuTitle pageUid="12" />
 */
class MenuTitleViewHelper extends AbstractViewHelper
{
    /**
     * VHS page select service.
     *
     * @var \FluidTYPO3\Vhs\Service\PageSelectService
     * @inject
     */
    protected $pageSelect;

    /**
     * {@inheritdoc}
     */
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument(
            'pageUid',
            'int',
            'Optional. Page UID to load menu title from. If ommitted, current page is used',
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $page = $this->getPage();

        if (isset($page['tx_tev_menu_use_db']) && $page['tx_tev_menu_use_db']) {
            if (($id = $this->getId($page['tx_tev_menu_request_var'])) !== null) {
                $title = $this->getDbTitle(
                    $page['tx_tev_menu_table'],
                    $page['tx_tev_menu_field'],
                    $id
                );

                if ($title !== null) {
                    return $title;
                }
            }
        }

        return $this->getFallbackTitle($page);
    }

    /**
     * Get the selected page.
     *
     * @return array
     */
    private function getPage()
    {
        $pageUid = intval($this->arguments['pageUid']);

        if ($pageUid === 0) {
            $pageUid = $GLOBALS['TSFE']->id;
        }

        return $this->pageSelect->getPage($pageUid);
    }

    /**
     * Attempt to load the title from the database.
     *
     * @param  string      $table Table name
     * @param  string      $field Title field name
     * @param  int         $id    Table row UID
     * @return string|null        Title or null if not found
     */
    private function getDbTitle($table, $field, $id)
    {
        // Quote strings

        $idField = $GLOBALS['TYPO3_DB']->quoteStr('uid', $table);
        $id = $GLOBALS['TYPO3_DB']->fullQuoteStr($id, $table);

        // Load row

        $rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($field, $table, $idField . ' = ' . $id);

        // Get value

        if (is_array($rows) && count($rows)) {
            return reset($rows)[$field];
        } else {
            return null;
        }
    }

    /**
     * Get the fallback title from the page.
     *
     * @param  array  $page
     * @return string
     */
    private function getFallbackTitle($page)
    {
        return $page['nav_title'] ?: $page['title'];
    }

    /**
     * Get the UID from the current request.
     *
     * @param  string      $reqVar Request variable name. '.' separators used to indicate nested values
     * @return string|null         Found UID, or null if not found
     */
    private function getId($reqVar)
    {
        $val = null;

        foreach (explode('.', $reqVar) as $i => $part) {
            if ($i === 0) {
                $val = GeneralUtility::_GP($part);
            } else {
                $val = $val[$part];
            }
        }

        if (!is_array($val)) {
            return $val;
        } else {
            return null;
        }
    }
}
