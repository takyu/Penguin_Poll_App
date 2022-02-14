<?php
declare(strict_types=1);

namespace lib;

use Dotenv\Dotenv;
use db\DataSource;
use db\TopicQuery;
use db\UserQuery;
use model\UserModel;
use lib\Msg;

class Auth
{
    public static function dbLogin(): object
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
            if (!(UserModel::validateId($id) * UserModel::validatePwd($pwd))) {
                return false;
            }

            $is_success = false;

            $user = UserQuery::fetchById($id);

            if (!empty($user) && $user->del_flg !== DEL_FLAG) {
                if (password_verify($pwd, $user->pwd)) {
                    $is_success = true;
                    UserModel::setSession($user);
                } else {
                    Msg::push(Msg::ERROR, 'パスワードが一致しません。');
                }
            } else {
                Msg::push(Msg::ERROR, 'ユーザーが見つかりません。');
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
                    $user->isValidId() *
                    $user->isValidPwd() *
                    $user->isValidNickname()
                )
            ) {
                return false;
            }

            $is_success = false;

            // Check if the user is already registered
            $exist_user = UserQuery::fetchById($user->id);
            if (!empty($exist_user)) {
                Msg::push(Msg::ERROR, 'ユーザーが既に存在しています。');
                return false;
            }

            $is_success = UserQuery::insert($user);

            if ($is_success) {
                UserModel::setSession($user);
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

    public static function isLogin(): bool
    {
        try {
            $user = UserModel::getSession();
        } catch (\Throwable $th) {
            /**
             * Clear the login information for errors in get_session.
             */
            UserModel::clearSession();

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

    public static function logOut(): bool
    {
        try {
            UserModel::clearSession();
        } catch (\Throwable $th) {
            Msg::push(Msg::DEBUG, $th->getMessage());
            return false;
        }
        return true;
    }

    public static function requireLogin(): void
    {
        if (!static::isLogin()) {
            Msg::push(Msg::ERROR, 'ログインしてください。');
            redirect('login');
        }
    }

    public static function hasPermission($topic_id, $user)
    {
        return TopicQuery::isUserOwnTopic($topic_id, $user);
    }

    public static function requirePermission($topic_id, $user)
    {
        if (!static::hasPermission($topic_id, $user)) {
            Msg::push(
                Msg::ERROR,
                '編集権限がありません。ログインして再度試してみてください。'
            );
            redirect('login');
        }
    }
}
