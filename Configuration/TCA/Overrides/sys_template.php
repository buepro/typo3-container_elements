<?php
declare(strict_types = 1);

/*
 * This file is part of the composer package buepro/typo3-container-elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die('Access denied');

(static function (): void {
    $extensionConfiguration = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class
    )->get('container_elements');
    if (!(bool) $extensionConfiguration['autoLoadStaticTS'] &&
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('pizpalue')
    ) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
            'container_elements',
            'Configuration/TypoScript/Pizpalue',
            'Container elements - Pizpalue'
        );
    }
    if ((bool) $extensionConfiguration['showDeprecatedItems']) {
        // @deprecated since version 3.0.0, will be removed in version 4.0.0
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
            'container_elements',
            'Configuration/TypoScript/Deprecated/Bootstrap4',
            'Container elements DEPRECATED - Bootstrap 4'
        );
    }
})();
