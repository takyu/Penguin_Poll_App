<?php 
require_once 'php/config.php';
// echo $_SERVER['REQUEST_URI'];

/**
 * partials
 */
require_once 'php/partials/header.php';
require_once 'php/partials/footer.php';


if ($_SERVER['REQUEST_URI'] === '/penguin_pollapp/src/login') {
  require_once 'php/views/login.php';
} elseif ($_SERVER['REQUEST_URI'] === '/penguin_pollapp/src/register') {
  require_once 'php/views/register.php';
} elseif ($_SERVER['REQUEST_URI'] === '/penguin_pollapp/src/') {
  require_once 'php/views/home.php';
}
?>
