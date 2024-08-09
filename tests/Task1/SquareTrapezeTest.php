<?php
declare(strict_types=1);

namespace Tests\Task1;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use Exception;
use Tests\FunctionTestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;
use function squareTrapeze;

#[TestDox('Функция squareTrapeze():')]
final class SquareTrapezeTest extends FunctionTestCase
{
    protected static function getFunctionName(): string
    {
        return 'squareTrapeze';
    }

    protected static function getFunctionArguments(): array
    {
        return [
            'a' => 'array',
        ];
    }

    protected static function getFunctionReturnType(): string
    {
        return 'void';
    }

    #[TestDox('Аргумент $a передается по ссылке')]
    public function testAIsPassedByReference(): void
    {
        $parameters = $this->getReflectionFunction()->getParameters();

        assertTrue($parameters[0]->isPassedByReference());
    }

    public static function invalidDataProvider(): iterable
    {
        return [
            'ключ а - это кириллица' => [[['a' => 1, 'b' => 3, 'c' => 5]]],
            'отсутствует ключ b' => [[['a' => 4, 'c' => 8]]],
            'отсутствует ключ с' => [[['a' => 6, 'b' => 4]]],
            'ключ с содержит строку' => [[['a' => 1, 'b' => 3, 'c' => 'qwe']]],
        ];
    }

    #[TestDox('Выбрасывается исключение')]
    #[DataProvider('invalidDataProvider')]
    public function testNotHasKeys(array $a): void
    {
        $this->expectException(Exception::class);

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
