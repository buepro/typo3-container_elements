<?php

/*
 * This file is part of the composer package buepro/typo3-container-elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Buepro\ContainerElements\Tests\Functional\Templates\General;

use Buepro\ContainerElements\Tests\Functional\FunctionalFrontendTestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class AccordionTest extends FunctionalFrontendTestCase
{
    use ProphecyTrait;

    protected const ACCORDION_UID = 31;
    protected const ACCORDION_PID = 5;

    /**
     * @var non-empty-string[]
     */
    protected array $coreExtensionsToLoad = [
        'impexp',
        'seo',
        'felogin',
    ];

    /**
     * @var non-empty-string[]
     */
    protected array $testExtensionsToLoad = [
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
        foreach (['be_users', 'pages', 'sys_template', 'tt_content'] as $table) {
            $this->importCSVDataSet(sprintf(
                '%s%s%d/db_table_%s.csv',
                ORIGINAL_ROOT,
                'typo3conf/ext/container_elements/Tests/Functional/Templates/Fixtures/Db',
                VersionNumberUtility::convertVersionStringToArray(
                    VersionNumberUtility::getNumericTypo3Version()
                )['version_main'],
                $table
            ));
        }
        $this->setUpFrontendSite(1);
        $this->setupFrontendController(self::ACCORDION_PID);
        $this->setUpBackendUser(2);
        Bootstrap::initializeLanguageObject();
        $this->dbConnection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('tt_content');
    }

    private function setActiveIndex(int $index): void
    {
        $piFlexform = $this->dbConnection
            ->select(['pi_flexform'], 'tt_content', ['uid' => self::ACCORDION_UID])
            ->fetchOne();
        if (!is_string($piFlexform)) {
            throw new \LogicException('Obtained flexform is not valid', 1660322366);
        }
        $piFlexform = preg_replace(
            "/<field index='activeItemIndex'>\n[\t\s]*<value index='vDEF'>(.)<\/value>\n[\t\s]*<\/field>/",
            "<field index='activeItemIndex'><value index='vDEF'>" . $index . '</value></field>',
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
                $result[] = (int)$key + 1;
            }
        }
        return $result;
    }

    public function activeItemIndexDataProvider(): array
    {
        return [
            'all inactive' => [0, []],
            'first active' => [1, [1]],
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
        self::assertSame($expected, $this->getActiveIndexesFromHtml());

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
        if (!is_string($piFlexform)) {
            throw new \LogicException('Obtained flexform is not valid', 1660322366);
        }
        $piFlexform = preg_replace(
            '/<field index="activeItemIndex">\n*\t*<value index="vDEF">\w*(.)\w*<\/value>\n*\t*<\/field>/',
            '',
            $piFlexform
        );
        $this->dbConnection->update('tt_content', ['pi_flexform' => $piFlexform], ['uid' => self::ACCORDION_UID]);
        self::assertSame([1], $this->getActiveIndexesFromHtml());

        $this->dbConnection->update(
            'tt_content',
            ['pi_flexform' => $originalPiFlexform],
            ['uid' => self::ACCORDION_UID]
        );
    }
}
