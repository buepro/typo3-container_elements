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
    'version'          => '3.1.1-dev',
    'state'            => 'stable',
    'clearCacheOnLoad' => 1,
    'author'           => 'Roman Büchler',
    'author_email'     => 'rb@buechler.pro',
    'constraints'      => [
        'depends'   => [
            'php'           => '7.3.0-8.0.99',
            'typo3'         => '10.4.11-11.5.99',
            'container'     => '1.3.1-1.99.99',
            'pvh'           => '1.0.0-1.99.99'
        ],
        'conflicts' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'Buepro\\ContainerElements\\' => 'Classes'
        ],
    ],
];
