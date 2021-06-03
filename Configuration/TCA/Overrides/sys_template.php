<?php

/*
 * This file is part of the package buepro/container_elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') || die('Access denied');

(function () {
    $extensionConfiguration = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class)->get('container_elements');
    if(!(bool) $extensionConfiguration['autoLoadStaticTS'] &&
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('pizpalue')
    ) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
            'container_elements',
            'Configuration/TypoScript/Pizpalue',
            'Container elements - Pizpalue'
        );
    }
})();
