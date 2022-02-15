<?php
declare(strict_types=1);

namespace model;

use lib\Msg;

class TopicModel extends AbstractModel
{
    public int $id;
    public string $title;
    public int $published;
    public int $views;
    public int $likes;
    public int $neither;
    public int $dislikes;
    public string $user_id;
    public string $nickname;
    public int $del_flg;

    /**
     * When a variable is preceded by _,
     * it means that it is changed or gotten through a method.
     */
    protected static string|null $SESSION_NAME = '_topic';

    /**
     * Check format of id
     */
    public function isValidId(): bool
    {
        return static::validateId($this->id);
    }
    public static function validateId(int $val): bool
    {
        if (empty($val) || !is_numeric($val)) {
            Msg::push(Msg::ERROR, 'パラメーターが不正です。');
            return false;
        }
        return true;
    }

    /**
     * Check format of title
     */
    public function isValidTitle(): bool
    {
        return static::validateTitle($this->title);
    }
    public static function validateTitle(string $val): bool
    {
        if (empty($val)) {
            Msg::push(Msg::ERROR, 'タイトルを入力してください。');
            return false;
        } elseif (mb_strlen($val) > 50) {
            Msg::push(Msg::ERROR, 'タイトルは50文字以内で入力してください。');
            return false;
        }
        return true;
    }

    /**
     * Check format of published value
     */
    public function isValidPublished(): bool
    {
        return static::validatePublished($this->published);
    }
    public static function validatePublished(int $val): bool
    {
        if (!isset($val)) {
            Msg::push(Msg::ERROR, '公開もしくは非公開を選択してください。');
            return false;
        } elseif (!($val === 0 || $val === 1)) {
            Msg::push(Msg::ERROR, '公開ステータスが不正です。');
            return false;
        }
        return true;
    }
}
