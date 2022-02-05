<?php 
declare(strict_types=1);

namespace db;

use db\SetDbEnv;
use db\DataSource;
use model\UserModel;

class UserQuery {

  public static function fetch_by_id($id): object {

    SetDbEnv::set_db_env();
    $db = new DataSource(
      $_ENV['DB_HOST'],
      $_ENV['DB_PORT'],
      $_ENV['DB_NAME'],
      $_ENV['DB_USER'],
      $_ENV['DB_PASS']
    );

    $sql = '
      select * from users
      where id = :id;
    ';

    $result = $db->select_one($sql, [
      ':id' => $id
    ], DataSource::CLS, UserModel::class);

    return $result;
  }
}