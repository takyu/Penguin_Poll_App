<?php 
declare(strict_types=1); 

require_once 'php/config.php';

/**
 * partials
 */
require_once SOURCE_BASE . '/partials/header.php';
require_once SOURCE_BASE . '/partials/footer.php';

$rpath = str_replace(BASE_CONTEXT_PATH, '', $_SERVER['REQUEST_URI']);
$method = strtolower($_SERVER['REQUEST_METHOD']);
// echo $method;

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

// if ($_SERVER['REQUEST_URI'] === '/penguin_pollapp/src/login') {
//   require_once SOURCE_BASE . '/controllers/login.php';
// } elseif ($_SERVER['REQUEST_URI'] === '/penguin_pollapp/src/register') {
//   require_once SOURCE_BASE . '/controllers/register.php';
// } elseif ($_SERVER['REQUEST_URI'] === '/penguin_pollapp/src/') {
//   require_once SOURCE_BASE . '/controllers/home.php';
// }
?>
