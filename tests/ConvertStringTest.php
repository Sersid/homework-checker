<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use ReflectionFunction;
use function PHPUnit\Framework\assertSame;

#[TestDox('Тесты функции convertString')]
final class ConvertStringTest extends TestCase
{
    #[TestDox('Тест типизации аргумента $a')]
    public function testArgumentATyping(): void
    {
        $reflectionFunc = new ReflectionFunction('convertString');

        $a = $reflectionFunc->getParameters()[0] ?? null;

        assertSame('string', $a?->getType()?->getName(), 'Аргумент не имеет тип string');
    }

    #[TestDox('Тест типизации аргумента $b')]
    public function testArgumentBTyping(): void
    {
        $reflectionFunc = new ReflectionFunction('convertString');

        $b = $reflectionFunc->getParameters()[1] ?? null;

        assertSame('string', $b?->getType()?->getName(), 'Аргумент не имеет тип string');
    }

    #[TestDox('Тест возвращаемого значения')]
    public function testReturnType(): void
    {
        $reflectionFunc = new ReflectionFunction('convertString');

        $result = (string)$reflectionFunc->getReturnType();

        assertSame('string', $result, 'Тип возвращаемого значения должен быть "string"');
    }

    #[TestWith(['two one two', 'two', 'two one owt'])]
    #[TestWith(['один один два', 'один', 'один нидо два'])]
    #[TestWith(['one two three', 'four', 'one two three'])]
    public function testResult(string $a, string $b, string $expected): void
    {
        $result = convertString($a, $b);

        assertSame($result, $expected);
    }
}