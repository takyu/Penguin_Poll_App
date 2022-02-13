<?php
namespace controller\topic\create;

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
    $topic->id = -1;
    $topic->title = '';
    $topic->published = 1;

    index($topic, false);
}

function post()
{
    Auth::requireLogin();

    $topic = new TopicModel();
    $topic->id = (int) get_param('topic_id', null);
    $topic->title = get_param('title', null);
    $topic->published = (int) get_param('published', null);

    $user = UserModel::getSession();

    try {
        $is_success = TopicQuery::insert($topic, $user);
    } catch (\Throwable $th) {
        Msg::push(Msg::DEBUG, $th->getMessage());
        $is_success = false;
    }

    if ($is_success) {
        Msg::push(Msg::INFO, 'トピックの登録に成功しました。');
        redirect('topic/archive');
    } else {
        Msg::push(Msg::ERROR, 'トピックの登録に失敗しました。');
        redirect(GO_REFERER);
    }
}