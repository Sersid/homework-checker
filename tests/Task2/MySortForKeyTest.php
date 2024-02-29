<?php
declare(strict_types=1);

namespace Tests\Task2;

use PHPUnit\Framework\Attributes\TestDox;
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
}