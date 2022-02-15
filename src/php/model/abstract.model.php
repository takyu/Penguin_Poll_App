<?php
declare(strict_types=1);

namespace model;

abstract class AbstractModel
{
    protected static string|null $SESSION_NAME = null;

    public static function setSession(mixed $val): void
    {
        if (empty(static::$SESSION_NAME)) {
            throw new Error('Error: Specify $SESSION_NAME.');
        }
        $_SESSION[static::$SESSION_NAME] = $val;
    }

    public static function getSession(): object|array|null
    {
        return $_SESSION[static::$SESSION_NAME] ?? null;
    }

    public static function clearSession(): void
    {
        static::setSession(null);
    }

    public static function getSesssionAndFlush(): object|array|null
    {
        try {
            return static::getSession();
        } catch (\Throwable $th) {
            throw $th;
        } finally {
            static::clearSession();
        }
    }
}
