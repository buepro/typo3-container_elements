<?php
declare(strict_types=1);

/*
 * This file is part of the composer package buepro/typo3-container-elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Buepro\ContainerElements\Utility;

use TYPO3\CMS\Core\Utility\ArrayUtility;

class TcaUtility
{

    /**
     * Sets $GLOBALS['TCA']['tt_content']['types'][$contentElementType]
     *  ['columnsOverrides']['pi_flexform']['config']['ds'] to $xmlFile
     *
     * @param string $xmlFile E.g. 'FILE:EXT:container_elements/Configuration/FlexForms/Accordion.xml'
     */
    public static function setPiFlexForm(string $contentElementType, string $xmlFile): void
    {
        /** @var array<string, array<string, array<string, array<string, array>>>> $GLOBALS */
        $GLOBALS['TCA']['tt_content']['types'][$contentElementType] = ArrayUtility::setValueByPath(
            $GLOBALS['TCA']['tt_content']['types'][$contentElementType],
            'columnsOverrides/pi_flexform/config/ds',
            $xmlFile
        );
    }
}
