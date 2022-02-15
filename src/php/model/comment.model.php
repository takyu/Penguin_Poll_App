<?php
declare(strict_types=1);

namespace model;

use lib\Msg;

class CommentModel extends AbstractModel
{
    public int $id;
    public int $topic_id;
    public int $agree;
    public ?string $body;
    public string $user_id;
    public string $nickname;
    public int $del_flg;

    protected static string|null $SESSION_NAME = '_comment';

    /**
     * Check format of agree value
     */
    public function isValidAgree(): bool
    {
        return static::validateAgree($this->agree);
    }
    public static function validateAgree(int $val): bool
    {
        if (!isset($val)) {
            Msg::push(Msg::ERROR, '賛成、反対もしくは決めかねるを選択してください。');
            if (!($val === 0 || $val === 1 || $val === 2)) {
                Msg::push(
                    Msg::ERROR,
                    '賛成反対、もしくは決めかねるにチェックしてください。'
                );
            }
            return false;
        }
        return true;
    }

    /**
     * Check format of body
     */
    public function isValidBody(): bool
    {
        return static::validateBody($this->body);
    }
    public static function validateBody(string $val): bool
    {
        if (mb_strlen($val) > 100) {
            Msg::push(Msg::ERROR, 'コメントは100文字以内で入力してください。');
            return false;
        }
        return true;
    }

    /**
     * Check format of id
     */
    public function isValidTopicId(): bool
    {
        return TopicModel::validateId($this->topic_id);
    }
}
