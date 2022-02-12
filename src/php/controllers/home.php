<?php
declare(strict_types=1);

namespace controller\home;

use db\TopicQuery;

use function view\home\index;

function get(): void
{
    $topics = TopicQuery::fetchByPublishedTopics();
    index($topics);
}
