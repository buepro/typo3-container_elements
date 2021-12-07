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
    $typeList = 'ce_container,ce_columns2,ce_columns3,ce_columns4,ce_tabs,ce_accordion,ce_tile_unit,ce_card,ce_grid,ce_randomizer';
    // Remove header field
    foreach (\TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $typeList, true) as $type) {
        $showitem = $GLOBALS['TCA']['tt_content']['types'][$type]['showitem'];
        $showitem = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $showitem, true);
        $showitem = array_filter($showitem, function ($item): bool {
            return strpos($item, 'header') !== 0;
        });
        $GLOBALS['TCA']['tt_content']['types'][$type]['showitem'] = implode(', ', $showitem);
    }
    // Add headers palette and container options (pi_flexform)
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content',
        '--palette--;;headers, --div--;Container,pi_flexform;LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:options',
        $typeList,
        'after:tx_container_parent'
    );
})();
