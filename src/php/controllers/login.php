<?php
declare(strict_types=1);

namespace controller\login;

function get(): void {
  require_once SOURCE_BASE . '/views/login.php';
}

function post(): void {
  echo 'get post method.';
}