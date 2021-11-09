<?php

/*
 * This file is part of the composer package buepro/typo3-container-elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Buepro\ContainerElements\Tests\Functional;

use Symfony\Component\Yaml\Yaml;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Routing\PageArguments;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class FunctionalFrontendTestCase extends FunctionalTestCase
{
    protected function setUpFrontendSite(int $pageId = 1, array $additionalLanguages = []): void
    {
        $languages = [
            0 => [
                'title' => 'English',
                'enabled' => true,
                'languageId' => 0,
                'base' => '/',
                'typo3Language' => 'default',
                'locale' => 'en_US.UTF-8',
                'iso-639-1' => 'en',
                'navigationTitle' => '',
                'hreflang' => '',
                'direction' => '',
                'flag' => 'us',
            ]
        ];
        $languages = array_merge($languages, $additionalLanguages);
        $configuration = [
            'rootPageId' => $pageId,
            'base' => '/',
            'languages' => $languages,
            'errorHandling' => [],
            'routes' => [],
        ];
        GeneralUtility::mkdir_deep($this->instancePath . '/typo3conf/sites/testing/');
        $yamlFileContents = Yaml::dump($configuration, 99, 2);
        $fileName = $this->instancePath . '/typo3conf/sites/testing/config.yaml';
        GeneralUtility::writeFile($fileName, $yamlFileContents);
        // Ensure that no other site configuration was cached before
        $cache = GeneralUtility::makeInstance(CacheManager::class)->getCache('core');
        if ($cache->has('sites-configuration')) {
            $cache->remove('sites-configuration');
        }
    }

    /**
     * Basically create the global variable $GLOBALS['TSFE'] which holds the front end controller.
     *
     * @throws \TYPO3\CMS\Core\Error\Http\InternalServerErrorException
     * @throws \TYPO3\CMS\Core\Error\Http\ServiceUnavailableException
     * @throws \TYPO3\CMS\Core\Exception\SiteNotFoundException
     * @see /typo3/sysext/frontend/Configuration/RequestMiddlewares.php
     * @see \TYPO3\CMS\Frontend\Middleware\FrontendUserAuthenticator
     * @see \TYPO3\CMS\Frontend\Middleware\TypoScriptFrontendInitialization
     * @see \TYPO3\CMS\Frontend\Middleware\PrepareTypoScriptFrontendRendering
     */
    protected function setupFrontendController(int $pageUid = 3): void
    {
        // $GLOBALS['TYPO3_REQUEST'] is required in the frontend controller
        $request = (new ServerRequest())
            ->withAttribute('applicationType', SystemEnvironmentBuilder::REQUESTTYPE_FE)
            ->withQueryParams(['id' => $pageUid]);
        $frontendUser = GeneralUtility::makeInstance(FrontendUserAuthentication::class);
        $request = $request->withAttribute('frontend.user', $frontendUser);
        $GLOBALS['TYPO3_REQUEST'] = $request;

        /** @var Context $context */
        $context = GeneralUtility::makeInstance(Context::class);
        /** @var Site $site */
        $site = (GeneralUtility::makeInstance(\TYPO3\CMS\Core\Site\SiteFinder::class))->getSiteByPageId(1);
        $type = 0;
        if (is_array($parsedBody = $request->getParsedBody()) && isset($parsedBody['type'])) {
            $type = $parsedBody['type'];
        }
        if (isset($request->getQueryParams()['type']) && (bool)$request->getQueryParams()['type']) {
            $type = $request->getQueryParams()['type'];
        }
        $pageArguments = $request->getAttribute('routing', new PageArguments($pageUid, (string)$type, []));
        $controller = GeneralUtility::makeInstance(
            TypoScriptFrontendController::class,
            $context,
            $site,
            $site->getDefaultLanguage(),
            $pageArguments,
            $request->getAttribute('frontend.user', null)
        );
        $controller->determineId($request);
        $controller->getConfigArray($request);
        $GLOBALS['TSFE'] = $controller;
    }
}
