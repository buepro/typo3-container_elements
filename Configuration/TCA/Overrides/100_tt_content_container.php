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
     * Register container
     */
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
        (
            new \B13\Container\Tca\ContainerConfiguration(
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
                ]
            )
        )
        ->setIcon('container-elements-container')
        ->setBackendTemplate('EXT:container_elements/Resources/Private/Templates/Backend/Container.html')
        ->setSaveAndCloseInNewContentElementWizard(true)
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
