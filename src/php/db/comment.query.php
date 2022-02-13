<?php
declare(strict_types=1);

namespace db;

use lib\Auth;
use model\CommentModel;

class CommentQuery
{
    public static function fetchByTopicId($topic): bool|array
    {
        if (!$topic->isValidId()) {
            return false;
        }

        $db = Auth::dbLogin();
        $sql = 'select c.*, u.nickname
            from comments c
            inner join users u
            on c.user_id = u.id
            where c.topic_id = ?
            and c.body != ""
            and c.del_flg != 1
            and u.del_flg != 1
            order by c.id desc;';

        $result = $db->select(
            $sql,
            [$topic->id],
            DataSource::CLS,
            CommentModel::class
        );

        return $result;
    }
}
