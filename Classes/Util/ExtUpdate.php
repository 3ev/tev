<?php

namespace Tev\Tev\Util;

/**
 * Utility class to allow class.ext_update.php scripts to execute changes
 * in the ext_tables.sql file.
 *
 * Example usage (in the `main()` method of your class.ext_update.php):
 *
 * $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
 * $dbUpdate      = $objectManager->get('Tev\\Tev\\Util\\ExtUpdate', 'ext_key');
 * $markup        = $dbUpdate->renderUpdateStatements();
 *
 * @author Ben Constable, 3ev
 * @package Tev\Tev
 * @subpackage Util
 */
class ExtUpdate
{
    /**
     * @var TYPO3\CMS\Extbase\Object\ObjectManager $objectManager
     */
    protected $objectManager;

    /**
     * @var TYPO3\CMS\Extensionmanager\Utility\InstallUtility $installUtility
     */
    protected $installUtility;

    /**
     * @var array $extension
     */
    private $extension;

    /**
     * @var array $updateStatements
     */
    private $updateStatements;

    /**
     * Constructor.
     *
     * @param string $extension EXT key
     */
    public function __construct($extension)
    {
        $this->objectManager    = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $this->installUtility   = $this->objectManager->get('TYPO3\\CMS\\Extensionmanager\\Utility\\InstallUtility');
        $this->extension        = $this->installUtility->enrichExtensionWithDetails($extension);
        $this->updateStatements = null;
    }

    /**
     * Render the update statements.
     *
     * Will either render the statements with an 'Update' button, or will execute
     * the statements if the 'Update' form has been submitted.
     *
     * @return string
     */
    public function renderUpdateStatements()
    {
        $update = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('updatedb');
        $updateStatements = $this->getUpdateStatements();
        $markup = '<h3>Database Updates</h3>';

        if ($update) {
            foreach ((array) $updateStatements['add'] as $string) {
                $GLOBALS['TYPO3_DB']->admin_query($string);
            }
            foreach ((array) $updateStatements['change'] as $string) {
                $GLOBALS['TYPO3_DB']->admin_query($string);
            }
            foreach ((array) $updateStatements['create_table'] as $string) {
                $GLOBALS['TYPO3_DB']->admin_query($string);
            }

            $markup .= '<p>Database updates complete.</p>';
        } else {
            $haveUpdates = false;

            if (count($updateStatements['add'])) {
                $haveUpdates = true;
                $markup .= '<p><strong>The following fields will be added:</strong></p>';
                foreach ($updateStatements['add'] as $statement) {
                    $markup .= "<pre>$statement</pre>";
                }
                $markup .= '<br />';
            }

            if (count($updateStatements['change'])) {
                $haveUpdates = true;
                $markup .= '<p><strong>The following fields will be changed:</strong></p>';
                foreach ($updateStatements['change'] as $statement) {
                    $markup .= "<pre>$statement</pre>";
                }
                $markup .= '<br />';
            }

            if (count($updateStatements['create_table'])) {
                $haveUpdates = true;
                $markup .= '<p><strong>The following tables will be added:</strong></p>';
                foreach ($updateStatements['create_table'] as $statement) {
                    $markup .= "<pre>$statement</pre>";
                }
                $markup .= '<br />';
            }

            if (!$haveUpdates) {
                $markup .= '<p>No database updates found</p>';
            } else {
                $markup .= $this->renderUpdateForm();
            }
        }

        return $markup;
    }

    /**
     * Get an array of database update statements to execute.
     *
     * Will diff ext_tables.sql against the current database to work out what
     * needs to be changed.
     *
     * @return array Array of statements, like: 'add'[], 'change'[], 'create_table'[]
     */
    protected function getUpdateStatements()
    {
        if ($this->updateStatements === null) {
            $extTablesSqlFile = PATH_site . $this->extension['siteRelPath'] . '/ext_tables.sql';
            $extTablesSqlContent = '';
            if (file_exists($extTablesSqlFile)) {
                $extTablesSqlContent .= \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl($extTablesSqlFile);
            }

            if ($extTablesSqlContent) {
                $parser = $this->installUtility->installToolSqlParser;

                $fieldDefinitionsFromFile = $parser->getFieldDefinitions_fileContent($extTablesSqlContent);
                $fieldDefinitionsFromCurrentDatabase = $parser->getFieldDefinitions_database();
                $diff = $parser->getDatabaseExtra($fieldDefinitionsFromFile, $fieldDefinitionsFromCurrentDatabase);

                $updateStatements = $parser->getUpdateSuggestions($diff);

                $this->updateStatements = array(
                    'add' => $updateStatements['add'],
                    'change' => $updateStatements['change'],
                    'create_table' => $updateStatements['create_table']
                );
            } else {
                $this->updateStatements = array(
                    'add' => array(),
                    'change' => array(),
                    'create_table' => array()
                );
            }
        }

        return $this->updateStatements;
    }

    /**
     * Render the database update submission form.
     *
     * @return string
     */
    private function renderUpdateForm()
    {
        $markup  = '<form name="dbUpdateForm" action="" method="post">';
        $markup .= '<p><input type="submit" name="updatedb" value="Update database?" /></p>';
        $markup .= '</form>';

        return $markup;
    }
}
