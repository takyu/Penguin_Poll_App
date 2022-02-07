<?php
declare(strict_types=1);

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
require_once SOURCE_BASE . '/libs/message.php';
require_once SOURCE_BASE . '/libs/auth.php';

/**
 * db
 */
require_once SOURCE_BASE . '/db/datasource.php';
require_once SOURCE_BASE . '/db/user.query.php';

/**
 *
 * To save the object of $user to the session in login.php.
 * Load the class (user.model.php) that will be the template for the object,
 * and then start the session.
 *
 */
session_start();

/**
 * partials
 */
require_once SOURCE_BASE . '/partials/header.php';
require_once SOURCE_BASE . '/partials/footer.php';

// confirm object about user
// use db\UserQuery;
// $res = UserQuery::fetch_by_id('pensan');
// var_dump($res);

$rpath = str_replace(BASE_CONTEXT_PATH, '', CURRENT_URI);
$method = strtolower($_SERVER['REQUEST_METHOD']);

route($rpath, $method);

function route(string $rpath, string $method): void
{
    if ($rpath === '') {
        $rpath = 'home';
    }

    $targetFile = SOURCE_BASE . "/controllers/{$rpath}.php";

    if (!file_exists($targetFile)) {
        require_once SOURCE_BASE . '/views/404.php';
        return;
    }

    require_once $targetFile;

    // Use namespace (\<-escape)\{namespace}(\<-escape)\{$rpath}(\<-escape)\{$method}
    $fn = "\\controller\\{$rpath}\\{$method}";

    // Execute function
    $fn();
}
?>
