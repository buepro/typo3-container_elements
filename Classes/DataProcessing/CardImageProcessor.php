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

class CardImageProcessor extends \TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
{
    use ProcessedDataTrait;

    /**
     * Process data of a record to resolve File objects to the view
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
        if (!$this->isContainerElement($processedData)) {
            return $processedData;
        }
        /** @extensionScannerIgnoreLine */
        $data = $cObj->data;
        /** @extensionScannerIgnoreLine */
        $cObj->data['flexform_imageReference'] = $processedData['data']['pi_flexform']['flexform_imageReference'] ?? null;
        /** @extensionScannerIgnoreLine */
        $result = parent::process($cObj, $contentObjectConfiguration, $processorConfiguration, $processedData);
        /** @extensionScannerIgnoreLine */
        $cObj->data = $data;
        return $result;
    }
}
