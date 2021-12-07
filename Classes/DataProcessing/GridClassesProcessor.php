<?php
declare(strict_types = 1);

/*
 * This file is part of the composer package buepro/typo3-container-elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Buepro\ContainerElements\DataProcessing;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

class GridClassesProcessor implements DataProcessorInterface
{
    /**
     * Add the field `ce_grid_classes` to the child data. The field contains the resulting css class for the grid
     * element.
     *
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array the processed data as key/value store
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ): array {
        if (!isset($processedData['children_101']) || count($processedData['children_101']) < 1) {
            return $processedData;
        }
        $config = $processedData['data']['pi_flexform'] ?? null;
        if (!is_array($config)) {
            $config = [
                'elementDefaultClasses' => 'col',
                'elementClasses' => '',
            ];
        }
        $elementClasses = GeneralUtility::trimExplode(',', str_replace(["\r\n", "\n", "\r"], ',', $config['elementClasses']));
        foreach ($processedData['children_101'] as $key => &$child) {
            $child['ce_grid_classes'] = $config['elementDefaultClasses'];
            if (isset($elementClasses[$key]) && $elementClasses[$key] !== '') {
                $child['ce_grid_classes'] = $elementClasses[$key];
            }
        }
        unset($child);
        return $processedData;
    }
}
