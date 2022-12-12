<?php
declare(strict_types=1);

/*
 * This file is part of the composer package buepro/typo3-container-elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Buepro\ContainerElements\Utility;

class VersionUtility
{
    /**
     * @return int The version in the form Cbbbaaa (e.g. 13000001) or 0 if package is in dev state
     */
    public static function getExtensionVersion(string $extension): int
    {
        return (int)\TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionStringToArray(ltrim(
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getExtensionVersion($extension),
            'vV'
        ))['version_int'];
    }
}
