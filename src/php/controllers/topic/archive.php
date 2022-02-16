<?php
declare(strict_types=1);

namespace controller\topic\archive;

use db\TopicQuery;
use lib\Auth;
use lib\Msg;
use model\UserModel;

use function view\topic\archive\index;

function get(): void
{
    Auth::requireLogin();

    $user = UserModel::getSession();

    $topics = TopicQuery::fetchByUserId($user);

    if ($topics === false) {
        Msg::push(Msg::ERROR, 'ログインしてください。');
        redirect('login');
    }

    if (count($topics) > 0) {
        index($topics);
    } else {
        echo '<div class="alert alert-primary" role="alert">トピックを投稿してみよう！</div>';
    }
}
