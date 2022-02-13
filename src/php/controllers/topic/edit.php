<?php
namespace controller\topic\edit;

use db\TopicQuery;
use lib\Auth;
use lib\Msg;
use model\UserModel;
use model\TopicModel;

use function view\topic\edit\index;

function get()
{
    Auth::requireLogin();

    $topic = new TopicModel();
    $topic->id = (int) get_param('topic_id', '', false);

    $user = UserModel::getSession();
    Auth::requirePermission($topic->id, $user);

    $fetchedTopic = TopicQuery::fetchById($topic);

    index($fetchedTopic);
}

function post()
{
    Auth::requireLogin();

    $topic = new TopicModel();
    $topic->id = (int) get_param('topic_id', '');
    $topic->title = get_param('title', '');
    $topic->published = (int) get_param('published', '');

    $user = UserModel::getSession();
    Auth::requirePermission($topic->id, $user);

    try {
        $is_success = TopicQuery::update($topic);
    } catch (\Throwable $th) {
        Msg::push(Msg::DEBUG, $th->getMessage());
        $is_success = false;
    }

    if ($is_success) {
        Msg::push(Msg::INFO, 'トピックの更新に成功しました。');
        redirect('topic/archive');
    } else {
        Msg::push(Msg::ERROR, 'トピックの更新に失敗しました。');
        redirect(GO_REFERER);
    }
}
