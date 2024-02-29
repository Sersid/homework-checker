<?php
declare(strict_types=1);

namespace Tests\Task1;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use ReflectionFunction;
use function PHPUnit\Framework\assertSame;
use function squareTrapeze;

#[TestDox('Тесты функции squareTrapeze')]
final class SquareTrapezeTest extends TestCase
{
    #[TestDox('Тест типизации аргумента')]
    public function testArgumentATyping(): void
    {
        $reflectionFunc = new ReflectionFunction('squareTrapeze');

        $a = $reflectionFunc->getParameters()[0] ?? null;

        assertSame('array', $a?->getType()?->getName(), 'Аргумент не имеет тип array');
    }

    #[TestDox('Тест реакции на некорректный массив')]
    #[TestWith([['a' => 1, 'b' => 3, 'c' => 5]])]
    #[TestWith([['a' => 4, 'c' => 8]])]
    #[TestWith([['a' => 6, 'b' => 4]])]
    public function testNotHasKeys(array $a): void
    {
        $this->expectException(\Exception::class);

        squareTrapeze($a);
    }

    public function testResult(): void
    {
        $a = [
            ['a' => 1, 'b' => 3, 'c' => 5],
            ['a' => 4, 'b' => 6, 'c' => 8],
            ['a' => 6, 'b' => 4, 'c' => 2],
            ['a' => 6, 'b' => 4, 'c' => 0],
        ];

        squareTrapeze($a);

        // S = (a + b) * h / 2
        $expected = [
            ['a' => 1, 'b' => 3, 'c' => 5, 's' => 10.0],
            ['a' => 4, 'b' => 6, 'c' => 8, 's' => 40.0],
            ['a' => 6, 'b' => 4, 'c' => 2, 's' => 10.0],
            ['a' => 6, 'b' => 4, 'c' => 0, 's' => 0.0],
        ];
        assertSame($expected, $a, 'Результат некорректный');
    }
}
