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

    protected static function getArguments(): array
    {
        return [
            'filename' => 'string',
            'categoryCode' => 'string',
        ];
    }

    protected static function getReturnType(): string
    {
        return 'void';
    }
}
