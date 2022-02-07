<?php
declare(strict_types=1);

namespace controller\login;

use lib\Auth;

function get(): void
{
    require_once SOURCE_BASE . '/views/login.php';
}

function post(): void
{
    $id = get_param('id', '');
    $pwd = get_param('pwd', '');

    if (Auth::login($id, $pwd)) {
        // echo '認証成功';
        redirect(GO_HOME);
      } else {
        echo '認証失敗';
        redirect(GO_REFERER);
    }
}
