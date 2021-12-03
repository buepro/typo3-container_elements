<?php
declare(strict_types = 1);

/*
 * This file is part of the composer package buepro/typo3-container-elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die('Access denied.');

(static function (): void {
    /**
     * Register card
     */
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
        (
            new \B13\Container\Tca\ContainerConfiguration(
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
                ]
            )
        )
        ->setIcon('container-elements-card')
        ->setBackendTemplate('EXT:container_elements/Resources/Private/Templates/Backend/Card.html')
        ->setSaveAndCloseInNewContentElementWizard(true)
    );

    /**
     * Add flexForm
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:container_elements/Configuration/FlexForms/Card.xml',
        'ce_card'
    );
})();
