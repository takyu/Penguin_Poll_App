<?php
declare(strict_types=1);

namespace lib;

use Dotenv\Dotenv;
use db\DataSource;
use db\UserQuery;
use model\UserModel;

class Auth
{
    public static function db_login(): object
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

        if (!empty($user) && $user->del_flg !== DEL_FLAG) {
            if (password_verify($pwd, $user->pwd)) {
                $is_success = true;
                UserModel::set_session($user);
            } else {
                echo 'Password does not match.';
            }
        } else {
            echo 'User does not find.';
        }

        return $is_success;
    }

    public static function regist($user): bool
    {
        $is_success = false;

        // Check if the user is already registered
        $exist_user = UserQuery::fetch_by_id($user->id);
        if (!empty($exist_user)) {
            echo 'The user already exists';
            return false;
        }

        $is_success = UserQuery::insert($user);

        // Save user authentication in session

        if ($is_success) {
            UserModel::set_session($user);
        }

        return $is_success;
    }

    public static function is_login(): bool {
      $user = UserModel::get_session();

      if (isset($user)) {
        return true;
      } else {
        return false;
      }
    }
}
