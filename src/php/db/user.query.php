<?php
declare(strict_types=1);

namespace db;

use lib\Auth;
use db\DataSource;
use model\UserModel;

class UserQuery
{
    public static function fetch_by_id(string $id): object|bool
    {
        $db = Auth::db_login();
        $sql = '
      select * from users
      where id = :id;
    ';

        $result = $db->select_one(
            $sql,
            [
                ':id' => $id,
            ],
            DataSource::CLS,
            UserModel::class
        );

        return $result;
    }

    public static function insert($user): object|bool
    {
        $db = Auth::db_login();
        $sql =
            'insert into users(id, pwd, nickname) values (:id, :pwd, :nickname);';

        // hashing
        $pwd = password_hash($user->pwd, PASSWORD_DEFAULT);

        return $db->execute(
            $sql,
            [
                ':id' => $user->id,
                ':pwd' => $user->pwd,
                ':nickname' => $user->nickname,
            ],
            DataSource::CLS,
            UserModel::class
        );
    }
}
