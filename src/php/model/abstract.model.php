<?php
declare(strict_types=1);

namespace model;

abstract class AbstractModel
{
    protected static string|null $SESSION_NAME = null;

    public static function set_session($val): void
    {
        if (empty(static::$SESSION_NAME)) {
            throw new Error('Error: Specify $SESSION_NAME.');
        }
        $_SESSION[static::$SESSION_NAME] = $val;
    }

    public static function get_session(): object|null
    {
        return $_SESSION[static::$SESSION_NAME] ?? null;
    }

    public static function clear_session(): void
    {
        static::set_session(null);
    }
}
