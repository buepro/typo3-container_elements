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
        return substr($processedData['data']['CType'] ?? '', 0, 3) === 'ce_';
    }
}
