<?php
declare(strict_types = 1);

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
                'ce_columns2',
                'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:columns.twoColumnTitle',
                'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:columns.twoColumnDescription',
                [
                    [
                        [
                            'name' => 'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:columns.column1',
                            'colPos' => 101
                        ],
                        [
                            'name' => 'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:columns.column2',
                            'colPos' => 102
                        ],
                    ]
                ]
            )
        )
        ->setIcon('container-elements-columns2')
        ->setSaveAndCloseInNewContentElementWizard(true)
    );

    /**
     * Add flexForm
     */
    ArrayUtility::setValueByPath(
        $GLOBALS, 
        'TCA/tt_content/types/ce_columns2/columnsOverrides/pi_flexform/config/ds',
        'FILE:EXT:container_elements/Configuration/FlexForms/Columns2.xml'
    );
})();
