<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use ReflectionFunction;
use function findSimple;
use function PHPUnit\Framework\assertSame;

#[TestDox('Тесты функции findSimple')]
final class FindSimpleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        include_once __DIR__ . '/1.php';
    }

    #[TestDox('Тест типизации первого аргумента')]
    public function testArgumentATyping(): void
    {
        $reflectionFunc = new ReflectionFunction('findSimple');

        $a = $reflectionFunc->getParameters()[0] ?? null;

        assertSame('int', $a?->getType()?->getName(), 'Аргумент $a не имеет тип int');
    }

    #[TestDox('Тест типизации второго аргумента аргумента')]
    public function testArgumentBTyping(): void
    {
        $reflectionFunc = new ReflectionFunction('findSimple');

        $b = $reflectionFunc->getParameters()[1] ?? null;

        assertSame('int', $b?->getType()?->getName(), 'Аргумент $b не имеет тип int');
    }

    #[TestDox('Тест возвращаемого значения')]
    public function testReturnType(): void
    {
        $reflectionFunc = new ReflectionFunction('findSimple');

        assertSame('array', $reflectionFunc->getReturnType(), 'Тип возвращаемого значения должен быть "array"');
    }

    public static function dateProvider(): array
    {
        return [
            [
                1,
                7,
                [2, 3, 5, 7],
            ],
            [
                2,
                41,
                [2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41],
            ],
            [
                50,
                100,
                [53, 59, 61, 67, 71, 73, 79, 83, 89, 97]
            ]
        ];
    }

    #[DataProvider('dateProvider')]
    #[TestDox('Тест результата выполнения функции')]
    public function testResult(int $a, int $b, array $expected): void
    {
        $result = findSimple($a, $b);

        assertSame($expected, $result);
    }

    public static function invalidArgumentDataProvider(): array
    {
        return [
            '$a > $b' => [10, 5],
            '$a == $b' => [5, 5],
            '$a отрицательное' => [-5, 5],
        ];
    }

    #[DataProvider('invalidArgumentDataProvider')]
    #[TestDox('Тест реакции на некорректные аргументы')]
    public function testInvalidArguments(int $a, int $b): void
    {
        $this->expectException(\Exception::class);

        findSimple($a, $b);
    }
}