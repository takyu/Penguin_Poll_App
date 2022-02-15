<?php
namespace partials;

use lib\Auth;

function topic_header_item(object $topic, bool $from_top_page): void
{
    ?>

<div class="row my-3">

  <!-- left side chart -->
  <div class="col my-2">
    <?php chart($topic); ?>
  </div>

  <!-- right side content -->
  <div class="col my-2">
    <?php topic_main($topic, $from_top_page); ?>
    <?php comment_form($topic); ?>
  </div>

</div>

<?php
}

function chart(object $topic): void
{
    ?>

<canvas id="chart" width="400" height="400" data-likes="<?php echo $topic->likes; ?>"
  data-dislikes="<?php echo $topic->dislikes; ?>"></canvas>

<?php
}

function topic_main(object $topic, bool $from_top_page): void
{
    ?>

<div>
  <?php if ($from_top_page): ?>
  <h1 class="visually-hidden">ペンギンについてのアンケート</h1>
  <h2 class="fs-1">
    <a class="text-body" href="<?php the_url(
        'topic/detail?topic_id=' . $topic->id
    ); ?>">
      <?php echo $topic->title; ?>
    </a>
  </h2>
  <?php else: ?>
  <h1><?php echo $topic->title; ?></h1>
  <?php endif; ?>
  <span class="me-1 fs-5">Posted by <?php echo $topic->nickname; ?></span>
  <span class="me-1 fs-5">&bull;</span>
  <span class="fs-5"><?php echo $topic->views; ?> views</span>
</div>
<div class="container text-center my-4">
  <div class="row justify-content-around">
    <div class="likes-green col-auto">
      <div class="display-1"><?php echo $topic->likes; ?></div>
      <div class="fs-4 mb-0">賛成</div>
    </div>
    <div class="dislikes-red col-auto">
      <div class="display-1"><?php echo $topic->dislikes; ?></div>
      <div class="fs-4 mb-0">反対</div>
    </div>
  </div>
</div>

<?php
}

function comment_form(object $topic): void
{
    ?>

<?php if (Auth::isLogin()): ?>
<form class="validate-form" action="<?php the_url('topic/detail'); ?>" method="POST" autocomplete="off" novalidate>
  <span class="fs-4">あなたは賛成？それとも反対？</span>
  <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>">
  <div class="mb-2">
    <textarea class="form-control bg-white" name="body" id="floatingTextarea" style="height: 90px" maxlength="100"></textarea>
  </div>
  <div class="container">
    <div class="row fs-4">
      <div class="col-auto d-flex align-items-center ps-0">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" id="agree" name="inlineRadioOptions" value="1" required checked>
          <label class="form-check-label" for="agree">賛成</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" id="disagree" name="inlineRadioOptions" value="0">
          <label class="form-check-label" for="disagree">反対</label>
        </div>
      </div>
      <input type="submit" value="送信" class="col btn btn-success shadow-sm">
    </div>
  </div>
</form>
</div>
<?php else: ?>
<div class="text-center mt-5">
  <div class="mb-2">ログインしてアンケートに参加してね！</div>
  <a href="<?php the_url(
      'login'
  ); ?>" class="btn btn-lg btn-success">ログインはこちら</a>
</div>
<?php endif; ?>

<?php
}
