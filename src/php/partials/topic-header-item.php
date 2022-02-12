<?php
namespace partials;

use lib\Auth;

function topic_header_item($topic, $from_top_page)
{
?>

<div class="row">
  <!-- left side chart -->
  <div class="col">
    <?php chart($topic); ?>
  </div>

  <!-- right side content -->
  <div class="col my-5">
    <?php topic_main($topic, $from_top_page); ?>
    <?php comment_form($topic) ?>
  </div>

</div>

<?php
}

function chart($topic) {
?>

<canvas id="chart" width="400" height="450" data-likes="<?php echo $topic->likes; ?>"
  data-dislikes="<?php echo $topic->dislikes; ?>"></canvas>
<style>
#chart {
  background-color: aqua;
}
</style>

<?php
}

function topic_main($topic, $from_top_page) {
?>

<div>
  <?php if($from_top_page) : ?>
  <h1 class="visually-hidden">ペンギンについてのアンケート</h1>
  <h2 class="h1">
    <a class="text-body" href="<?php the_url('topic/detail?topic_id=' . $topic->id); ?>">
      <?php echo $topic->title; ?>
    </a>
  </h2>
  <?php else : ?>
  <h1><?php echo $topic->title; ?></h1>
  <?php endif; ?>
  <span class="me-1 h5">Posted by <?php echo $topic->nickname; ?></span>
  <span class="me-1 h5">&bull;</span>
  <span class="h5"><?php echo $topic->views; ?></span>
</div>
<div class="container text-center my-4">
  <div class="row justify-content-around">
    <div class="likes-green col-auto">
      <div class="display-1"><?php echo $topic->likes; ?></div>
      <div class="h4 mb-0">賛成</div>
    </div>
    <div class="dislikes-red col-auto">
      <div class="display-1"><?php echo $topic->dislikes; ?></div>
      <div class="h4 mb-0">反対</div>
    </div>
  </div>
</div>

<?php
}

function comment_form($topic) {
?>

<?php if(Auth::isLogin()) : ?>
<form action="<?php the_url('topic/detail'); ?>" method="POST">
  <span class="h4">あなたは賛成？それとも反対？</span>
  <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>">
  <div class="mb-2">
    <textarea class="form-control bg-white" id="floatingTextarea" style="height: 90px"></textarea>
  </div>
  <div class="container">
    <div class="row fs-4">
      <div class="col-auto d-flex align-items-center ps-0">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" id="agree" name="inlineRadioOptions" value="1" checked>
          <label class="form-check-label" for="agree">賛成</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" id="disagree" name="inlineRadioOptions" value="2">
          <label class="form-check-label" for="disagree">反対</label>
        </div>
      </div>
      <input type="submit" value="送信" class="col btn btn-success shadow-sm">
    </div>
  </div>
</form>
</div>
<?php else : ?>
<div class="text-center mt-5">
  <div class="mb-2">ログインしてアンケートに参加してね！</div>
  <a href="<?php the_url('login'); ?>" class="btn btn-lg btn-success">ログインはこちら</a>
</div>
<?php endif; ?>

<?php
}