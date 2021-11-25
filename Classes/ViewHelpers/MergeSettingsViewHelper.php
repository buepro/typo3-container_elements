<?php
declare(strict_types = 1);

/*
 * This file is part of the composer package buepro/typo3-container-elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Buepro\ContainerElements\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Merges an array to `settings.containerElements`
 */
class MergeSettingsViewHelper extends AbstractViewHelper
{
    /**
     * @var bool
     */
    protected $escapeChildren = false;

    /**
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('value', 'array', 'Value to be merged to `settings.containerElements`');
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): string {
        $value = $renderChildrenClosure();
        $variableProvider = $renderingContext->getVariableProvider();
        $settings = $variableProvider->get('settings');
        if (!is_array($value) || !is_array($settings) || !isset($settings['containerElements'])) {
            return '';
        }
        $settings['containerElements'] = array_replace_recursive($settings['containerElements'], $value);
        // Note: re-insert the variable to ensure unreferenced values like arrays also get updated
        $variableProvider->remove('settings');
        $variableProvider->add('settings', $settings);
        return '';
    }
}
