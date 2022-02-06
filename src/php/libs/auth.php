<?php
declare(strict_types=1);

namespace lib;

use Dotenv\Dotenv;
use db\DataSource;
use db\UserQuery;

class Auth
{
    public static function db_login()
    {
        $dotenv = Dotenv::createImmutable(
            __DIR__ . '/../../../',
            'db_auth.env'
        );
        $dotenv->load();
        return new DataSource(
            $_ENV['DB_HOST'],
            $_ENV['DB_PORT'],
            $_ENV['DB_NAME'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASS']
        );
    }

    public static function login(string $id, string $pwd): bool
    {
        $is_success = false;

        $user = UserQuery::fetch_by_id($id);

        if (!empty($user) && $user->del_flg !== 1) {
            if (password_verify($pwd, $user->pwd)) {
                $is_success = true;
                $_SESSION['user'] = $user;
            } else {
                echo 'Password does not match.';
            }
        } else {
            echo 'User does not find.';
        }

        return $is_success;
    }

    public static function regist(
        string $id,
        string $pwd,
        string $nickname
    ): bool {
        $is_success = false;

        // Check if the user is already registered
        $exist_user = UserQuery::fetch_by_id($id);
        if (!empty($exist_user)) {
            echo 'The user already exists';
            return false;
        }

        $is_success = UserQuery::insert($id, $pwd, $nickname);
        return $is_success;
    }
}
