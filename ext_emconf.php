<?php

/*
 * This file is part of the composer package buepro/typo3-container-elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$EM_CONF[$_EXTKEY] = [
    'title'            => 'Container elements',
    'description'      => 'Provides content elements powered by container and bootstrap. Available elements: container, columns, grid, tabs, accordion, tile unit, card, randomizer and slider.',
    'category'         => 'misc',
    'version'          => '6.0.0-dev',
    'state'            => 'stable',
    'clearCacheOnLoad' => 1,
    'author'           => 'Roman Büchler',
    'author_email'     => 'rb@buechler.pro',
    'constraints'      => [
        'depends'   => [
            'typo3'         => '12.4.22-13.99.99',
            'container'     => '3.0.0-3.99.99',
            'pvh'           => '3.0.0-3.99.99'
        ],
        'conflicts' => [
            'pizpalue'      => '0.0.0-16.99.99'
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Buepro\\ContainerElements\\' => 'Classes'
        ],
    ],
];
