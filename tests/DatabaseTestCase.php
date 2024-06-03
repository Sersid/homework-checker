<?php
declare(strict_types=1);

namespace Tests;

use PDO;
use PHPUnit\Framework\TestCase;

abstract class DatabaseTestCase extends TestCase
{
    protected static PDO $pdo;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::connect();
        self::createDatabase();
        self::importSql();
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        self::dropDatabase();
    }

    private static function connect(): void
    {
        self::$pdo = new PDO(
            'mysql:host=' . getenv('PROJECT_DB_HOST'),
            getenv('PROJECT_DB_USERNAME'),
            getenv('PROJECT_DB_PASSWORD'),
        );
        self::$pdo->exec("set names utf8mb4");
    }

    private static function createDatabase(): void
    {
        self::$pdo->query('drop database if exists ' . getenv('PROJECT_DB_NAME'));
        self::$pdo->query('create database ' . getenv('PROJECT_DB_NAME'));
        self::$pdo->query('use ' . getenv('PROJECT_DB_NAME'));
    }

    private static function importSql(): void
    {
        $file = __DIR__ . '/../src/2.sql';
        $sql = file_get_contents($file);
        self::$pdo->exec($sql);
    }

    private static function dropDatabase(): void
    {
        self::$pdo->query('drop database if exists ' . getenv('PROJECT_DB_NAME'));
    }
}
