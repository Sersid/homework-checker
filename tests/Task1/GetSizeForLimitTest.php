<?php
declare(strict_types=1);

namespace Tests\Task1;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use Exception;
use Tests\FunctionTestCase;
use function getSizeForLimit;
use function PHPUnit\Framework\assertSame;

#[TestDox('Функция getSizeForLimit():')]
final class GetSizeForLimitTest extends FunctionTestCase
{
    protected static function getFunctionName(): string
    {
        return 'getSizeForLimit';
    }

    protected static function getFunctionArguments(): array
    {
        return [
            'a' => 'array',
            'b' => 'float',
        ];
    }

    protected static function getFunctionReturnType(): string
    {
        return 'array';
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

        // ожидается, что $result === $a[2]
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
        $this->expectException(Exception::class);

        getSizeForLimit($a, 1);
    }
}
