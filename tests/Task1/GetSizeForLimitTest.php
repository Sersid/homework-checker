<?php
declare(strict_types=1);

namespace Tests\Task1;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use ReflectionFunction;
use function getSizeForLimit;
use function PHPUnit\Framework\assertSame;

#[TestDox('Тесты функции getSizeForLimit')]
final class GetSizeForLimitTest extends TestCase
{
    #[TestDox('Тест типизации первого аргумента')]
    public function testArgumentATyping(): void
    {
        $reflectionFunc = new ReflectionFunction('getSizeForLimit');

        $a = $reflectionFunc->getParameters()[0] ?? null;

        assertSame('array', $a?->getType()?->getName(), 'Аргумент $a не имеет тип array');
    }

    #[TestDox('Тест типизации первого аргумента')]
    public function testArgumentBTyping(): void
    {
        $reflectionFunc = new ReflectionFunction('getSizeForLimit');

        $b = $reflectionFunc->getParameters()[1] ?? null;

        assertSame('float', $b?->getType()?->getName(), 'Аргумент $b не имеет тип float');
    }

    #[TestDox('Тест результата выполнения функции')]
    public function testResult(): void
    {
        $a = [
            ['a' => 1, 'b' => 3, 'c' => 5, 's' => 10.0],
            ['a' => 4, 'b' => 6, 'c' => 8, 's' => 40.0],
            ['a' => 5, 'b' => 6, 'c' => 7, 's' => 38.5],
            ['a' => 6, 'b' => 4, 'c' => 2, 's' => 10.0],
        ];

        $result = getSizeForLimit($a, 39);

        assertSame($a[2], $result);
    }

    #[TestDox('Тест передачи пустого массива')]
    public function testEmptyA(): void
    {
        $a = [];
        $b = 1; // any

        $result = getSizeForLimit($a, $b);

        assertSame([], $result);
    }

    public static function invalidDataProvider(): iterable
    {
        return [
            'не все элементы массива содержат ключ "s"' => [
                [
                    ['a' => 1, 'b' => 3, 'c' => 5, 's' => 10.0],
                    ['a' => 4, 'b' => 6, 'c' => 8],
                ]
            ],
            'ключ "s" по каким-то причинам содержит null' => [
                [
                    ['a' => 5, 'b' => 6, 'c' => 7, 's' => 38.5],
                    ['a' => 4, 'b' => 6, 'c' => 8, 's' => null],
                    ['a' => 1, 'b' => 3, 'c' => 5, 's' => 10.0],
                ]
            ],
        ];
    }

    #[TestDox('Тест передачи некорректного массива')]
    #[DataProvider('invalidDataProvider')]
    public function testIncorrectA(array $a): void
    {
        $this->expectException(\Exception::class);

        getSizeForLimit($a, 1);
    }
}
