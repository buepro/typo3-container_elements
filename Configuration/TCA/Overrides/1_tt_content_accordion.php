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
     * Register accordion
     */
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
        (
            new \B13\Container\Tca\ContainerConfiguration(
                'ce_accordion',
                'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:accordion.title',
                'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:accordion.description',
                [
                    [
                        [
                            'name' => 'LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:content',
                            'colPos' => 101
                        ]
                    ]
                ]
            )
        )
        ->setIcon('container-elements-accordion')
        ->setSaveAndCloseInNewContentElementWizard(true)
    );

    /**
     * Add flexForm
     */
    ArrayUtility::setValueByPath(
        $GLOBALS, 
        'TCA/tt_content/types/ce_accordion/columnsOverrides/pi_flexform/config/ds',
        'FILE:EXT:container_elements/Configuration/FlexForms/Accordion.xml'
    );
})();
