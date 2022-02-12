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

    public static function fetchByPublishedTopics(): bool|array
    {
        $db = Auth::dbLogin();
        $sql = 'select t.*, u.nickname
            from topics t
            inner join users u
            on t.user_id = u.id
            where t.del_flg != 1
            and u.del_flg != 1
            and t.published = 1
            order by t.id desc;
        ';

        $result = $db->select($sql, [], DataSource::CLS, TopicModel::class);

        return $result;
    }
}
