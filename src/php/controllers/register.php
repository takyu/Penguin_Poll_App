<?php
declare(strict_types=1);

namespace controller\register;

use lib\Auth;
use lib\Msg;
use model\UserModel;
use function view\register\index;

function get(): void
{
    index();
}

function post(): void
{
    $user = new UserModel();
    $user->id = get_param('id', '');
    $user->pwd = get_param('pwd', '');
    $user->nickname = get_param('nickname', '');

    if (Auth::regist($user)) {
        Msg::push(Msg::INFO, "{$user->nickname}さん、ようこそ!!");
        redirect(GO_HOME);
    } else {
        redirect(GO_REFERER);
    }
}
