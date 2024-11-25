<?php

/*
 * This file is part of the composer package buepro/typo3-container-elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

$icons = [
    'Container', 'Columns2', 'Columns3', 'Columns4', 'Tabs', 'Accordion', 'TileUnit', 'Card', 'Randomizer', 'Grid',
    'Slider'
];
$iconsArray = [];
foreach ($icons as $icon) {
    $iconsArray['container-elements-' . strtolower($icon)] = [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:container_elements/Resources/Public/Icons/' . $icon . '.svg',

    ];
}
// Other icons
$icons = ['Frame', 'NoFrame'];
foreach ($icons as $icon) {
    $iconsArray['container-elements-' . strtolower($icon)] = [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:container_elements/Resources/Public/Icons/' . $icon . '.svg',

    ];
}

return $iconsArray;
