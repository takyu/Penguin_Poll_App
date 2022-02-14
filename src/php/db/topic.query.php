<?php
declare(strict_types=1);

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

    public static function fetchById($topic): bool|object
    {
        if (!$topic->isValidId()) {
            return false;
        }

        $db = Auth::dbLogin();
        $sql = 'select t.*, u.nickname
            from topics t
            inner join users u
            on t.user_id = u.id
            where t.id = ?
            and t.del_flg != 1
            and u.del_flg != 1
            order by t.id desc;
        ';

        $result = $db->selectOne(
            $sql,
            [$topic->id],
            DataSource::CLS,
            TopicModel::class
        );

        return $result;
    }

    public static function incrementViewCount($topic): bool
    {
        if (!$topic->isValidId()) {
            return false;
        }

        $db = Auth::dbLogin();

        $sql = 'update topics
        set views = views + 1
        where id = ?;
        ';

        return $db->execute($sql, [$topic->id]);
    }

    public static function isUserOwnTopic($topic_id, $user): bool
    {
        if (!(TopicModel::validateId($topic_id) && $user->isValidId())) {
            return false;
        }

        $db = Auth::dbLogin();
        $sql = 'select count(1) as count
          from topics t
          where t.id = :topic_id
          and t.user_id = :user_id
          and t.del_flg != 1;
        ';

        $result = $db->selectOne($sql, [
            ':topic_id' => $topic_id,
            ':user_id' => $user->id,
        ]);

        return !empty($result) && $result['count'] != 0;
    }

    public static function update($topic): bool
    {
        // validate check
        if (
            !(
                $topic->isValidId() *
                $topic->isValidTitle() *
                $topic->isValidPublished()
            )
        ) {
            return false;
        }

        $db = Auth::dbLogin();
        $sql = 'update topics
        set published = :published,
        title = :title
        where id = :id';

        return $db->execute($sql, [
            ':published' => $topic->published,
            ':title' => $topic->title,
            ':id' => $topic->id,
        ]);
    }

    public static function insert($topic, $user)
    {
        // validate check
        if (
            !(
                $user->isValidId() *
                $topic->isValidTitle() *
                $topic->isValidPublished()
            )
        ) {
            return false;
        }

        $db = Auth::dbLogin();
        $sql = 'insert into topics(title, published, user_id)
            values (:title, :published, :user_id);
        ';

        return $db->execute($sql, [
            ':title' => $topic->title,
            ':published' => $topic->published,
            ':user_id' => $user->id,
        ]);
    }

    public static function incrementLikesOrDislikes($comment): bool
    {
        // validate check
        if (!($comment->isValidTopicId() * $comment->isValidAgree())) {
            return false;
        }

        $db = Auth::dbLogin();

        if ($comment->agree) {
            $sql = 'update topics
          set likes = likes + 1
          where id = ?';
        } else {
            $sql = 'update topics
          set dislikes = dislikes + 1
          where id = ?';
        }

        return $db->execute($sql, [$comment->topic_id]);
    }
}
