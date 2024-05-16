<?php
declare(strict_types=1);

namespace Task1;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

#[TestDox('Тесты класса BaseMath')]
final class BaseMathTest extends TestCase
{
    private ReflectionClass $reflectionClass;

    protected function setUp(): void
    {
        parent::setUp();
        $this->reflectionClass = new ReflectionClass('BaseMath');
    }

    private function getMethod(string $name): ReflectionMethod
    {
        return $this->reflectionClass->getMethod($name);
    }

    #[TestDox('Должен быть абстрактным')]
    public function testClassMustBeAbstract(): void
    {
        assertTrue($this->reflectionClass->isAbstract());
    }

    #[TestDox('Должен содержать метод exp1()')]
    public function testClassMustContainExp1Method(): void
    {
        $this->assertHasMethod('exp1');
    }

    #[TestDox('Должен содержать метод exp2()')]
    public function testClassMustContainExp2Method(): void
    {
        $this->assertHasMethod('exp2');
    }

    #[TestDox('Должен содержать метод getValue()')]
    public function testClassMustContainGetValueMethod(): void
    {
        $this->assertHasMethod('getValue');
    }

    private function assertHasMethod(string $name): void
    {
        assertTrue($this->reflectionClass->hasMethod($name));
    }

    #[TestDox('Метод exp1() должен иметь аргументы $a, $b, $c')]
    #[Depends('testClassMustContainExp1Method')]
    public function testExp1MustContainArgs(): void
    {
        $this->assertMethodHasArgs('exp1');
    }

    #[TestDox('Метод exp2() должен иметь аргументы $a, $b, $c')]
    #[Depends('testClassMustContainExp2Method')]
    public function testExp2MustContainArgs(): void
    {
        $this->assertMethodHasArgs('exp2');
    }

    private function assertMethodHasArgs(string $methodName): void
    {
        $args = [];
        foreach ($this->getMethod($methodName)->getParameters() as $parameter) {
            $args[] = $parameter->getName();
        }

        assertSame(['a', 'b', 'c'], $args);
    }

    #[TestDox('Все аргументы метода exp1() должны иметь тип int или float')]
    #[Depends('testExp1MustContainArgs')]
    public function testExp1ArgsMustBeNumeric(): void
    {
        $this->assertParameterMustBeNumeric('exp1');
    }

    #[TestDox('Все аргументы метода exp2() должны иметь тип int или float')]
    #[Depends('testExp2MustContainArgs')]
    public function testExp2ArgsMustBeNumeric(): void
    {
        $this->assertParameterMustBeNumeric('exp2');
    }

    private function assertParameterMustBeNumeric(string $methodName): void
    {
        $allIsNumeric = true;
        foreach ($this->getMethod($methodName)->getParameters() as $parameter) {
            $allIsNumeric = $allIsNumeric && in_array($parameter->getType()?->getName(), ['float', 'int'], true);
        }

        assertTrue($allIsNumeric, 'Все аргументы метода ' . $methodName . '() должны иметь тип int или float');
    }

    #[TestDox('Метод exp1() должен возвращать int или float')]
    #[Depends('testClassMustContainExp1Method')]
    public function testExp1MustBeNumericReturnType(): void
    {
        $this->assertMethodMustBeNumericReturnType('exp1');
    }

    #[TestDox('Метод exp2() должен возвращать int или float')]
    #[Depends('testClassMustContainExp2Method')]
    public function testExp2MustBeNumericReturnType(): void
    {
        $this->assertMethodMustBeNumericReturnType('exp2');
    }

    #[TestDox('Метод getValue() должен возвращать int или float')]
    #[Depends('testClassMustContainGetValueMethod')]
    public function testGetValueMustBeNumericReturnType(): void
    {
        $this->assertMethodMustBeNumericReturnType('getValue');
    }

    private function assertMethodMustBeNumericReturnType(string $methodName): void
    {
        $method = $this->getMethod($methodName);

        assertTrue(
            in_array($method->getReturnType()?->getName(), ['float', 'int'], true),
            'Метод ' . $methodName . '() должен возвращать int или float'
        );
    }

    #[TestDox('Метод getValue() должен быть абстрактным')]
    #[Depends('testClassMustContainGetValueMethod')]
    public function testGetValueMustBeAbstract(): void
    {
        $method = $this->getMethod('getValue');

        assertTrue($method->isAbstract(), 'Метод getValue() должен быть абстрактным');
    }

    public static function exp1DataProvider(): iterable
    {
        return [
            [
                ['a' => 5, 'b' => 10, 'c' => 2],
                500,
            ],
            [
                ['a' => 5, 'b' => 10, 'c' => 0],
                5,
            ],
            [
                ['a' => 1, 'b' => 10, 'c' => 0],
                1,
            ],
        ];
    }

    #[TestDox('Результат метода exp1')]
    #[Depends('testExp1MustContainArgs')]
    #[DataProvider('exp1DataProvider')]
    public function testExp1(array $args, float $expected): void
    {
        // a * (b ^ c)
        $class = $this->getBaseMathClass();

        $result = (float)$class->exp1(...$args);

        assertSame($expected, $result);
    }

    public static function exp2DataProvider(): iterable
    {
        return [
            [
                ['a' => 10, 'b' => 2, 'c' => 2],
                25,
            ],
            [
                ['a' => 100, 'b' => 50, 'c' => 2],
                4,
            ],
        ];
    }

    #[TestDox('Результат метода exp2')]
    #[Depends('testExp2MustContainArgs')]
    #[DataProvider('exp2DataProvider')]
    public function testExp2(array $args, float $expected): void
    {
        // (a / b) ^ c
        $class = $this->getBaseMathClass();

        $result = (float)$class->exp2(...$args);

        assertSame($expected, $result);
    }

    private function getBaseMathClass(): \BaseMath
    {
        return new class extends \BaseMath
        {
            public function getValue(): int
            {
                return 0;
            }
        };
    }
}