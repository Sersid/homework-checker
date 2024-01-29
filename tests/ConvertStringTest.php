<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

final class ConvertStringTest extends TestCase
{
    public static function dataProvider(): array
    {
        return [
            ['one two three', 'four', 'one two three'],
            ['one two two', 'two', 'one two owt'],
            ['один один два', 'один', 'один нидо два'],
        ];
    }

    #[DataProvider('dataProvider')]
    public function test(string $a, string $b, string $expected): void
    {
        $result = convertString($a, $b);

        assertSame($result, $expected);
    }
}