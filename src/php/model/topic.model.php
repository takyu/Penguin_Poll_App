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
        // return static::validate_id($this->id);
        return true;
    }

    public static function validateId($val): bool
    {
        return true;
    }

    // public static function validate_id(string $val): bool
    // {
    //     $res = true;

    //     if (empty($val)) {
    //         Msg::push(Msg::ERROR, 'ユーザーIDを入力してください。');
    //         $res = false;
    //     } else {
    //         if (strlen($val) > 15) {
    //             Msg::push(
    //                 Msg::ERROR,
    //                 ' ユーザーIDは15桁以下で入力してください。'
    //             );
    //             $res = false;
    //         }
    //         if (!is_alnum($val)) {
    //             Msg::push(
    //                 Msg::ERROR,
    //                 'ユーザーIDは半角英数字で入力してください。'
    //             );
    //             $res = false;
    //         }
    //     }
    //     return $res;
    // }

    // /**
    //  * Check format of password
    //  */
    // public function is_valid_pwd(): bool
    // {
    //     return static::validate_pwd($this->pwd);
    // }

    // public static function validate_pwd(string $val): bool
    // {
    //     $res = true;

    //     if (empty($val)) {
    //         Msg::push(Msg::ERROR, 'パスワードを入力してください。');
    //         $res = false;
    //     } else {
    //         if (strlen($val) < 6) {
    //             Msg::push(
    //                 Msg::ERROR,
    //                 'パスワードは6桁以上で入力してください。'
    //             );
    //             $res = false;
    //         }
    //         if (!is_alnum_and_more_one_capital_alpha($val)) {
    //             Msg::push(
    //                 Msg::ERROR,
    //                 'パスワードは半角英数字かつ、一つ以上の大文字のアルファベットを入力してください。'
    //             );
    //             $res = false;
    //         }
    //     }
    //     return $res;
    // }

    // /**
    //  * Check format of nickname
    //  */
    // public function is_valid_nickname(): bool
    // {
    //     return static::validate_nickname($this->nickname);
    // }

    // public static function validate_nickname(string $val): bool
    // {
    //     $res = true;

    //     if (empty($val)) {
    //         Msg::push(Msg::ERROR, 'ニックネームを入力してください。');
    //         $res = false;
    //     } else {
    //         /**
    //          * strlen
    //          * Half-width characters count as one character,
    //          * full-width characters count as two characters.
    //          *
    //          * mb_strlen
    //          * Half-width characters and full-width them count as one character.
    //          */
    //         if (mb_strlen($val) > 10) {
    //             Msg::push(
    //                 Msg::ERROR,
    //                 'ニックネームは10文字以下で入力してください。'
    //             );
    //             $res = false;
    //         }
    //     }
    //     return $res;
    // }
}
