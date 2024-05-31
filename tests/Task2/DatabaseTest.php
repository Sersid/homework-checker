<?php
declare(strict_types=1);

namespace Tests\Task2;

use PDO;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEmpty;

#[TestDox('Тесты создания бд')]
final class DatabaseTest extends TestCase
{
    private static PDO $pdo;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$pdo = new PDO(
            'mysql:host=' . getenv('PROJECT_DB_HOST'),
            'root',
            'password'
        );
        self::$pdo->query('drop database if exists ' . getenv('PROJECT_DB_NAME'));
        self::$pdo->query('create database ' . getenv('PROJECT_DB_NAME'));
        self::$pdo->query('use ' . getenv('PROJECT_DB_NAME'));
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        self::$pdo->query('drop database if exists ' . getenv('PROJECT_DB_NAME'));
    }

    #[TestDox('Изначально бд пуста')]
    public function testEmptyDb(): void
    {
        $tables = self::$pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);

        assertEmpty($tables);
    }
}