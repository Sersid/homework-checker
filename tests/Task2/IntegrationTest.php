<?php
declare(strict_types=1);

namespace Tests\Task2;

use PHPUnit\Framework\Attributes\TestDox;
use Tests\DatabaseTestCase;
use RuntimeException;
use function PHPUnit\Framework\assertXmlFileEqualsXmlFile;

#[TestDox('Корректность работы импорта и экспорта данных')]
final class IntegrationTest extends DatabaseTestCase
{
    public function test(): void
    {
        $inputFile = __DIR__ . '/xml/input.xml';
        importXml($inputFile);

        $outputFile = $this->export();

        assertXmlFileEqualsXmlFile($inputFile, $outputFile);
    }

    public function testRepeatedImport(): void
    {
        $inputFile = __DIR__ . '/xml/input.xml';
        importXml($inputFile);
        importXml($inputFile);

        $outputFile = $this->export();

        assertXmlFileEqualsXmlFile($inputFile, $outputFile);
    }

    private function export(): string
    {
        $outputFile = tempnam(sys_get_temp_dir(), 'output');
        $categoryCode = $this->getCategoryCodeByName('Бумага');
        exportXml($outputFile, $categoryCode);

        return $outputFile;
    }

    private function getCategoryCodeByName(string $name): string
    {
        $query = self::$pdo->prepare("SELECT code, name FROM a_category WHERE name=:name");
        $query->bindParam(':name', $name);
        $query->execute();

        $result = $query->fetch();
        if (!$result) {
            throw new RuntimeException('Категория ' . $name . ' не найдена');
        }

        return $result['code'];
    }
}
