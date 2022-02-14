<?php
namespace db;

use PDO;
use PDOStatement;

/**
 * Singleton pattern
 *
 * This pattern guarantees that there is only one instance.
 * It has a static method to get the only instance,
 * and it always returns the same instance.
 */
class PDOSingleton
{
    private static PDO $singleton;

    private function __construct($dsn, $username, $password, $options)
    {
        $this->conn = new PDO($dsn, $username, $password, $options);
    }

    public static function getInstance($dsn, $username, $password, $options)
    {
        if (!isset(self::$singleton)) {
            $instance = new PDOSingleton($dsn, $username, $password, $options);
            self::$singleton = $instance->conn;
        }
        return self::$singleton;
    }
}

interface IDataSource
{
    // Execute
    public function execute(string $sql, array $params): bool;

    // Fetch
    public function select(string $sql, array $params): array;
    public function selectOne(string $sql, array $params): object|array|bool;

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
        $this->conn = PDOSingleton::getInstance(
            $dsn,
            $username,
            $password,
            $options
        );
    }

    public function executeSql(string $sql, array $params): PDOStatement|bool
    {
        $stmt = $this->conn->prepare($sql);
        $this->sql_request = $stmt->execute($params);
        return $stmt;
    }

    /* Execute */
    public function execute(string $sql = '', array $params = []): bool
    {
        $this->executeSql($sql, $params);
        return $this->sql_request;
    }

    /* Fetch */
    public function select(
        string $sql = '',
        array $params = [],
        $type = '',
        $cls = ''
    ): array {
        $stmt = $this->executeSql($sql, $params);
        if ($type === static::CLS) {
            return $stmt->fetchAll(PDO::FETCH_CLASS, $cls);
        }
        return $stmt->fetchAll();
    }
    public function selectOne(
        string $sql = '',
        array $params = [],
        $type = '',
        $cls = ''
    ): object|array|bool {
        $result = $this->select($sql, $params, $type, $cls);
        //var_dump($result[0]);
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
