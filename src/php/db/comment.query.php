<?php
declare(strict_types=1);

namespace db;

use lib\Auth;
use model\CommentModel;

class CommentQuery
{
    public static function fetchByTopicId(object $topic): bool|array
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

    public static function insert(object $comment): bool
    {
        // validate check
        if (
            !(
                $comment->isValidTopicId() *
                $comment->isValidAgree() *
                $comment->isValidBody()
            )
        ) {
            return false;
        }

        $db = Auth::dbLogin();
        $sql = '
        insert into comments
            (topic_id, agree, body, user_id)
        values
            (:topic_id, :agree, :body, :user_id);
        ';

        return $db->execute($sql, [
            ':topic_id' => $comment->topic_id,
            ':agree' => $comment->agree,
            ':body' => $comment->body,
            ':user_id' => $comment->user_id,
        ]);
    }
}
