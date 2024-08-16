<?php declare(strict_types=1);

/*
 * This file is part of the composer package buepro/typo3-container-elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die('Access denied.');

(static function (): void {
    $extensionConfiguration = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class
    );
    $containerElementsConfiguration = $extensionConfiguration->get('container_elements');
    if (!is_array($containerElementsConfiguration)) {
        return;
    }

    /**
     * @link https://github.com/b13/container/issues/272
     */
    if ((bool) ($containerElementsConfiguration['collapsibleContentElements'] ?? false)) {
        $backendPartialsPath = 'EXT:container_elements/Sysext/backend/Resources/Private/Partials';
        foreach ($GLOBALS['TCA']['tt_content']['containerConfiguration'] as &$config) {
            if (!isset(array_flip($config['gridPartialPaths'])[$backendPartialsPath])) {
                $config['gridPartialPaths'][] = $backendPartialsPath;
            }
        }
        unset($config);
    }
})();
