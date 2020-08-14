<?php

/*
 * This file is part of the package buepro/container_elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Buepro\ContainerElements\Hooks;

use TYPO3\CMS\Backend\Form\FormDataCompiler;
use TYPO3\CMS\Backend\Form\FormDataGroup\TcaDatabaseRecord;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class DataHandlerHook
{
    /**
     * Set default flex form values.
     *
     * ATTENTION: Other extensions like `gridelements` might overwrite it in case their hooks are called after this one.
     * (the hook sequence depends on the extension installation order. This extension might be installed as last one.)
     *
     * @param array $incomingFieldArray
     * @param string $table
     * @param string $id
     * @param DataHandler $dataHandler
     */
    public function processDatamap_preProcessFieldArray(
        &$incomingFieldArray,
        $table,
        $id,
        DataHandler $dataHandler
    ): void {
        $cTypes = [
            'ce_container',
            'ce_columns2',
            'ce_columns3',
            'ce_columns4',
            'ce_tabs',
            'ce_accordion',
            'ce_tile_unit',
            'ce_card'
        ];
        if (is_string($id) && false !== strpos($id, 'NEW') && !isset($incomingFieldArray['pi_flexform'])
            && in_array($incomingFieldArray['CType'], $cTypes, true)) {
            // Get default pi_flexform value
            $formDataGroup = GeneralUtility::makeInstance(TcaDatabaseRecord::class);
            $formDataCompiler = GeneralUtility::makeInstance(FormDataCompiler::class, $formDataGroup);
            $formDataCompilerInput = [
                'command' => 'new',
                'tableName' => 'tt_content',
                'vanillaUid' => $incomingFieldArray['pid'],
                'defaultValues' => [
                    'tt_content' => [
                        'CType' => $incomingFieldArray['CType'],
                    ],
                ],
            ];
            $formData = $formDataCompiler->compile($formDataCompilerInput);
            $incomingFieldArray['pi_flexform'] = $formData['databaseRow']['pi_flexform'];
        }
    }
}
