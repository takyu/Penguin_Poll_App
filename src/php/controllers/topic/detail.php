<?php
declare(strict_types=1);

namespace controller\topic\detail;

use db\CommentQuery;
use lib\Msg;
use db\TopicQuery;
use model\TopicModel;

use function view\topic\detail\index;

function get(): void
{
    $topic = new TopicModel();
    $topic->id = (int) get_param('topic_id', '', false);

    $fetchd_topic = TopicQuery::fetchById($topic);
    $comments = CommentQuery::fetchByTopicId($topic);

    if (!$fetchd_topic) {
        Msg::push(Msg::ERROR, 'トピックが見つかりません。');
        redirect('404');
    }

    index($topic, $comments);
}
