<?php

namespace partials;

use lib\Auth;
use lib\Msg;

function header()
{
    ?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ペンギンについてのアンケート</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="//fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo BASE_CSS_PATH; ?>style.css">
</head>

<body>
  <div id="container">
    <header class="container my-2">
      <nav class="row align-items-center py-2">
        <a href="<?php the_url(
            '/'
        ); ?>" class="col-md d-flex align-items-center mb-3 mb-md-0">
          <img width="50" class="me-2" src="<?php echo BASE_IMAGE_PATH; ?>logo.svg" alt="ペンギンについてのアンケート　サイトロゴ">
          <span class="fs-2 fw-bold mb-0">ペンギンについてのアンケート</span>
        </a>
        <div class="col-md-auto">
          <?php if (Auth::isLogin()): ?>
          <?php // Display when user is logined ?>
          <a href="<?php the_url(
                'topic/create'
            ); ?>" class="btn btn-primary mr-2">投稿</a>
          <a href="<?php the_url('topic/archive'); ?>" class="mr-2">過去の投稿</a>
          <a href="<?php the_url('logout'); ?>">ログアウト</a>
          <?php else: ?>
          <a href="<?php the_url(
              'register'
          ); ?>" class="btn btn-primary me-2">登録</a>
          <a href="<?php the_url('login'); ?>">ログイン</a>
          <?php endif; ?>
        </div>
      </nav>
    </header>
    <main class="container py-3">
      <?php
Msg::flush();

if (DEBUG) {
    if (Auth::isLogin()) {
        echo "<div class='alert alert-secondary'>You are logged in.</div>";
    } else {
        echo "<div class='alert alert-secondary'>You are not logged in.</div>";
    }
}
} // header()

?>