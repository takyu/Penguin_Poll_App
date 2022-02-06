<?php
declare(strict_types=1);

namespace db;

use lib\Auth;
use db\DataSource;
use model\UserModel;

class UserQuery
{
    public static function fetch_by_id($id): object|bool
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
}
