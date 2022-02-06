<?php
declare(strict_types=1);

namespace controller\login;

use db\UserQuery;

function get(): void
{
    require_once SOURCE_BASE . '/views/login.php';
}

function login(string $id, string $pwd): bool
{
    $is_success = false;

    $user = UserQuery::fetch_by_id($id);

    if (!empty($user) && $user->del_flg !== 1) {
        $result = password_verify($pwd, $user->pwd);

        if ($result) {
            $is_success = true;
            $_SESSION['user'] = $user;
        } else {
            echo 'Password does not match.';
        }
    } else {
        echo 'User does not find.';
    }

    return $is_success;
}

function post(): void
{
    // $id = isset($_POST['id']) ? $_POST['id'] : '';
    $id = $_POST['id'] ?? '';
    $pwd = $_POST['pwd'] ?? '';

    $result = login($id, $pwd);

    if ($result) {
        echo '認証成功';
    } else {
        echo '認証失敗';
    }
}
