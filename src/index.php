<?php 
require_once 'php/config.php';

/**
 * partials
 */
require_once SOURCE_BASE . '/partials/header.php';
require_once SOURCE_BASE . '/partials/footer.php';


if ($_SERVER['REQUEST_URI'] === '/penguin_pollapp/src/login') {
  require_once SOURCE_BASE . '/controllers/login.php';
} elseif ($_SERVER['REQUEST_URI'] === '/penguin_pollapp/src/register') {
  require_once SOURCE_BASE . '/controllers/register.php';
} elseif ($_SERVER['REQUEST_URI'] === '/penguin_pollapp/src/') {
  require_once SOURCE_BASE . '/controllers/home.php';
}
?>
