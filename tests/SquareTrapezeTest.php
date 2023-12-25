<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use ReflectionFunction;
use function PHPUnit\Framework\assertSame;
use function squareTrapeze;

#[TestDox('Тесты функции squareTrapeze')]
final class SquareTrapezeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        include_once __DIR__ . '/1.php';
    }

    #[TestDox('Тест типизации аргумента')]
    public function testArgumentATyping(): void
    {
        $reflectionFunc = new ReflectionFunction('squareTrapeze');

        $a = $reflectionFunc->getParameters()[0] ?? null;

        assertSame('array', $a?->getType()?->getName(), 'Аргумент не имеет тип array');
    }

    public function testResult(): void
    {
        $a = [
            ['a' => 1, 'b' => 3, 'c' => 5],
            ['a' => 4, 'b' => 6, 'c' => 8],
            ['a' => 6, 'b' => 4, 'c' => 2],
        ];

        squareTrapeze($a);

        // echo $a[0]['s']; // 10.0


        // S = (a + b) * h / 2
        $expected = [
            ['a' => 1, 'b' => 3, 'c' => 5, 's' => 10.0],
            ['a' => 4, 'b' => 6, 'c' => 8, 's' => 40.0],
            ['a' => 6, 'b' => 4, 'c' => 2, 's' => 10.0],
        ];
        assertSame($expected, $a, 'Результат некорректный');
    }
}
