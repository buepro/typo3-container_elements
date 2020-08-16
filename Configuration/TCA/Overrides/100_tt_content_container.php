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
     * Register container
     */
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->addContainer(
        'ce_container',
        'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:container.title',
        'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:container.description',
        [
            [
                [
                    'name' => 'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:content',
                    'colPos' => 101
                ]
            ]
        ],
        'container-elements-container',
        'EXT:container_elements/Resources/Private/Templates/Backend/Container.html',
        'EXT:container/Resources/Private/Templates/Grid.html',
        true
    );

    /**
     * Add flexForm
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:container_elements/Configuration/FlexForms/Container.xml',
        'ce_container'
    );
})();
