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

class SliderProcessor implements DataProcessorInterface
{
    use ProcessedDataTrait;

    /**
     * Add the json encoded slider config and the field `ce_slide_classes` to the child data, which contains the
     * resulting css class for the slide.
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
        if (
            !$this->isContainerElement($processedData) ||
            !isset($processedData['children_101']) ||
            count($processedData['children_101']) < 1
        ) {
            return $processedData;
        }
        $processedData = $this->setClassesForChildren($processedData);
        return $this->setSliderConfig($processedData);
    }

    private function setClassesForChildren(array $processedData): array
    {
        $config = array_merge([
            'slideDefaultClasses' => 'ce-slide swiper-slide',
            'slideClasses' => '',
        ], $processedData['data']['pi_flexform'] ?? []);
        $slideClasses = GeneralUtility::trimExplode(',', str_replace(["\r\n", "\n", "\r"], ',', $config['slideClasses']));
        foreach ($processedData['children_101'] as $key => &$child) {
            $child['ce_slide_classes'] = $config['slideDefaultClasses'];
            if (isset($slideClasses[$key]) && $slideClasses[$key] !== '') {
                $child['ce_slide_classes'] = $slideClasses[$key];
            }
        }
        unset($child);
        return $processedData;
    }

    private function setSliderConfig(array $processedData): array
    {
        $config = $processedData['data']['pi_flexform']['config'] ?? '{}';
        try {
            $decoded = json_decode($config, true, 512, JSON_THROW_ON_ERROR);
            $config = json_encode($decoded, JSON_FORCE_OBJECT);
        } catch (\JsonException $e) {
            $config = '{}';
        }
        $processedData['data']['pi_flexform']['config'] = $config;
        return $processedData;
    }
}
