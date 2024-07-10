<?php
declare(strict_types=1);

namespace Tests\Task2;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\FunctionTestCase;
use function PHPUnit\Framework\assertSame;

#[TestDox('Функция convertString():')]
final class ConvertStringTest extends FunctionTestCase
{
    protected static function getFunctionName(): string
    {
        return 'convertString';
    }

    protected static function getArguments(): array
    {
        return [
            'a' => 'string',
            'b' => 'string',
        ];
    }

    protected static function getReturnType(): string
    {
        return 'string';
    }

    #[TestWith(['two one two', 'two', 'two one owt'])]
    #[TestWith(['один один два', 'один', 'один нидо два'])]
    #[TestWith(['one two three', 'four', 'one two three'])]
    #[TestWith(['OneTwoThreeOneOne', 'One', 'OneTwoThreeenOOne'])]
    public function testResult(string $a, string $b, string $expected): void
    {
        $result = convertString($a, $b);

        assertSame($expected, $result);
    }
}
