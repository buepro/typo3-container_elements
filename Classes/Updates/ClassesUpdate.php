<?php
declare(strict_types = 1);

/*
 * This file is part of the composer package buepro/typo3-container-elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Buepro\ContainerElements\Updates;

use TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

class ClassesUpdate implements UpgradeWizardInterface
{
    /**
     * @var array
     */
    private $classFields = [
        'ce_accordion' => [],
        'ce_card' => [
            'customSheet' => ['cardWrapClasses', 'cardClasses', 'bodyClasses', 'borderClasses', 'titleClasses',
                'imageWrapClasses', 'imageClasses', 'textColumnClasses', 'imageColumnClasses']
        ],
        'ce_columns2' => [
            'sCustom' => ['row.class', 'columns.1.class', 'columns.2.class'],
        ],
        'ce_columns3' => [
            'sCustom' => ['row.class', 'columns.1.class', 'columns.2.class', 'columns.3.class'],
        ],
        'ce_columns4' => [
            'sCustom' => ['row.class', 'columns.1.class', 'columns.2.class', 'columns.3.class', 'columns.4.class'],
        ],
        'ce_container' => [
            'sDEF' => ['containerClass', 'sectionClass'],
        ],
        'ce_tabs' => [],
        'ce_tile_unit' => [
            'sDEF' => ['customColumn1', 'customColumn2'],
        ],
    ];

    /**
     * @var string[]
     */
    private $replacementClasses = [
        'no-gutters' => 'g-0',
        'left-' => 'start-',
        'right-' => 'end-',
        'float-left' => 'float-start',
        'float-right' => 'float-end',
        'border-left' => 'border-start',
        'border-right' => 'border-end',
        'rounded-left' => 'rounded-start',
        'rounded-right' => 'rounded-end',
        'ml-' => 'ms-',
        'mr-' => 'me-',
        'pl-' => 'ps-',
        'pr-' => 'pe-',
        'text-left' => 'text-start',
        'text-right' => 'text-end',
        'text-monospace' => 'font-monospace',
        'font-weight' => 'fw-',
        'font-style' => 'fst-',
        'rounded-sm' => 'rounded-1',
        'rounded-lg' => 'rounded-3',
        'ratio-1by1' => 'ratio-1x1',
        'ratio-4by3' => 'ratio-4x3',
        'ratio-16by9' => 'ratio-16x9',
        'ratio-21by9' => 'ratio-21x9',
    ];

    /** @var FlexFormTools $flexFormTools */
    private $flexFormTools;

    public function __construct()
    {
        $this->flexFormTools = GeneralUtility::makeInstance(FlexFormTools::class);
    }

    /**
     * @inheritDoc
     */
    public function getIdentifier(): string
    {
        return self::class;
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return '[Container elements] Migrate the classes fields to Bootstrap 5';
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return 'Bootstrap 5 replaced some css classes. This wizard step checks the classes fields for '
            . 'replacement classes and adds the new classes as needed. The resulting classes should be compatible '
            . 'with Bootstrap 4 and Bootstrap 5.';
    }

    /**
     * @inheritDoc
     */
    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class
        ];
    }

    private function getConstraints(
        QueryBuilder $queryBuilder
    ): \TYPO3\CMS\Core\Database\Query\Expression\CompositeExpression {
        $typeConstraints = [];
        foreach ($this->classFields as $type => $unused) {
            $typeConstraints[] = $queryBuilder->expr()->eq(
                'CType',
                $queryBuilder->createNamedParameter($type, \PDO::PARAM_STR)
            );
        }
        $classConstraints = [];
        foreach ($this->replacementClasses as $oldClass => $newClass) {
            $classConstraints[] = $queryBuilder->expr()->like(
                'pi_flexform',
                $queryBuilder->createNamedParameter('%' . $oldClass . '%', \PDO::PARAM_STR)
            );
        }
        return $queryBuilder->expr()->andX(
            /** @phpstan-ignore-next-line */
            $queryBuilder->expr()->orX(...$typeConstraints),
            /** @phpstan-ignore-next-line */
            $queryBuilder->expr()->orX(...$classConstraints)
        );
    }

    /**
     * @inheritDoc
     */
    public function updateNecessary(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function executeUpdate(): bool
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tt_content');
        $queryBuilder = $connection->createQueryBuilder();
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        $queryResult = $queryBuilder->select('uid', 'CType', 'pi_flexform')
            ->from('tt_content')
            ->where($this->getConstraints($queryBuilder))
            ->execute();
        /** @phpstan-ignore-next-line */
        while ($record = $queryResult->fetch()) {
            $queryBuilder = $connection->createQueryBuilder();
            $queryBuilder->update('tt_content')
                ->where(
                    $queryBuilder->expr()->eq(
                        'uid',
                        $queryBuilder->createNamedParameter($record['uid'], \PDO::PARAM_INT)
                    )
                )
                ->set('pi_flexform', $this->addNewClassesToDs($record['CType'], $record['pi_flexform']));
            $queryBuilder->execute();
        }
        return true;
    }

    private function addNewClassesToDs(string $cType, string $flexform): string
    {
        if (!isset($this->classFields[$cType])) {
            return $flexform;
        }
        $flexformData = GeneralUtility::xml2array($flexform);
        foreach ($this->classFields[$cType] as $sheetName => $fieldNames) {
            foreach ($fieldNames as $fieldName) {
                $path = 'data/' . $sheetName . '/lDEF/' . $fieldName . '/vDEF';
                if (!ArrayUtility::isValidPath($flexformData, $path)) {
                    continue;
                }
                $classField = ArrayUtility::getValueByPath(
                    $flexformData,
                    $path
                );
                if (isset($classField) && is_string($classField) && trim($classField) !== '') {
                    $classField = $this->addNewClasses($classField);
                    $flexformData = ArrayUtility::setValueByPath(
                        $flexformData,
                        $path,
                        $classField
                    );
                }
            }
        }
        return $this->flexFormTools->flexArray2Xml($flexformData, true);
    }

    private function addNewClasses(string $classes): string
    {
        $actualClasses = GeneralUtility::trimExplode(' ', $classes, true);
        $newClasses = [];
        foreach ($actualClasses as $actualClass) {
            foreach ($this->replacementClasses as $oldClass => $newClass) {
                if (strpos($actualClass, $oldClass) === 0) {
                    $tail = GeneralUtility::trimExplode($oldClass, $actualClass, true, 1);
                    $newClass = implode('', array_merge([$newClass], $tail));
                    if (strpos($classes, $newClass) === false) {
                        $newClasses[] = $newClass;
                    }
                }
            }
        }
        return implode(' ', array_merge($actualClasses, $newClasses));
    }
}
