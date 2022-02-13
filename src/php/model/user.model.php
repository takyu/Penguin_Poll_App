<?php
declare(strict_types=1);

namespace model;

use lib\Msg;

class UserModel extends AbstractModel
{
    public string $id;
    public string $pwd;
    public string $nickname;
    public int $del_flg;

    /**
     * When a variable is preceded by _,
     * it means that it is changed or gotten through a method.
     */
    protected static string|null $SESSION_NAME = '_user';

    /**
     * Check format of id
     */
    public function isValidId(): bool
    {
        return static::validateId($this->id);
    }
    public static function validateId(string $val): bool
    {
        if (empty($val)) {
            Msg::push(Msg::ERROR, 'ユーザーIDを入力してください。');
            return false;
        } else {
            $invalid_fmt_flg = 0;

            if (strlen($val) > 15) {
                Msg::push(
                    Msg::ERROR,
                    ' ユーザーIDは15桁以下で入力してください。'
                );
                $invalid_fmt_flg = 1;
            }
            if (!is_alnum($val)) {
                Msg::push(
                    Msg::ERROR,
                    'ユーザーIDは半角英数字で入力してください。'
                );
                $invalid_fmt_flg = 1;
            }
        }
        return $invalid_fmt_flg == 0 ? true : false;
    }

    /**
     * Check format of password
     */
    public function isValidPwd(): bool
    {
        return static::validatePwd($this->pwd);
    }
    public static function validatePwd(string $val): bool
    {
        if (empty($val)) {
            Msg::push(Msg::ERROR, 'パスワードを入力してください。');
            return false;
        } else {
          $invalid_fmt_flg = 0;

            if (strlen($val) < 6) {
                Msg::push(
                    Msg::ERROR,
                    'パスワードは6桁以上で入力してください。'
                );
                $invalid_fmt_flg = 1;
            }
            if (!is_alnum_and_more_one_capital_alpha($val)) {
                Msg::push(
                    Msg::ERROR,
                    'パスワードは半角英数字かつ、一つ以上の大文字のアルファベットを入力してください。'
                );
                $invalid_fmt_flg = 1;
            }
        }
        return $invalid_fmt_flg == 0 ? true : false;
    }

    /**
     * Check format of nickname
     */
    public function isValidNickname(): bool
    {
        return static::validateNickname($this->nickname);
    }
    public static function validateNickname(string $val): bool
    {
        if (empty($val)) {
            Msg::push(Msg::ERROR, 'ニックネームを入力してください。');
            return false;
        } else {
            if (mb_strlen($val) > 10) {
                Msg::push(
                    Msg::ERROR,
                    'ニックネームは10文字以下で入力してください。'
                );
                return false;
            }
        }
        return true;
    }
}
