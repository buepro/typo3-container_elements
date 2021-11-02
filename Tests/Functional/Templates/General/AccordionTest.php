<?php

/*
 * This file is part of the composer package buepro/typo3-container-elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Buepro\ContainerElements\Tests\Functional\Templates\General;

use Buepro\ContainerElements\Tests\Functional\FunctionalFrontendTestCase;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class AccordionTest extends FunctionalFrontendTestCase
{
    protected const ACCORDION_UID = 31;
    protected const ACCORDION_PID = 5;

    /**
     * @var string[]
     */
    protected $coreExtensionsToLoad = [
        'impexp',
        'seo',
        'felogin',
    ];

    /**
     * @var string[]
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/vhs',
        'typo3conf/ext/container',
        'typo3conf/ext/container_elements',
        'typo3conf/ext/bootstrap_package',
        'typo3conf/ext/pizpalue',
    ];

    /**
     * @var Connection
     */
    protected $dbConnection;

    /**
     * Sets up this test case.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->importDataSet(
            ORIGINAL_ROOT .
            'typo3conf/ext/container_elements/Tests/Functional/Templates/Fixtures/db.xml'
        );
        $this->setUpFrontendSite(1);
        $this->setupFrontendController(self::ACCORDION_PID);
        $this->dbConnection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('tt_content');
    }

    private function setActiveIndex(int $index): void
    {
        $piFlexform = $this->dbConnection
            ->select(['pi_flexform'], 'tt_content', ['uid' => self::ACCORDION_UID])
            ->fetchOne();
        $piFlexform = preg_replace(
            '/<field index="activeItemIndex">\n*\t*<value index="vDEF">\w*(.)\w*<\/value>\n*\t*<\/field>/',
            '<field index="activeItemIndex"><value index="vDEF">' . $index . '</value></field>',
            $piFlexform
        );
        $this->dbConnection->update('tt_content', ['pi_flexform' => $piFlexform], ['uid' => self::ACCORDION_UID]);
    }

    private function getActiveIndexesFromHtml(): array
    {
        $result = [];
        $contentObjectRenderer = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        $html = $contentObjectRenderer->cObjGetSingle('CONTENT', [
            'table' => 'tt_content',
            'select.' => [
                'pidInList' => self::ACCORDION_PID,
                'uidInList' => self::ACCORDION_UID,
            ],
        ]);
        if (preg_match_all('/"accordion-collapse\s*collapse\s*(\w*)"/', $html, $matches) === false) {
            return [];
        }
        if (isset($matches[1])) {
            $indexKeys = array_keys($matches[1], 'show', true);
            foreach ($indexKeys as $key) {
                $result[] = $key + 1;
            }
        }
        return $result;
    }

    public function activeItemIndexDataProvider(): array
    {
        return [
            'all inactive' => [0, []],
            'first inactive' => [1, [1]],
            'second active' => [2, [2]],
            'not available' => [100, []],
        ];
    }

    /**
     * @dataProvider activeItemIndexDataProvider
     * @test
     */
    public function activeItemIndex(int $index, array $expected): void
    {
        $originalPiFlexform = $this->dbConnection
            ->select(['pi_flexform'], 'tt_content', ['uid' => self::ACCORDION_UID])
            ->fetchOne();

        $this->setActiveIndex($index);
        $this->assertSame($expected, $this->getActiveIndexesFromHtml());

        $this->dbConnection->update(
            'tt_content',
            ['pi_flexform' => $originalPiFlexform],
            ['uid' => self::ACCORDION_UID]
        );
    }

    /**
     * @test
     */
    public function firstItemIsActiveWhenItemActiveIsAbsent(): void
    {
        $originalPiFlexform = $this->dbConnection
            ->select(['pi_flexform'], 'tt_content', ['uid' => self::ACCORDION_UID])
            ->fetchOne();

        $piFlexform = $this->dbConnection
            ->select(['pi_flexform'], 'tt_content', ['uid' => self::ACCORDION_UID])
            ->fetchOne();
        $piFlexform = preg_replace(
            '/<field index="activeItemIndex">\n*\t*<value index="vDEF">\w*(.)\w*<\/value>\n*\t*<\/field>/',
            '',
            $piFlexform
        );
        $this->dbConnection->update('tt_content', ['pi_flexform' => $piFlexform], ['uid' => self::ACCORDION_UID]);
        $this->assertSame([1], $this->getActiveIndexesFromHtml());

        $this->dbConnection->update(
            'tt_content',
            ['pi_flexform' => $originalPiFlexform],
            ['uid' => self::ACCORDION_UID]
        );
    }
}
