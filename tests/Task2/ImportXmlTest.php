<?php
declare(strict_types=1);

namespace Tests\Task2;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use ReflectionFunction;
use function PHPUnit\Framework\assertSame;

#[TestDox('Функция importXml():')]
final class ImportXmlTest extends TestCase
{
    private ReflectionFunction $reflectionFunc;

    protected function setUp(): void
    {
        parent::setUp();
        $this->reflectionFunc = new ReflectionFunction('importXml');
    }

    #[TestDox('Содержит аргумент $filename')]
    public function testArgs(): void
    {
        $args = [];
        foreach ($this->reflectionFunc->getParameters() as $parameter) {
            $args[] = $parameter->getName();
        }

        assertSame(['filename'], $args);
    }

    #[TestDox('Указан тип $filename (string)')]
    public function testArgumentATyping(): void
    {
        $a = $this->reflectionFunc->getParameters()[0] ?? null;

        assertSame('string', $a?->getType()?->getName());
    }

    #[TestDox('Указан тип возвращаемого значения (void)')]
    public function testReturnType(): void
    {
        $result = (string)$this->reflectionFunc->getReturnType();

        assertSame('void', $result);
    }
}
