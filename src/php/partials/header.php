<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ペンギンについてのアンケート</title>
  <link rel="stylesheet" href="<?php echo BASE_CSS_PATH ?>sample.css">
</head>

<!-- Check to maintain SESSION -->
<body>
  <?php 
  use lib\Auth;

  if (Auth::is_login()) {
    echo 'You are logged in.';
  } else {
    echo 'You are not logged in.';
  }
  ?>
</body>