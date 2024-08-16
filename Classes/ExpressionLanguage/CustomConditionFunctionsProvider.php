<?php
declare(strict_types = 1);

/*
 * This file is part of the composer package buepro/typo3-container-elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Buepro\ContainerElements\ExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

class CustomConditionFunctionsProvider implements ExpressionFunctionProviderInterface
{

    /**
     * @inheritDoc
     */
    public function getFunctions(): array
    {
        return [
            $this->getExtensionConfiguration(),
        ];
    }

    protected function getExtensionConfiguration(): ExpressionFunction
    {
        return new ExpressionFunction(
            'ceExtensionConfiguration',
            static fn () => null,
            static function ($arguments, $constantKey) {
                $extensionConfiguration = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                    \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class
                );
                $containerElementsConfiguration = $extensionConfiguration->get('container_elements');
                if (!is_array($containerElementsConfiguration)) {
                    return false;
                }
                return $containerElementsConfiguration[$constantKey] ?? false;
            }
        );
    }
}
