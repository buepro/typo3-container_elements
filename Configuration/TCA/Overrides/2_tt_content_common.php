<?php
declare(strict_types=1);

/*
 * This file is part of the composer package buepro/typo3-container-elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/*
 * This file is part of the composer package buepro/typo3-container-elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die('Access denied.');

(static function (): void {
    /** @var array<string, array> $tcaTypes */
    $tcaTypes = ArrayUtility::getValueByPath($GLOBALS, 'TCA/tt_content/types');
    // Remove header field
    $types = ['ce_container', 'ce_columns2', 'ce_columns3', 'ce_columns4', 'ce_tabs', 'ce_accordion', 'ce_tile_unit', 'ce_card', 'ce_grid', 'ce_randomizer', 'ce_slider'];
    foreach ($types as $type) {
        $tcaShowitem = $tcaTypes[$type]['showitem'];
        if (!is_string($tcaShowitem)) {
            continue;
        }
        $showitemArray = GeneralUtility::trimExplode(',', $tcaShowitem, true);
        $showitemArray = array_filter($showitemArray, function ($item): bool {
            return $item !== 'header' && !str_starts_with($item, 'header;');
        });
        /** @var array<string, array<string, array<string, array<string, array>>>>  $GLOBALS */
        $GLOBALS['TCA']['tt_content']['types'][$type]['showitem'] = implode(',', $showitemArray);
    }
    // Add headers palette and container options (pi_flexform)
    ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content',
        '--palette--;;headers, --div--;Container,pi_flexform;LLL:EXT:container_elements/Resources/Private/Language/locallang.xlf:options',
        implode(',', $types),
        'after:tx_container_parent'
    );
})();
