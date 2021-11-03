<?php
declare(strict_types = 1);

/*
 * This file is part of the composer package buepro/typo3-container-elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Buepro\ContainerElements\DataProcessing;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Extracts information from the processor context and assigns it to `ceInfo`. The following properties are available:
 * - childrenCount
 *
 * The default variable name assignment might be adjusted:
 *
 * 10 = Buepro\ContainerElements\DataProcessing\InfoProcessor
 * 10.as = ceInfo
 */
class InfoProcessor implements \TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface
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
            $variableName = 'ceInfo';
        }
        $children = array_filter($processedData, static function (string $key): bool {
            return strpos($key, 'children_') !== false;
        }, ARRAY_FILTER_USE_KEY);
        $info = ['childrenCount' => count($children)];
        $processedData[$variableName] = $info;
        return $processedData;
    }
}
