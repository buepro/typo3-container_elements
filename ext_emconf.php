<?php

/*
 * This file is part of the package buepro/container_elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$EM_CONF[$_EXTKEY] = [
    'title'            => 'Container elements',
    'description'      => 'Provides content elements powered by container and bootstrap. Available elements: container, columns, tabs, accordion, tile unit and card.',
    'category'         => 'misc',
    'version'          => '2.1.0',
    'state'            => 'stable',
    'clearCacheOnLoad' => 1,
    'author'           => 'Roman Büchler',
    'author_email'     => 'rb@buechler.pro',
    'constraints'      => [
        'depends'   => [
            'typo3'         => '10.4.11-10.4.99',
            'container'     => '1.3.0-1.99.99',
            'vhs'           => '6.0.0-6.99.99',
        ],
        'conflicts' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'Buepro\\ContainerElements\\' => 'Classes'
        ],
    ],
];
