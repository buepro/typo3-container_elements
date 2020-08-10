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
     * Register columns3
     */
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->addContainer(
        'ce_columns3',
        'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:columns.threeColumnTitle',
        'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:columns.threeColumnDescription',
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
                [
                    'name' => 'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:columns.column3',
                    'colPos' => 103
                ],
            ]
        ],
        'EXT:container_elements/Resources/Public/Icons/Columns3.svg',
        'EXT:container/Resources/Private/Templates/Container.html',
        'EXT:container/Resources/Private/Templates/Grid.html',
        false
    );

    /**
     * Add flexForm
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:container_elements/Configuration/FlexForms/Columns3.xml',
        'ce_columns3'
    );
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content',
        'pi_flexform',
        'ce_columns3',
        'after:header'
    );
})();
