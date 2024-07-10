<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use ReflectionFunction;
use function PHPUnit\Framework\assertSame;

abstract class FunctionTestCase extends TestCase
{
    abstract protected static function getFunctionName(): string;

    /**
     * @return array{string, string}
     */
    abstract protected static function getArguments(): array;

    abstract protected static function getReturnType(): string;

    private function getReflectionFunction(): ReflectionFunction
    {
        return new ReflectionFunction(static::getFunctionName());
    }

    #[TestDox('Не менялась сигнатура аргументов')]
    public function testArguments(): void
    {
        $result = [];
        foreach ($this->getReflectionFunction()->getParameters() as $parameter) {
            $result[$parameter->getName()] = $parameter?->getType()?->getName();
        }

        assertSame(static::getArguments(), $result);
    }

    #[TestDox('Не менялась сигнатура типа возвращаемого значения')]
    public function testReturnType(): void
    {
        $result = (string)$this->getReflectionFunction()->getReturnType();

        assertSame(static::getReturnType(), $result);
    }
}
