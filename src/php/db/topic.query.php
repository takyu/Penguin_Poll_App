<?php
namespace db;

use db\DataSource;
use lib\Auth;
use model\TopicModel;

class TopicQuery
{
    public static function fetchByUserId($user): bool|array
    {
        if (!$user->isValidId()) {
            return false;
        }

        $db = Auth::dbLogin();
        $sql =
            'select * from topics where user_id = ? and del_flg != 1 order by id desc;';

        $result = $db->select(
            $sql,
            [$user->id],
            DataSource::CLS,
            TopicModel::class
        );

        return $result;
    }
}
