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
     * Register tabs
     */
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->addContainer(
        'ce_tabs',
        'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:tabs.title',
        'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:tabs.description',
        [
            [
                [
                    'name' => 'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:content',
                    'colPos' => 101
                ]
            ]
        ],
        'container-elements-tabs',
        'EXT:container/Resources/Private/Templates/Container.html',
        'EXT:container/Resources/Private/Templates/Grid.html',
        true
    );

    /**
     * Add flexForm
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:container_elements/Configuration/FlexForms/Tabs.xml',
        'ce_tabs'
    );
})();
