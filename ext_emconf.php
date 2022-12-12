<?php

/*
 * This file is part of the composer package buepro/typo3-container-elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$EM_CONF[$_EXTKEY] = [
    'title'            => 'Container elements',
    'description'      => 'Provides content elements powered by container and bootstrap. Available elements: container, columns, grid, tabs, accordion, tile unit, card and randomizer.',
    'category'         => 'misc',
    'version'          => '5.0.0-dev',
    'state'            => 'stable',
    'clearCacheOnLoad' => 1,
    'author'           => 'Roman Büchler',
    'author_email'     => 'rb@buechler.pro',
    'constraints'      => [
        'depends'   => [
            'typo3'         => '11.5.1-12.99.99',
            'container'     => '2.1.1-2.99.99',
            'pvh'           => '2.0.0-2.99.99'
        ],
        'conflicts' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'Buepro\\ContainerElements\\' => 'Classes'
        ],
    ],
];
