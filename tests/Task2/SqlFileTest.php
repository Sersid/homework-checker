<?php
declare(strict_types=1);

namespace Tests\Task2;

use PDO;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use function in_array;
use function PHPUnit\Framework\assertTrue;

#[TestDox('Тесты 2.sql')]
final class SqlFileTest extends DatabaseTestCase
{
    #[TestDox('БД содержит таблицу $table')]
    #[TestWith(['a_product'])]
    #[TestWith(['a_property'])]
    #[TestWith(['a_price'])]
    #[TestWith(['a_category'])]
    public function testTableExist(string $table): void
    {
        $tables = $this->getTables();

        $result = in_array($table, $tables, true);

        assertTrue($result);
    }

    private function getTables(): array
    {
        return self::$pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    }
}
