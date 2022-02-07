<?php
declare(strict_types=1);

namespace controller\login;

use lib\Auth;
use lib\Msg;
use model\UserModel;

function get(): void
{
    require_once SOURCE_BASE . '/views/login.php';
}

function post(): void
{
    $id = get_param('id', '');
    $pwd = get_param('pwd', '');

    if (Auth::login($id, $pwd)) {
        $user = UserModel::get_session();
        Msg::push(
            Msg::INFO,
            "認証に成功しました。{$user->nickname}さん、ようこそ!!"
        );
        redirect(GO_HOME);
    } else {
        redirect(GO_REFERER);
    }
}
