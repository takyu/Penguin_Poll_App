<?php
declare(strict_types=1);

namespace controller\login;

use lib\Auth;
use lib\Msg;
use model\UserModel;
use function view\login\index;

function get(): void
{
    index();
}

function post(): void
{
    $id = get_param('id', '');
    $pwd = get_param('pwd', '');

    if (Auth::login($id, $pwd)) {
        $user = UserModel::getSession();
        Msg::push(
            Msg::INFO,
            "認証に成功しました。{$user->nickname}さん、ようこそ!!"
        );
        redirect(GO_HOME);
    } else {
        redirect(GO_REFERER);
    }
}
