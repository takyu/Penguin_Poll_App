<?php 
namespace view\register;

function index() {
?>
<h1 class="visually-hidden">アカウント登録</h1>
<div class="mt-5">
  <div class="text-center mb-4">
    <img width="65" src="images/logo.svg" alt="ペンギンについてのアンケート　サイトロゴ">
  </div>
  <div class="login-form bg-white p-4 shadow-sm mx-auto rounded">
    <form action="<?php echo CURRENT_URI; ?>" method="post">
      <div class="mb-3">
        <label for="Input-id" class="form-label">ユーザーID</label>
        <input type="text" name="id" class="form-control bg-white" id="Input-id" placeholder="ユーザーID入力欄">
      </div>
      <div class="mb-3">
        <label for="Input-pass" class="form-label">パスワード</label>
        <input type="password" name="pwd" class="form-control bg-white" id="Input-pass" placeholder="パスワード入力欄">
      </div>
      <div class="mb-3">
        <label for="Input-nickname" class="form-label">ニックネーム</label>
        <input type="text" name="nickname" class="form-control bg-white" id="Input-nickname" placeholder="ニックネーム入力欄">
      </div>
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <a href="<?php the_url('login'); ?>">ログインへ</a>
        </div>
        <div>
          <input type="submit" class="btn btn-primary text-white shadow-sm" value="登録">
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
