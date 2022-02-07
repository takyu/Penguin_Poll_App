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

/**
 * partials
 */
// require_once SOURCE_BASE . '/partials/header.php';
// require_once SOURCE_BASE . '/partials/footer.php';

/**
 *
 * To save the object of $user to the session in login.php.
 * Load the class (user.model.php) that will be the template for the object,
 * and then start the session.
 *
 */
session_start();

use function lib\route;

try {
    require_once SOURCE_BASE . '/partials/header.php';

    $rpath = str_replace(BASE_CONTEXT_PATH, '', CURRENT_URI);
    $method = strtolower($_SERVER['REQUEST_METHOD']);
    
    route($rpath, $method);

    require_once SOURCE_BASE . '/partials/footer.php';
} catch (\Throwable $th) {
    die('<h1>What?? An error has occured in index.php</h1>');
}
