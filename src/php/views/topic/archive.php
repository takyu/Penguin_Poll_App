<?php
namespace view\topic\archive;

use function partials\topic_list_item;

function index(array $topics): void
{
    $topics = escape($topics); ?>
<h1 class="h2 mb-3"></h1>
<ul class="container">
  <?php foreach ($topics as $topic) {
      // URL to edit display for each post
      $url = get_url('topic/edit?topic_id=' . $topic->id);
      topic_list_item($topic, $url, true);
  } ?>
</ul>
<?php
}
?>
