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
