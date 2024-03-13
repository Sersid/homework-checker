<?php
declare(strict_types=1);

namespace Tests\Task1;

use Exception;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use ReflectionFunction;
use function createTrapeze;
use function PHPUnit\Framework\assertSame;

#[TestDox('Тесты функции createTrapeze')]
final class CreateTrapezeTest extends TestCase
{
    #[TestDox('Тест типизации аргумента')]
    public function testArgumentATyping(): void
    {
        $reflectionFunc = new ReflectionFunction('createTrapeze');

        $a = $reflectionFunc->getParameters()[0] ?? null;

        assertSame('array', $a?->getType()?->getName(), 'Аргумент не имеет тип array');
    }

    #[TestDox('Тест возвращаемого значения')]
    public function testReturnType(): void
    {
        $reflectionFunc = new ReflectionFunction('createTrapeze');

        $result = (string)$reflectionFunc->getReturnType();

        assertSame('array', $result, 'Тип возвращаемого значения должен быть "array"');
    }

    #[TestDox('Тест результата выполнения функции')]
    public function testResult(): void
    {
        $a = [1, 3, 5, 4, 6, 8, 6, 4, 2];
        $expected = [
            ['a' => 1, 'b' => 3, 'c' => 5],
            ['a' => 4, 'b' => 6, 'c' => 8],
            ['a' => 6, 'b' => 4, 'c' => 2],
        ];

        $result = createTrapeze($a);

        assertSame($expected, $result, 'Результат функции не корректный');
    }

    #[TestDox('Тест передачи пустого массива')]
    public function testEmptyArgument(): void
    {
        $a = [];

        $this->expectException(Exception::class);

        createTrapeze($a);
    }

    #[TestDox('Тест передачи отрицательного массива')]
    public function testArgumentHasNegativeNumber(): void
    {
        $a = [-2, 3, 5, 2, -3, 5];

        $this->expectException(Exception::class);

        createTrapeze($a);
    }

    #[TestDox('Тест передачи массива с количеством элементов не кратно 3')]
    public function testArgumentNotMultipleOf3(): void
    {
        $a = [1, 3, 5, 2];

        $this->expectException(Exception::class);

        createTrapeze($a);
    }
}
