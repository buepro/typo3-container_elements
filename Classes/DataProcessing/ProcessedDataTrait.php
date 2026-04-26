<?php declare(strict_types=1);

/*
 * This file is part of the composer package buepro/typo3-container-elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Buepro\ContainerElements\DataProcessing;

trait ProcessedDataTrait
{
    protected function isContainerElement(array $processedData): bool
    {
        return substr($this->getCType($processedData), 0, 3) === 'ce_';
    }

    protected function isColumnElement(array $processedData): bool
    {
        return substr($this->getCType($processedData), 0, 10) === 'ce_columns';
    }

    private function getCType(array $processedData): string
    {
        if (!is_array($processedData['data']) || !isset($processedData['data']['CType']) || !is_string($processedData['data']['CType'])) {
            return '';
        }
        return $processedData['data']['CType'];
    }
}
