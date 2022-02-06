<?php
declare(strict_types=1);

namespace model;

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
}
