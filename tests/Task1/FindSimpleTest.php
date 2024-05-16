<?php
declare(strict_types=1);

namespace Tests\Task1;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use ReflectionFunction;
use function findSimple;
use function PHPUnit\Framework\assertSame;

#[TestDox('Функция findSimple():')]
final class FindSimpleTest extends TestCase
{
    private ReflectionFunction $reflectionFunc;

    protected function setUp(): void
    {
        parent::setUp();
        $this->reflectionFunc = new ReflectionFunction('findSimple');
    }

    #[TestDox('Содержит аргументы $a и $b')]
    public function testArgs(): void
    {
        $args = [];
        foreach ($this->reflectionFunc->getParameters() as $parameter) {
            $args[] = $parameter->getName();
        }

        assertSame(['a', 'b'], $args);
    }

    #[TestDox('Указан тип $a (int)')]
    public function testArgumentATyping(): void
    {
        $a = $this->reflectionFunc->getParameters()[0] ?? null;

        assertSame('int', $a?->getType()?->getName(), 'Аргумент $a не имеет тип int');
    }

    #[TestDox('Указан тип $b (int)')]
    public function testArgumentBTyping(): void
    {
        $b = $this->reflectionFunc->getParameters()[1] ?? null;

        assertSame('int', $b?->getType()?->getName(), 'Аргумент $b не имеет тип int');
    }

    #[TestDox('Указан тип возвращаемого значения (array)')]
    public function testReturnType(): void
    {
        $result = (string)$this->reflectionFunc->getReturnType();

        assertSame('array', $result, 'Тип возвращаемого значения должен быть "array"');
    }

    public static function dataProvider(): array
    {
        return [
            '$a = 1 and $b = 7' => [
                0,
                7,
                [2, 3, 5, 7],
            ],
            '$a = 2 and $b = 3' => [
                2,
                3,
                [2, 3]
            ],
            '$a = 3 and $b = 40' => [
                3,
                41,
                [3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41],
            ],
            '$a = 50 and $b = 100' => [
                50,
                100,
                [53, 59, 61, 67, 71, 73, 79, 83, 89, 97]
            ],
            '$a = 54 and $b = 58' => [
                54,
                58,
                []
            ],
        ];
    }

    #[TestDox('Верный результат выполнения функции')]
    #[DataProvider('dataProvider')]
    public function testResult(int $a, int $b, array $expected): void
    {
        $result = iterator_to_array(findSimple($a, $b));

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
    #[TestDox('Выбрасывается исключение')]
    public function testInvalidArguments(int $a, int $b): void
    {
        $this->expectException(\Exception::class);

        findSimple($a, $b);
    }
}
