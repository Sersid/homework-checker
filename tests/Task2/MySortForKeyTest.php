<?php
declare(strict_types=1);

namespace Tests\Task2;

use Exception;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use ReflectionFunction;
use function PHPUnit\Framework\assertSame;

#[TestDox('Тесты функции mySortForKey')]
final class MySortForKeyTest extends TestCase
{
    #[TestDox('Тест типизации аргумента $a')]
    public function testArgumentATyping(): void
    {
        $reflectionFunc = new ReflectionFunction('mySortForKey');

        $a = $reflectionFunc->getParameters()[0] ?? null;

        assertSame('array', $a?->getType()?->getName(), 'Аргумент не имеет тип array');
    }

    #[TestDox('Тест типизации аргумента $b')]
    public function testArgumentBTyping(): void
    {
        $reflectionFunc = new ReflectionFunction('mySortForKey');

        $b = $reflectionFunc->getParameters()[1] ?? null;

        assertSame('string', $b?->getType()?->getName(), 'Аргумент не имеет тип string');
    }

    #[TestDox('Тест возвращаемого значения')]
    public function testReturnType(): void
    {
        $reflectionFunc = new ReflectionFunction('mySortForKey');

        $result = (string)$reflectionFunc->getReturnType();

        assertSame('array', $result, 'Тип возвращаемого значения должен быть "array"');
    }

    #[TestDox('Тест результата выполнения функции')]
    #[DataProvider('dataProvider')]
    public function testResult(array $a, string $b, array $expected): void
    {
        $result = mySortForKey($a, $b);

        assertSame($expected, $result, 'Результат функции не корректный');
    }

    public static function dataProvider(): array
    {
        return [
            'one' => [
                [['a' => 2, 'b' => 1], ['a' => 1, 'b' => 3]],
                'a',
                [['a' => 1, 'b' => 3], ['a' => 2, 'b' => 1]]
            ],
            'two' => [
                [['a' => 2, 'b' => 1], ['a' => 1, 'b' => 3]],
                'b',
                [['a' => 2, 'b' => 1], ['a' => 1, 'b' => 3]]
            ],
            'three' => [
                [['a' => 2], ['a' => 1], ['a' => 3], ['a' => 10], ['a' => -12]],
                'a',
                [['a' => -12], ['a' => 1], ['a' => 2], ['a' => 3], ['a' => 10]]
            ],
            'four' => [
                [['a' => 2, 'b' => 1], ['b' => 3, 'a' => 1]],
                'a',
                [['b' => 3, 'a' => 1], ['a' => 2, 'b' => 1]]
            ],
            'five' => [
                [['a' => 2, 'b' => 1, 'c' => 456], ['b' => 3, 'a' => 1, 'c' => 123]],
                'c',
                [['b' => 3, 'a' => 1, 'c' => 123], ['a' => 2, 'b' => 1, 'c' => 456]]
            ],
            'six' => [
                [['a' => 1, 'c' => 123], ['c' => 456], ['b' => 3, 'c' => 123]],
                'c',
                [['a' => 1, 'c' => 123], ['b' => 3, 'c' => 123], ['c' => 456]]
            ],
        ];
    }


    #[TestDox('Тест реакции на передачу неизвестного ключа')]
    public function testException(): void
    {
        $a = [['a' => 2, 'b' => 1, 'c' => 456], ['b' => 3, 'a' => 1, 'c' => 123]];
        $b = 'undefinedIndex';

        $this->expectException(Exception::class);

        mySortForKey($a, $b);
    }
}
