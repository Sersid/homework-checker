<?php
declare(strict_types=1);

namespace Task1;

use BaseMath;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
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
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                8.0
            ],
        ];
    }

    #[TestDox('Результат выполнения getValue()')]
    #[DataProvider('dataProvider')]
    public function testGetValue(array $args, float $expected): void
    {
        $f1 = new \F1(...$args);

        // (a * (b ^ c) + (((a / c) ^ b) % 3) ^ min(a, b, c))
        $result = (float)$f1->getValue();

        assertSame($expected, $result);
    }
}