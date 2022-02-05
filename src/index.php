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
require_once SOURCE_BASE . '/model/user.model.php';

/**
 * db
 */
require_once SOURCE_BASE . '/db/datasource.php';
require_once SOURCE_BASE . '/db/setdb.env.php';
require_once SOURCE_BASE . '/db/user.query.php';

/**
 * partials
 */
require_once SOURCE_BASE . '/partials/header.php';
require_once SOURCE_BASE . '/partials/footer.php';

// confirm object about user
use db\UserQuery;
$res = UserQuery::fetch_by_id('pensan');
var_dump($res);

$rpath = str_replace(BASE_CONTEXT_PATH, '', $_SERVER['REQUEST_URI']);
$method = strtolower($_SERVER['REQUEST_METHOD']);

route($rpath, $method);

function route(String $rpath, String $method): void {
  if ($rpath === '') {
    $rpath = 'home';
  }
  
  $targetFile = SOURCE_BASE . "/controllers/{$rpath}.php";
  
  if (!file_exists($targetFile)) {
    require_once SOURCE_BASE . "/views/404.php";
    return;
  }

  require_once $targetFile;

  // Use namespace (\<-escape)\{namespace}(\<-escape)\{$rpath}(\<-escape)\{$method}
  $fn = "\\controller\\{$rpath}\\{$method}";

  // Execute function
  $fn();
}
?>
