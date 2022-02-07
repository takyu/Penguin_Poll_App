<?php
declare(strict_types=1);

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

function get_url($path): string
{
    return BASE_CONTEXT_PATH . trim($path, '/');
}
