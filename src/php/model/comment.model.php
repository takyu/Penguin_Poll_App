<?php
declare(strict_types=1);

namespace model;

class CommentModel extends AbstractModel
{
    public int $id;
    public int $topic_id;
    public int $agree;
    public string $body;
    public string $user_id;
    public string $nickname;
    public int $del_flg;

    protected static string|null $SESSION_NAME = '_comment';
}
