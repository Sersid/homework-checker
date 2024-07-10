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
     * @return array{string, string} array{argument name => argument type}
     */
    abstract protected static function getFunctionArguments(): array;

    abstract protected static function getFunctionReturnType(): string;

    protected function getReflectionFunction(): ReflectionFunction
    {
        return new ReflectionFunction(static::getFunctionName());
    }

    #[TestDox('Не менялась сигнатура аргументов')]
    public function testSignature(): void
    {
        // arrange
        $expected = [
            'arguments' => static::getFunctionArguments(),
            'returnType' => static::getFunctionReturnType(),
        ];

        // act
        $result['arguments'] = [];
        foreach ($this->getReflectionFunction()->getParameters() as $parameter) {
            $result['arguments'][$parameter->getName()] = $parameter?->getType()?->getName();
        }
        $result['returnType'] = (string)$this->getReflectionFunction()->getReturnType();

        // expected
        $message = "Поменялась сигнатура функции. \n";
        $message .= 'Ожидание: ' . self::getSignature($expected). "\n";
        $message .= 'Реальность: ' . self::getSignature($result);
        assertSame($expected, $result, $message);
    }

    private static function getSignature(array $data): string
    {
        return static::getFunctionName()
            . '(' . self::getArguments($data['arguments']) . ')'
            . self::getReturnType($data['returnType']);
    }

    private static function getArguments(array $arguments): string
    {
        $args = [];
        foreach ($arguments as $name => $type) {
            $args[] = (empty($type) ? '' : $type . ' ') . '$' . $name;
        }

        return implode(', ', $args);
    }

    private static function getReturnType(string $returnType): string
    {
        return empty($returnType) ? '' : ': '. $returnType;
    }
}
