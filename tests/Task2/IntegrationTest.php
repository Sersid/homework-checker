<?php
declare(strict_types=1);

namespace Tests\Task2;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\DatabaseTestCase;
use RuntimeException;
use function PHPUnit\Framework\assertXmlFileEqualsXmlFile;

#[TestDox('Корректность работы импорта и экспорта данных')]
final class IntegrationTest extends DatabaseTestCase
{
    public static function dataProvider(): iterable
    {
        return [
            'set-1' => [
                __DIR__ . '/xml/set-1/input.xml',
                'Бумага',
                __DIR__ . '/xml/set-1/expected.xml',
            ],
            'set-2' => [
                __DIR__ . '/xml/set-2/input.xml',
                'Шариковые ручки',
                __DIR__ . '/xml/set-2/expected.xml',
            ],
        ];
    }

    #[TestDox('Базовый импорт и экспорт')]
    #[DataProvider('dataProvider')]
    public function test(string $inputFilename, string $categoryName, string $expectedFilename): void
    {
        importXml($inputFilename);

        $outputFile = $this->export($categoryName);

        assertXmlFileEqualsXmlFile($expectedFilename, $outputFile);
    }

    #[TestDox('Два импорта одного и того же файла')]
    #[DataProvider('dataProvider')]
    public function testRepeatedImport(string $inputFilename, string $categoryName, string $expectedFilename): void
    {
        importXml($inputFilename);
        importXml($inputFilename);

        $outputFile = $this->export($categoryName);

        assertXmlFileEqualsXmlFile($expectedFilename, $outputFile);
    }

    private function export(string $categoryName): string
    {
        $outputFile = tempnam(sys_get_temp_dir(), 'output');
        $categoryCode = $this->getCategoryCodeByName($categoryName);
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
