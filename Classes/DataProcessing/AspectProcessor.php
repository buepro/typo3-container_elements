<?php
declare(strict_types = 1);

/*
 * This file is part of the composer package buepro/typo3-container-elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Buepro\ContainerElements\DataProcessing;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Extracts information from the processor context and assigns it to `ceAspect`. The following properties are available:
 * - childrenCount
 * - pizpalueMainVersion
 *
 * The default variable name assignment might be adjusted:
 *
 * 10 = Buepro\ContainerElements\DataProcessing\AspectProcessor
 * 10.as = ceAspect
 */
class AspectProcessor implements \TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface
{
    /**
     * @inheritDoc
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ) {
        $variableName = $cObj->stdWrapValue('as', $processorConfiguration);
        if ($variableName === '') {
            $variableName = 'ceAspect';
        }
        $children = array_filter($processedData, static function (string $key): bool {
            return strpos($key, 'children_') !== false;
        }, ARRAY_FILTER_USE_KEY);

        $processedData[$variableName] = [
            'childrenCount' => count($children),
            'pizpalueMainVersion' => $this->getPizpalueMainVersion(),
        ];
        return $processedData;
    }

    /**
     * @return int|mixed|string
     * @throws \TYPO3\CMS\Core\Package\Exception
     */
    private function getPizpalueMainVersion()
    {
        $result = 0;
        if (ExtensionManagementUtility::isLoaded('pizpalue')) {
            $result = ExtensionManagementUtility::getExtensionVersion('pizpalue');
            if ($result !== 'dev-master') {
                $version = VersionNumberUtility::convertVersionStringToArray(str_replace('v', '', $result));
                $result = $version['version_main'] ?? 0;
            }
        }
        return $result;
    }
}
