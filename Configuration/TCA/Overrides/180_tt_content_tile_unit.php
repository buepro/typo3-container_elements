<?php

/*
 * This file is part of the package buepro/container_elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') || die('Access denied.');

(function () {
    /**
     * Register tileUnit
     */
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
        (
            new \B13\Container\Tca\ContainerConfiguration(
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
                ]
            )
        )
        ->setIcon('container-elements-tileunit')
        ->setBackendTemplate('EXT:container_elements/Resources/Private/Templates/Backend/Container.html')
        ->setSaveAndCloseInNewContentElementWizard(true)
    );

    /**
     * Add flexForm
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:container_elements/Configuration/FlexForms/TileUnit.xml',
        'ce_tile_unit'
    );
})();
