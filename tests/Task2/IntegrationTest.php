<?php
declare(strict_types=1);

namespace Tests\Task2;

use PHPUnit\Framework\Attributes\TestDox;
use SimpleXMLElement;
use Tests\DatabaseTestCase;
use RuntimeException;
use function PHPUnit\Framework\assertJsonStringEqualsJsonString;

#[TestDox('Корректность работы импорта и экспорта данных')]
final class IntegrationTest extends DatabaseTestCase
{
    public function test(): void
    {
        $inputFile = __DIR__ . '/xml/input.xml';
        importXml($inputFile);

        $outputFile = tempnam(sys_get_temp_dir(), 'output');
        $categoryCode = $this->getCategoryCodeByName('Бумага');
        exportXml($outputFile, $categoryCode);

        assertJsonStringEqualsJsonString(
            json_encode(new SimpleXMLElement(file_get_contents(__DIR__ . '/xml/expected.xml')), JSON_THROW_ON_ERROR),
            json_encode(new SimpleXMLElement(file_get_contents($outputFile)), JSON_THROW_ON_ERROR)
        );
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
