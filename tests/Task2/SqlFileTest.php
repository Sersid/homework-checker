<?php
declare(strict_types=1);

namespace Tests\Task2;

use PDO;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\DatabaseTestCase;
use function in_array;
use function PHPUnit\Framework\assertTrue;

#[TestDox('Файл 2.sql')]
final class SqlFileTest extends DatabaseTestCase
{
    #[TestDox('БД содержит таблицу $table')]
    #[TestWith(['a_product'])]
    #[TestWith(['a_property'])]
    #[TestWith(['a_price'])]
    #[TestWith(['a_category'])]
    public function testTableExist(string $table): void
    {
        $tables = self::$pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);

        $result = in_array($table, $tables, true);

        assertTrue($result);
    }

    #[TestDox('a_category содержит все необходимые столбцы для дальнейшего тестирования')]
    #[Depends('testTableExist')]
    public function testCategoryTable(): void
    {
        $tableFields = self::$pdo->query('DESCRIBE a_category')->fetchAll(PDO::FETCH_COLUMN);

        assertTrue(in_array('code', $tableFields, true), 'a_category не содержит code');
        assertTrue(in_array('name', $tableFields, true), 'a_category не содержит name');
    }
}
