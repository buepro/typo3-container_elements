<?php

/*
 * This file is part of the package buepro/container_elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') || die('Access denied.');

(function () {
    /**
     * Register columns2
     */
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->addContainer(
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
        ],
        'container-elements-columns2',
        'EXT:container/Resources/Private/Templates/Container.html',
        'EXT:container/Resources/Private/Templates/Grid.html',
        true
    );

    /**
     * Add flexForm
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:container_elements/Configuration/FlexForms/Columns2.xml',
        'ce_columns2'
    );
})();
