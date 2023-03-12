<?php

/**
 * Private phpMyFAQ Admin API: handling of Ajax search calls.
 *
 * This Source Code Form is subject to the terms of the Mozilla Public License,
 * v. 2.0. If a copy of the MPL was not distributed with this file, You can
 * obtain one at https://mozilla.org/MPL/2.0/.
 *
 * @package   phpMyFAQ
 * @author    Thorsten Rinne <thorsten@phpmyfaq.de>
 * @copyright 2011-2023 phpMyFAQ Team
 * @license   https://www.mozilla.org/MPL/2.0/ Mozilla Public License Version 2.0
 * @link      https://www.phpmyfaq.de
 * @since     2011-08-24
 */

use phpMyFAQ\Filter;
use phpMyFAQ\Helper\HttpHelper;
use phpMyFAQ\Search;
use phpMyFAQ\Session\Token;
use phpMyFAQ\Translation;

if (!defined('IS_VALID_PHPMYFAQ')) {
    http_response_code(400);
    exit();
}

$ajaxAction = Filter::filterInput(INPUT_GET, 'ajaxaction', FILTER_SANITIZE_SPECIAL_CHARS);

$search = new Search($faqConfig);
$http = new HttpHelper();
$http->setContentType('application/json');
$http->addHeader();

if ($ajaxAction === 'delete_searchterm') {
    $deleteData = json_decode(file_get_contents('php://input', true));

    if (!Token::getInstance()->verifyToken('delete-searchterms', $deleteData->csrf)) {
        $http->setStatus(400);
        $http->sendJsonWithHeaders(['error' => Translation::get('err_NotAuth')]);
        exit(1);
    }

    $searchId = Filter::filterVar($deleteData->searchTermId, FILTER_VALIDATE_INT);

    if ($search->deleteSearchTermById($searchId)) {
        $http->setStatus(200);
        $http->sendJsonWithHeaders(['deleted' => $searchId]);
    } else {
        $http->setStatus(400);
        $http->sendJsonWithHeaders(['error' => $searchId]);
    }
}
