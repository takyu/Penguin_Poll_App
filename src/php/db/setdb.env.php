<?php 
declare(strict_types=1);

namespace db;

use Dotenv\Dotenv;

class SetDbEnv {
  public static function set_db_env(): void {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../', 'db_auth.env');
    $dotenv->load();
  }
}