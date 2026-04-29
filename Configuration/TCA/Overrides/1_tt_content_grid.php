<?php
declare(strict_types = 1);

/*
 * This file is part of the composer package buepro/typo3-container-elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Utility\ArrayUtility;

/*
 * This file is part of the composer package buepro/typo3-container-elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die('Access denied.');

(static function (): void {
    /**
     * Register columns2
     */
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
        (
            new \B13\Container\Tca\ContainerConfiguration(
                'ce_grid',
                'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:grid.title',
                'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:grid.description',
                [
                    [
                        [
                            'name' => 'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:grid.elements',
                            'colPos' => 101,
                        ],
                    ],
                ]
            )
        )
        ->setIcon('container-elements-grid')
        ->setSaveAndCloseInNewContentElementWizard(true)
    );

    /**
     * Add flexForm
     *
     * @var array<string, array<string, array<string, array>>> $GLOBALS
     */
    $GLOBALS['TCA']['tt_content']['types'] = ArrayUtility::setValueByPath(
        $GLOBALS['TCA']['tt_content']['types'],
        'ce_grid/columnsOverrides/pi_flexform/config/ds',
        'FILE:EXT:container_elements/Configuration/FlexForms/Grid.xml'
    );
})();
