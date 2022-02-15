<?php
declare(strict_types=1);

namespace view\topic\detail;

use lib\Msg;

use function partials\topic_header_item;

function index(object $topic, array $comments): void
{
    $comments = escape($comments);
    $topic = escape($topic);
    topic_header_item($topic, false);
    ?>
<ul class="list-unstyled pt-5">
  <?php foreach ($comments as $comment): ?>
  <?php if ($comment->agree === 1) {
      $agree_label = '賛成';
      $agree_cls = 'bg-success';
  } elseif ($comment->agree === 0) {
      $agree_label = '反対';
      $agree_cls = 'bg-danger';
  } elseif ($comment->agree === 2) {
      $agree_label = '決めかねる';
      $agree_cls = 'bg-secondary';
  } else {
      Msg::push(
          Msg::ERROR,
          '無効な数値が入力されています。管理者に問い合わせてください。'
      );
      redirect(GO_HOME);
  } ?>
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
