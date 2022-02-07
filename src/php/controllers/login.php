<?php
declare(strict_types=1);

namespace controller\login;

use lib\Auth;
use lib\Msg;

function get(): void
{
    require_once SOURCE_BASE . '/views/login.php';
}

function post(): void
{
    $id = get_param('id', '');
    $pwd = get_param('pwd', '');

    Msg::push(Msg::DEBUG, '*** Debug mode ***');

    if (Auth::login($id, $pwd)) {
        Msg::push(Msg::INFO, 'Authentication success');
        redirect(GO_HOME);
      } else {
        Msg::push(Msg::ERROR, 'Authentication failure');
        redirect(GO_REFERER);
    }
}
