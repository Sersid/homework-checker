<?php
declare(strict_types=1);

namespace Tests\Task1;

use Exception;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use ReflectionFunction;
use function createTrapeze;
use function PHPUnit\Framework\assertSame;

#[TestDox('Функция createTrapeze():')]
final class CreateTrapezeTest extends TestCase
{
    private ReflectionFunction $reflectionFunc;

    protected function setUp(): void
    {
        parent::setUp();
        $this->reflectionFunc = new ReflectionFunction('createTrapeze');
    }

    #[TestDox('Содержит аргумент $a')]
    public function testArgs(): void
    {
        $args = [];
        foreach ($this->reflectionFunc->getParameters() as $parameter) {
            $args[] = $parameter->getName();
        }

        assertSame(['a'], $args);
    }

    #[TestDox('Указан тип $a (array)')]
    public function testArgumentATyping(): void
    {
        $a = $this->reflectionFunc->getParameters()[0] ?? null;

        assertSame('array', $a?->getType()?->getName());
    }

    #[TestDox('Указан тип возвращаемого значения (array)')]
    public function testReturnType(): void
    {
        $result = (string)$this->reflectionFunc->getReturnType();

        assertSame('array', $result);
    }

    public static function dataProvider(): iterable
    {
        return [
            [
                [1, 2, 3, 4, 5, 6],
                [
                    ['a' => 1, 'b' => 2, 'c' => 3],
                    ['a' => 4, 'b' => 5, 'c' => 6],
                ],
            ],
            [
                [1, 3, 5, 4, 6, 8, 6, 4, 2],
                [
                    ['a' => 1, 'b' => 3, 'c' => 5],
                    ['a' => 4, 'b' => 6, 'c' => 8],
                    ['a' => 6, 'b' => 4, 'c' => 2],
                ]
            ]
        ];
    }

    #[TestDox('Верный результат выполнения функции')]
    #[DataProvider('dataProvider')]
    public function testResult(array $a, array $expected): void
    {
        $result = createTrapeze($a);

        assertSame($expected, $result, 'Результат функции не корректный');
    }

    public static function invalidDataProvider(): iterable
    {
        return [
            'пустой массив' => [[]],
            'массив с отрицательными числами' => [[-2, 3, 5, 2, -3, 5]],
            'массива с количеством элементов не кратно 3' => [[1, 3, 5, 2]],
        ];
    }

    #[TestDox('Выбрасывается исключение')]
    #[DataProvider('invalidDataProvider')]
    public function testInvalidArgument(array $a): void
    {
        $this->expectException(Exception::class);

        createTrapeze($a);
    }
}
