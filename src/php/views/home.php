<?php
declare(strict_types=1);

namespace view\home;

use function partials\topic_header_item;
use function partials\topic_list_item;

function index($topics)
{
    $topic = array_shift($topics);
    topic_header_item($topic, true);
    ?>
<ul class="container">
  <?php foreach ($topics as $topic) {
      // URL to edit display for each post
      $url = get_url('topic/detail?topic_id=' . $topic->id);
      topic_list_item($topic, $url, false);
  } ?>
</ul>
<?php
}
