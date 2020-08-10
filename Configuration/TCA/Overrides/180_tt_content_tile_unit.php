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
     * Register tileUnit
     */
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->addContainer(
        'ce_tile_unit',
        'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:tileUnit.title',
        'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:tileUnit.description',
        [
            [
                [
                    'name' => 'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:tileUnit.left',
                    'colPos' => 101
                ],
                [
                    'name' => 'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:tileUnit.right',
                    'colPos' => 102
                ],
            ]
        ],
        'EXT:container_elements/Resources/Public/Icons/TileUnit.svg',
        'EXT:container/Resources/Private/Templates/Container.html',
        'EXT:container/Resources/Private/Templates/Grid.html',
        false
    );

    /**
     * Add flexForm
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:container_elements/Configuration/FlexForms/TileUnit.xml',
        'ce_tile_unit'
    );
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content',
        'pi_flexform',
        'ce_tile_unit',
        'after:header'
    );
})();
