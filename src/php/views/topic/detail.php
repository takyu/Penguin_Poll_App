<?php
declare(strict_types=1);

namespace view\topic\detail;

use function partials\topic_header_item;
use function partials\topic_list_item;

function index($topic, $comments)
{
    topic_header_item($topic, false); ?>
<ul class="list-unstyled pt-5">
  <?php foreach ($comments as $comment): ?>
  <?php
  $agree_label = $comment->agree ? '賛成' : '反対';
  $agree_cls = $comment->agree ? 'bg-success' : 'bg-danger';
  ?>
  <li class="bg-white shadow-sm mb-3 rounded p-3">
    <h2 class="fs-4 mb-2">
      <span class="badge me-1 align-bottom <?php echo $agree_cls; ?>"><?php echo $agree_label; ?></span>
      <span href="" class="text-body"><?php echo $comment->body; ?></span>
    </h2>
    <span>Commented by <?php echo $comment->nickname; ?></span>
  </li>
  <?php endforeach; ?>
</ul>
<?php
}