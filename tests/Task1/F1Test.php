<?php
declare(strict_types=1);

namespace Task1;

use BaseMath;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class F1Test extends TestCase
{
    private ReflectionClass $reflectionClass;

    protected function setUp(): void
    {
        parent::setUp();
        $this->reflectionClass = new ReflectionClass('F1');
    }

    #[TestDox('Должен наследоваться от BaseMath')]
    public function testExtends(): void
    {
        assertTrue(
            $this->reflectionClass->isSubclassOf(BaseMath::class),
            'Должен наследоваться от BaseMath'
        );
    }

    #[TestDox('Должен содержать метод getValue()')]
    public function testClassMustContainGetValueMethod(): void
    {
        assertTrue($this->reflectionClass->hasMethod('getValue'));
    }

    #[TestDox('Конструктор должен иметь аргументы $a, $b, $c')]
    #[Depends('testExtends')]
    public function testConstructMustContainArgs(): void
    {
        $args = [];
        foreach ($this->reflectionClass->getConstructor()->getParameters() as $parameter) {
            $args[] = $parameter->getName();
        }

        assertSame(['a', 'b', 'c'], $args);
    }

    #[TestDox('Все аргументы конструктора должны иметь тип int или float')]
    #[Depends('testConstructMustContainArgs')]
    public function testConstructArgsMustBeNumeric(): void
    {
        $allIsNumeric = true;
        foreach ($this->reflectionClass->getConstructor()->getParameters() as $parameter) {
            $allIsNumeric = $allIsNumeric && in_array($parameter->getType()?->getName(), ['float', 'int'], true);
        }

        assertTrue($allIsNumeric, 'Все аргументы конструктора должны иметь тип int или float');
    }

    public static function dataProvider(): iterable
    {
        return [
            [4, 2, 6],
        ];
    }

    #[TestDox('Результат выполнения getValue()')]
    #[DataProvider('dataProvider')]
    public function testGetValue(int $a, int $b, int $c): void
    {
        // (a * (b ^ c) + (((a / c) ^ b) % 3) ^ min(a, b, c))
        $expected = $a * ($b ** $c) + ((($a / $c) ** $b) % 3) ** min($a, $b, $c);
        $f1 = new \F1($a, $b, $c);

        $result = $f1->getValue();

        assertEquals($expected, $result);
    }
}