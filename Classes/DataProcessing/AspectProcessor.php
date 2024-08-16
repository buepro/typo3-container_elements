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
    use ProcessedDataTrait;

    /**
     * @inheritDoc
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ): array {
        if (!$this->isContainerElement($processedData)) {
            return $processedData;
        }
        $variableName = $cObj->stdWrapValue('as', $processorConfiguration);
        if ($variableName === '') {
            $variableName = 'ceAspect';
        }
        $childrenCount = $this->getChildrenCount($processedData);
        $processedData[$variableName] = [
            'childrenCount' => $childrenCount,
            'pizpalueMainVersion' => $this->getPizpalueMainVersion(),
        ];
        if ($this->isColumnElement($processedData)) {
            $renderEmptyColumns = $this->renderEmptyColumns();
            $columnCount = $childrenCount;
            if ($renderEmptyColumns) {
                $columnCount = (int)substr($processedData['data']['CType'] ?? '', 10, 1);
            }
            $processedData[$variableName]['columnCount'] = $columnCount;
            $processedData[$variableName]['renderEmptyColumns'] = $renderEmptyColumns;
        }
        return $processedData;
    }

    private function getChildrenCount(array $processedData): int
    {
        $childrenContentElements = array_filter($processedData, static function (string $key): bool {
            return strpos($key, 'children_') !== false;
        }, ARRAY_FILTER_USE_KEY);
        return count($childrenContentElements);
    }

    private function renderEmptyColumns(): bool
    {
        $extensionConfiguration = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class
        );
        $config = $extensionConfiguration->get('container_elements');
        if (!is_array($config)) {
            return false;
        }
        return (bool)($config['renderEmptyColumns'] ?? false);
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
            if (strpos($result, 'dev') === false) {
                $version = VersionNumberUtility::convertVersionStringToArray(str_replace('v', '', $result));
                $result = $version['version_main'] ?? 0;
            }
        }
        return $result;
    }
}
