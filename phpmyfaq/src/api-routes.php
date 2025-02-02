<?php

/**
 * phpMyFAQ API routes
 *
 * This Source Code Form is subject to the terms of the Mozilla Public License,
 * v. 2.0. If a copy of the MPL was not distributed with this file, You can
 * obtain one at https://mozilla.org/MPL/2.0/.
 *
 * @package   phpMyFAQ
 * @author    Thorsten Rinne <thorsten@phpmyfaq.de>
 * @copyright 2023-2024 phpMyFAQ Team
 * @license   https://www.mozilla.org/MPL/2.0/ Mozilla Public License Version 2.0
 * @link      https://www.phpmyfaq.de
 * @since     2023-07-29
 */

use phpMyFAQ\Controller\Api\AttachmentController;
use phpMyFAQ\Controller\Api\CategoryController;
use phpMyFAQ\Controller\Api\CommentController;
use phpMyFAQ\Controller\Api\GroupController;
use phpMyFAQ\Controller\Api\LanguageController;
use phpMyFAQ\Controller\Api\LoginController;
use phpMyFAQ\Controller\Api\NewsController;
use phpMyFAQ\Controller\Api\OpenQuestionController;
use phpMyFAQ\Controller\Api\SearchController;
use phpMyFAQ\Controller\Api\TagController;
use phpMyFAQ\Controller\Api\TitleController;
use phpMyFAQ\Controller\Api\VersionController;
use phpMyFAQ\Controller\Frontend\AutoCompleteController;
use phpMyFAQ\Controller\Frontend\BookmarkController;
use phpMyFAQ\Controller\Setup\SetupController;
use phpMyFAQ\System;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$apiVersion = System::getApiVersion();

$routes = new RouteCollection();

// Public REST API
$routes->add(
    'api.attachments',
    new Route("v{$apiVersion}/attachments/{recordId}", ['_controller' => [AttachmentController::class, 'list']])
);
$routes->add(
    'api.categories',
    new Route("v{$apiVersion}/categories", ['_controller' => [CategoryController::class, 'list']])
);
$routes->add(
    'api.comments',
    new Route("v{$apiVersion}/comments/{recordId}", ['_controller' => [CommentController::class, 'list']])
);
$routes->add(
    'api.groups',
    new Route("v{$apiVersion}/groups", ['_controller' => [GroupController::class, 'list']])
);
$routes->add(
    'api.language',
    new Route("v{$apiVersion}/language", ['_controller' => [LanguageController::class, 'index']])
);
$routes->add(
    'api.login',
    new Route("v{$apiVersion}/login", ['_controller' => [LoginController::class, 'login'], '_methods' => 'POST'])
);
$routes->add(
    'api.news',
    new Route("v{$apiVersion}/news", ['_controller' => [NewsController::class, 'list']])
);
$routes->add(
    'api.open-questions',
    new Route("v{$apiVersion}/open-questions", ['_controller' => [OpenQuestionController::class, 'list']])
);
$routes->add(
    'api.search',
    new Route("v{$apiVersion}/search", ['_controller' => [SearchController::class, 'search']])
);
$routes->add(
    'api.search.popular',
    new Route("v{$apiVersion}/searches/popular", ['_controller' => [SearchController::class, 'popular']])
);
$routes->add(
    'api.tags',
    new Route("v{$apiVersion}/tags", ['_controller' => [TagController::class, 'list']])
);
$routes->add(
    'api.title',
    new Route("v{$apiVersion}/title", ['_controller' => [TitleController::class, 'index']])
);
$routes->add(
    'api.version',
    new Route("v$apiVersion/version", ['_controller' => [VersionController::class, 'index']])
);

// Private REST API
$routes->add(
    'api.autocomplete',
    new Route('autocomplete', ['_controller' => [AutoCompleteController::class, 'search']])
);
$routes->add(
    'api.bookmark',
    new Route('bookmark/{bookmarkId}', ['_controller' => [BookmarkController::class, 'delete'], '_methods' => 'DELETE'])
);

// Setup REST API
$routes->add(
    'api.setup.check',
    new Route('setup/check', ['_controller' => [SetupController::class, 'check'], '_methods' => 'POST'])
);
$routes->add(
    'api.setup.backup',
    new Route('setup/backup', ['_controller' => [SetupController::class, 'backup'], '_methods' => 'POST'])
);
$routes->add(
    'api.setup.update-database',
    new Route(
        'setup/update-database',
        [
            '_controller' => [ SetupController::class, 'updateDatabase' ],
            '_methods' => 'POST'
        ]
    )
);

return $routes;
