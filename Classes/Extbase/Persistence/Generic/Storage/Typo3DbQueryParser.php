<?php
namespace Tev\Tev\Extbase\Persistence\Generic\Storage;

use TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser as BaseTypo3DbQueryParser;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\ColumnMap;

/**
 * Extend the base QueryParser with a patch to fix an MM_match_fields bug.
 *
 * Patch is here https://review.typo3.org/#/c/29870/, and has not been merged
 * into the core.
 */
class Typo3DbQueryParser extends BaseTypo3DbQueryParser
{
    /**
     * {@inheritdoc}
     */
    protected function addUnionStatement(&$className, &$tableName, &$propertyPath, array &$sql)
    {
        $explodedPropertyPath = explode('.', $propertyPath, 2);
        $propertyName = $explodedPropertyPath[0];
        $columnName = $this->dataMapper->convertPropertyNameToColumnName($propertyName, $className);
        $tableName = $this->dataMapper->convertClassNameToTableName($className);
        $columnMap = $this->dataMapper->getDataMap($className)->getColumnMap($propertyName);

        if ($columnMap === NULL) {
            throw new \TYPO3\CMS\Extbase\Persistence\Generic\Exception\MissingColumnMapException('The ColumnMap for property "' . $propertyName . '" of class "' . $className . '" is missing.', 1355142232);
        }

        $parentKeyFieldName = $columnMap->getParentKeyFieldName();
        $childTableName = $columnMap->getChildTableName();

        if ($childTableName === NULL) {
            throw new \TYPO3\CMS\Extbase\Persistence\Generic\Exception\InvalidRelationConfigurationException('The relation information for property "' . $propertyName . '" of class "' . $className . '" is missing.', 1353170925);
        }

        if ($columnMap->getTypeOfRelation() === ColumnMap::RELATION_HAS_ONE) {
            if (isset($parentKeyFieldName)) {
                $sql['unions'][$childTableName] = 'LEFT JOIN ' . $childTableName . ' ON ' . $tableName . '.uid=' . $childTableName . '.' . $parentKeyFieldName;
            } else {
                $sql['unions'][$childTableName] = 'LEFT JOIN ' . $childTableName . ' ON ' . $tableName . '.' . $columnName . '=' . $childTableName . '.uid';
            }
            $className = $this->dataMapper->getType($className, $propertyName);
        } elseif ($columnMap->getTypeOfRelation() === ColumnMap::RELATION_HAS_MANY) {
            if (isset($parentKeyFieldName)) {
                $sql['unions'][$childTableName] = 'LEFT JOIN ' . $childTableName . ' ON ' . $tableName . '.uid=' . $childTableName . '.' . $parentKeyFieldName;
            } else {
                $onStatement = '(FIND_IN_SET(' . $childTableName . '.uid, ' . $tableName . '.' . $columnName . '))';
                $sql['unions'][$childTableName] = 'LEFT JOIN ' . $childTableName . ' ON ' . $onStatement;
            }
            $className = $this->dataMapper->getType($className, $propertyName);
        } elseif ($columnMap->getTypeOfRelation() === ColumnMap::RELATION_HAS_AND_BELONGS_TO_MANY) {
            $relationTableName = $columnMap->getRelationTableName();

            // BEGIN PATCH
            // Incorporates change from https://review.typo3.org/#/c/29870/
            $relationTableMatchFields = $columnMap->getRelationTableMatchFields();
            if (is_array($relationTableMatchFields)) {
                $additionalWhere = array();
                foreach ($relationTableMatchFields as $fieldName => $value) {
                    $additionalWhere[] = $relationTableName . '.' . $fieldName . ' = ' . $this->databaseHandle->fullQuoteStr($value, $relationTableName);
                }
                $additionalWhereForMatchFields = ' AND ' . implode(' AND ', $additionalWhere);
            } else {
                $additionalWhereForMatchFields = '';
            }

            $sql['unions'][$relationTableName] = 'LEFT JOIN ' . $relationTableName . ' ON (' . $tableName . '.uid=' . $relationTableName . '.' . $columnMap->getParentKeyFieldName() . $additionalWhereForMatchFields . ')';
            $sql['unions'][$childTableName] = 'LEFT JOIN ' . $childTableName . ' ON (' . $relationTableName . '.' . $columnMap->getChildKeyFieldName() . '=' . $childTableName . '.uid)';
            // END PATCH

            $className = $this->dataMapper->getType($className, $propertyName);
        } else {
            throw new \TYPO3\CMS\Extbase\Persistence\Generic\Exception('Could not determine type of relation.', 1252502725);
        }
        // @todo check if there is another solution for this
        $sql['keywords']['distinct'] = 'DISTINCT';
        $propertyPath = $explodedPropertyPath[1];
        $tableName = $childTableName;
    }
}
