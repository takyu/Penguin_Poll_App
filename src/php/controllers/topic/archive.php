<?php
namespace controller\topic\archive;

use db\TopicQuery;
use lib\Auth;
use model\UserModel;

use function view\topic\archive\index;

function get()
{
    Auth::requireLogin();

    $user = UserModel::getSession();

    $topics = TopicQuery::fetchByUserId($user);

    if (!$topics) {
        Msg::push(Msg::ERROR, 'ログインしてください。');
        redirect('login');
    }

    if (count($topics) > 0) {
        index($topics);
    } else {
        echo '<div class="alert alert-danger" role="alert">トピックを投稿しよう！</div>';
    }
}
