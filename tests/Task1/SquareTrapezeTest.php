<?php
declare(strict_types=1);

namespace Tests\Task1;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use ReflectionFunction;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertSame;
use function squareTrapeze;

#[TestDox('Функция createTrapeze():')]
final class SquareTrapezeTest extends TestCase
{
    private ReflectionFunction $reflectionFunc;

    protected function setUp(): void
    {
        parent::setUp();
        $this->reflectionFunc = new ReflectionFunction('squareTrapeze');
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

    #[TestDox('Указан тип возвращаемого значения (void)')]
    public function testReturnType(): void
    {
        $result = (string)$this->reflectionFunc->getReturnType();

        assertSame('void', $result);
    }

    public static function invalidDataProvider(): iterable
    {
        return [
            'ключ а - это кириллица' => [['a' => 1, 'b' => 3, 'c' => 5]],
            'отсутствует ключ b' => [['a' => 4, 'c' => 8]],
            'отсутствует ключ с' => [['a' => 6, 'b' => 4]],
            'ключ с содержит строку' => [['a' => 1, 'b' => 3, 'c' => 'qwe']]
        ];
    }

    #[TestDox('Выбрасывается исключение')]
    #[DataProvider('invalidDataProvider')]
    public function testNotHasKeys(array $a): void
    {
        $this->expectException(\Exception::class);

        squareTrapeze($a);
    }

    #[TestDox('Верный результат выполнения функции')]
    public function testResult(): void
    {
        $a = [
            ['a' => 1, 'b' => 3, 'c' => 5],
            ['a' => 4, 'b' => 6, 'c' => 8],
            ['a' => 6, 'b' => 4, 'c' => 2],
            ['a' => 6, 'b' => 4, 'c' => 0],
            ['a' => 1, 'b' => 2, 'c' => 1],
        ];

        squareTrapeze($a);

        // S = (a + b) * h / 2
        $expected = [
            ['a' => 1, 'b' => 3, 'c' => 5, 's' => 10.0],
            ['a' => 4, 'b' => 6, 'c' => 8, 's' => 40.0],
            ['a' => 6, 'b' => 4, 'c' => 2, 's' => 10.0],
            ['a' => 6, 'b' => 4, 'c' => 0, 's' => 0.0],
            ['a' => 1, 'b' => 2, 'c' => 1, 's' => 1.5],
        ];
        assertEquals($expected, $a, 'Результат некорректный');
    }
}
