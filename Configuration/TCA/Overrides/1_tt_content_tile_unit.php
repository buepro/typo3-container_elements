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
        ->setSaveAndCloseInNewContentElementWizard(true)
    );

    /**
     * Add flexForm
     */
    ArrayUtility::setValueByPath(
        $GLOBALS, 
        'TCA/tt_content/types/ce_tile_unit/columnsOverrides/pi_flexform/config/ds',
        'FILE:EXT:container_elements/Configuration/FlexForms/TileUnit.xml'
    );
})();
