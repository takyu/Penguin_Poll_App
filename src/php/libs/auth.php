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
        try {
            if (
                !(UserModel::validate_id($id) * UserModel::validate_pwd($pwd))
            ) {
                return false;
            }

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
        } catch (\Throwable $th) {
            //throw $th;
            $is_success = false;
            Msg::push(Msg::DEBUG, $th->getMessage());
            Msg::push(
                Msg::ERROR,
                "In the login process, an error has occurred.\nPlease give it some time and then try to access it again."
            );
        }
        return $is_success;
    }

    public static function regist(object $user): bool
    {
        try {
            if (
                /**
                 * If all the checks are done and any one of them returns false,
                 * the result of the operation is zero because it is multiplication,
                 * and it is true by the negation operator.
                 */
                !(
                    $user->is_valid_id() *
                    $user->is_valid_pwd() *
                    $user->is_valid_nickname()
                )
            ) {
                return false;
            }

            $is_success = false;

            // Check if the user is already registered
            $exist_user = UserQuery::fetch_by_id($user->id);
            if (!empty($exist_user)) {
                echo 'The user already exists';
                return false;
            }

            $is_success = UserQuery::insert($user);

            if ($is_success) {
                UserModel::set_session($user);
            }
        } catch (\Throwable $th) {
            $is_success = false;
            Msg::push(Msg::DEBUG, $th->getMessage());
            Msg::push(
                Msg::ERROR,
                "In the regist process, an error has occurred.\nPlease give it some time and then try to access it again."
            );
        }
        return $is_success;
    }

    public static function is_login(): bool
    {
        try {
            $user = UserModel::get_session();
        } catch (\Throwable $th) {
            /**
             * Clear the login information for errors in get_session.
             */
            UserModel::clear_session();

            Msg::push(Msg::DEBUG, $th->getMessage());
            Msg::push(
                Msg::ERROR,
                "An error has occurred.\nPlease login again."
            );
            return false;
        }
        if (isset($user)) {
            return true;
        } else {
            return false;
        }
    }
}
