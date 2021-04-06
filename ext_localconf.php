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
     * Get extension configuration
     */
    $extensionConfiguration = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class)->get('container_elements');

    /**
     * Load default TS
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
        '@import "EXT:container_elements/Configuration/TypoScript/setup.typoscript"'
    );

    /**
     * Load static TS for pizpalue
     */
    if((bool) $extensionConfiguration['autoLoadStaticTS'] && \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('pizpalue')) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
            '@import "EXT:container_elements/Configuration/TypoScript/Pizpalue/setup.typoscript"'
        );
    }

    /**
     * Register icons
     */
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    // Content elements
    $icons = ['Container', 'Columns2', 'Columns3', 'Columns4', 'Tabs', 'Accordion', 'TileUnit', 'Card'];
    foreach ($icons as $icon) {
        $iconRegistry->registerIcon(
            'container-elements-' . strtolower($icon),
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:container_elements/Resources/Public/Icons/' . $icon . '.svg']
        );
    }
    // Other icons
    $icons = ['Frame', 'NoFrame'];
    foreach ($icons as $icon) {
        $iconRegistry->registerIcon(
            'container-elements-' . strtolower($icon),
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:container_elements/Resources/Public/Icons/' . $icon . '.svg']
        );
    }

    /**
     * Hooks
     */
    if (1) {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']
        ['container_elements'] = \Buepro\ContainerElements\Hooks\DataHandlerHook::class;
    }
})();
