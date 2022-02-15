<?php
declare(strict_types=1);

namespace db;

use lib\Auth;
use db\DataSource;
use model\UserModel;

class UserQuery
{
    public static function fetchById(string $id): object|bool
    {
        $db = Auth::dbLogin();
        $sql = '
      select * from users
      where id = :id;
    ';

        $result = $db->selectOne(
            $sql,
            [
                ':id' => $id,
            ],
            DataSource::CLS,
            UserModel::class
        );

        gettype(DataSource::CLS);

        return $result;
    }

    public static function insert($user): object|bool
    {
        $db = Auth::dbLogin();
        $sql =
            'insert into users(id, pwd, nickname) values (:id, :pwd, :nickname);';

        // hashing
        $user->pwd = password_hash($user->pwd, PASSWORD_DEFAULT);

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
