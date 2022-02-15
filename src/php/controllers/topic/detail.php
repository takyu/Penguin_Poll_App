<?php
declare(strict_types=1);

namespace controller\topic\detail;

use db\CommentQuery;
use lib\Msg;
use db\TopicQuery;
use lib\Auth;
use model\CommentModel;
use model\TopicModel;
use model\UserModel;

use function view\topic\detail\index;

function get(): void
{
    $topic = new TopicModel();
    $topic->id = (int) get_param('topic_id', '', false);

    TopicQuery::incrementViewCount($topic);

    $fetchd_topic = TopicQuery::fetchById($topic);
    $comments = CommentQuery::fetchByTopicId($topic);

    if (empty($fetchd_topic) || $fetchd_topic->published != 1) {
        Msg::push(Msg::ERROR, 'トピックが見つかりません。');
        redirect('404');
    }

    index($fetchd_topic, $comments);
}

function post(): void
{
    Auth::requireLogin();

    $comment = new CommentModel();
    $comment->topic_id = (int) get_param('topic_id', null, true);
    $comment->agree = (int) get_param('inlineRadioOptions', null, true);
    $comment->body = get_param('body', null, true);

    $user = UserModel::getSession();
    $comment->user_id = $user->id;

    try {
        $db = Auth::dbLogin();

        // transaction start
        $db->begin();

        // insert topics table
        $is_success = TopicQuery::incrementLikesOrDislikesOrNeither($comment);
        if ($is_success && !empty($comment->body)) {
            // insert comments table
            $is_success = CommentQuery::insert($comment);
        }
    } catch (\Throwable $th) {
        Msg::push(Msg::DEBUG, $th->getMessage());
        $is_success = false;
    } finally {
        if ($is_success) {
            $db->commit();
            Msg::push(Msg::INFO, 'コメントの登録に成功しました。');
        } else {
            $db->rollback();
            Msg::push(Msg::ERROR, 'コメントの登録に失敗しました。');
        }
    }

    redirect('topic/detail?topic_id=' . $comment->topic_id);
}
