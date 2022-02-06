<?php
declare(strict_types=1);

namespace controller\register;

use lib\Auth;
use model\UserModel;

function get(): void
{
    require_once SOURCE_BASE . '/views/register.php';
}

function post(): void
{
    $user = new UserModel;
    $user->id = get_param('id', '');
    $user->pwd = get_param('pwd', '');
    $user->nickname = get_param('nickname', '');

    if (Auth::regist($user)) {
        echo '登録成功';
    } else {
        echo '登録失敗';
    }
}
