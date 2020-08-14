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
     * Load default TS
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
        '@import "EXT:container_elements/Configuration/TypoScript/setup.typoscript"'
    );

    /**
     * Register icons
     */
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $icons = ['Container', 'Columns2', 'Columns3', 'Columns4', 'Tabs', 'Accordion', 'TileUnit', 'Card'];
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
