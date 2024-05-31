<?php
declare(strict_types=1);

namespace Tests\Task2;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use ReflectionFunction;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertSame;

#[TestDox('Функция exportXml():')]
final class ExportXmlTest extends TestCase
{
    private ReflectionFunction $reflectionFunc;

    protected function setUp(): void
    {
        parent::setUp();
        $this->reflectionFunc = new ReflectionFunction('exportXml');
    }

    #[TestDox('Содержит аргументы $filename и $categoryCode')]
    public function testArgs(): void
    {
        $args = [];
        foreach ($this->reflectionFunc->getParameters() as $parameter) {
            $args[] = $parameter->getName();
        }

        assertSame(['filename', 'categoryCode'], $args);
    }

    #[TestDox('Указан тип $filename (string)')]
    public function testArgumentFilenameTyping(): void
    {
        $filename = $this->reflectionFunc->getParameters()[0] ?? null;

        assertSame('string', $filename?->getType()?->getName());
    }

    #[TestDox('Указан тип $categoryCode')]
    public function testArgumentCategoryCodeTyping(): void
    {
        $categoryCode = $this->reflectionFunc->getParameters()[0] ?? null;

        assertNotNull($categoryCode?->getType()?->getName());
    }

    #[TestDox('Указан тип возвращаемого значения (void)')]
    public function testReturnType(): void
    {
        $result = (string)$this->reflectionFunc->getReturnType();

        assertSame('void', $result);
    }
}
