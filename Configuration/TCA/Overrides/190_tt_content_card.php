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
     * Register card
     */
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->addContainer(
        'ce_card',
        'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:card.title',
        'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:card.description',
        [
            [
                [
                    'name' => 'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:card.content',
                    'colPos' => 101
                ],

            ],
            [
                [
                    'name' => 'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:card.imageContent',
                    'colPos' => 201
                ],
            ],
        ],
        'EXT:container_elements/Resources/Public/Icons/Card.svg',
        'EXT:container/Resources/Private/Templates/Container.html',
        'EXT:container/Resources/Private/Templates/Grid.html',
        false
    );

    /**
     * Add flexForm
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:container_elements/Configuration/FlexForms/Card.xml',
        'ce_card'
    );
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content',
        'pi_flexform',
        'ce_card',
        'after:header'
    );
})();
