<?php
declare(strict_types=1);

namespace Tests\Task2;

use PHPUnit\Framework\Attributes\TestDox;
use Tests\FunctionTestCase;

#[TestDox('Функция exportXml():')]
final class ExportXmlTest extends FunctionTestCase
{
    protected static function getFunctionName(): string
    {
        return 'exportXml';
    }

    protected static function getFunctionArguments(): array
    {
        return [
            'filename' => 'string',
            'categoryCode' => 'string',
        ];
    }

    protected static function getFunctionReturnType(): string
    {
        return 'void';
    }
}
