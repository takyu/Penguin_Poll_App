<?php
namespace view\topic\edit;

function index($topic)
{
    ?>
<h1 class="fs-2 mb-3">トピック編集</h1>
<div class="bg-white p-4 shadow-sm mx-auto rounded">
  <form action="<?php echo CURRENT_URI;?>" method="POST">
    <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>">
    <div class="mb-3">
      <label for="Input-title" class="form-label">タイトル</label>
      <input type="text" name="title" class="form-control bg-white" id="Input-title"
        value="<?php echo $topic->title; ?>">
    </div>
    <div class="mb-3">
      <label for="published" class="form-label">ステータス</label>
      <select name="published" class="form-select bg-white" aria-label="">
        <option value="1" <?php echo $topic->published ? 'selected' : ''; ?>>公開</option>
        <option value="0" <?php echo $topic->published ? '' : 'selected'; ?>>非公開</option>
      </select>
    </div>
    <div class=" d-flex align-items-center">
      <div>
        <input type="submit" class="btn btn-primary text-white shadow-sm" value="送信">
      </div>
      <div>
        <a href="<?php the_url('topic/archive'); ?>" class="btn btn-link">戻る</a>
      </div>
    </div>
  </form>
</div>
<?php
}