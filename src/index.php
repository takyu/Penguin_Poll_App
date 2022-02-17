<?php
declare(strict_types=1);

/**
 * Config file (define constant variable)
 */
require_once 'php/config.php';

/**
 * dotenv
 */
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * model
 */
require_once SOURCE_BASE . '/model/abstract.model.php';
require_once SOURCE_BASE . '/model/user.model.php';
require_once SOURCE_BASE . '/model/topic.model.php';
require_once SOURCE_BASE . '/model/comment.model.php';

/**
 * libs
 */
require_once SOURCE_BASE . '/libs/helper.php';
require_once SOURCE_BASE . '/libs/router.php';
require_once SOURCE_BASE . '/libs/message.php';
require_once SOURCE_BASE . '/libs/auth.php';

/**
 * db
 */
require_once SOURCE_BASE . '/db/datasource.php';
require_once SOURCE_BASE . '/db/user.query.php';
require_once SOURCE_BASE . '/db/topic.query.php';
require_once SOURCE_BASE . '/db/comment.query.php';

/**
 * partials
 */
require_once SOURCE_BASE . '/partials/header.php';
require_once SOURCE_BASE . '/partials/footer.php';
require_once SOURCE_BASE . '/partials/topic-list-item.php';
require_once SOURCE_BASE . '/partials/topic-header-item.php';

/**
 * views
 */
require_once SOURCE_BASE . '/views/home.php';
require_once SOURCE_BASE . '/views/login.php';
require_once SOURCE_BASE . '/views/register.php';
require_once SOURCE_BASE . '/views/topic/archive.php';
require_once SOURCE_BASE . '/views/topic/detail.php';
require_once SOURCE_BASE . '/views/topic/edit.php';

/**
 *
 * To save the object of $user to the session in login.php.
 * Load the class (user.model.php) that will be the template for the object,
 * and then start the session.
 *
 */
session_start();

use function partials\header;
use function partials\footer;
use function lib\route;

try {
    header();

    $url = parse_url(CURRENT_URI);

    $rpath = str_replace(BASE_CONTEXT_PATH, '', $url['path']);
    $method = strtolower($_SERVER['REQUEST_METHOD']);

    route($rpath, $method);

    footer();
} catch (\Throwable $th) {
    die('<h1>予期せぬエラーが発生しました。</h1>');
}
