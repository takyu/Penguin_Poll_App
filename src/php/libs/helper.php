<?php
declare(strict_types=1);

use lib\Msg;

function get_param(
    string $key,
    string $default_val,
    bool $is_post = true
): string {
    $arry = $is_post ? $_POST : $_GET;
    return $arry[$key] ?? $default_val;
}

function redirect($path): void
{
    if ($path === GO_HOME) {
        $path = get_url('');
    } elseif ($path === GO_REFERER) {
        $path = $_SERVER['HTTP_REFERER'];
    } else {
        $path = get_url($path);
    }

    header("Location: {$path}");
    die();
}

function the_url($path): void
{
    echo get_url($path);
}

function get_url($path): string
{
    return BASE_CONTEXT_PATH . trim($path, '/');
}

function set_class_alert($type) {
  switch ($type) {
      case Msg::INFO:
          return 'alert-primary';
          break;
      case Msg::ERROR:
          return 'alert-danger';
          break;
      case Msg::DEBUG:
          return 'alert-warning';
          break;
  }
}

/**
 * format check function
 *
 * @return bool
 */
function is_alnum($val): int|false
{
    return preg_match("/^[a-zA-Z0-9]+$/", $val);
}

function is_alnum_and_more_one_capital_alpha($val): int|false
{
    return preg_match("/^(?=.*[A-Z])[a-zA-Z0-9]+$/", $val);
}
