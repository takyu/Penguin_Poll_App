<?php
declare(strict_types=1);

namespace db;

use PDO;
use PDOStatement;

interface IDataSource
{
    // Execute
    public function execute(string $sql, array $params): bool;

    // Fetch
    public function select(string $sql, array $params): array;
    public function select_one(string $sql, array $params): object|array|bool;

    // Transaction
    public function begin(): void;
    public function commit(): void;
    public function rollback(): void;
}

class DataSource implements IDataSource
{
    private PDO $conn;
    private bool $sql_request;
    public const CLS = 'cls';

    public function __construct(
        $host = 'localhost',
        $port = '3306',
        $dbname = '',
        $username = '',
        $password = ''
    ) {
        $dsn = "mysql:host{$host};port={$port};dbname={$dbname}";
        $options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $this->conn = new PDO($dsn, $username, $password, $options);
    }

    public function execute_sql(string $sql, array $params): PDOStatement|bool
    {
        $stmt = $this->conn->prepare($sql);
        $this->sql_request = $stmt->execute($params);
        return $stmt;
    }

    /* Execute */
    public function execute(string $sql = '', array $params = []): bool
    {
        $this->execute_sql($sql, $params);
        return $this->sql_request;
    }

    /* Fetch */
    public function select(
        string $sql = '',
        array $params = [],
        $type = '',
        $cls = ''
    ): array {
        $stmt = $this->execute_sql($sql, $params);
        if ($type === static::CLS) {
            return $stmt->fetchAll(PDO::FETCH_CLASS, $cls);
        }
        return $stmt->fetchAll();
    }
    public function select_one(
        string $sql = '',
        array $params = [],
        $type = '',
        $cls = ''
    ): object|array|bool {
        $result = $this->select($sql, $params, $type, $cls);
        return count($result) > 0 ? $result[0] : false;
    }

    /* Transaction */
    public function begin(): void
    {
        $this->conn->beginTransaction();
    }
    public function commit(): void
    {
        $this->conn->commit();
    }
    public function rollback(): void
    {
        $this->conn->rollBack();
    }
}
?>
