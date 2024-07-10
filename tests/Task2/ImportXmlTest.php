<?php
declare(strict_types=1);

namespace Tests\Task2;

use PHPUnit\Framework\Attributes\TestDox;
use Tests\FunctionTestCase;

#[TestDox('Функция importXml():')]
final class ImportXmlTest extends FunctionTestCase
{
    protected static function getFunctionName(): string
    {
        return 'importXml';
    }

    protected static function getArguments(): array
    {
        return [
            'filename' => 'string',
        ];
    }

    protected static function getReturnType(): string
    {
        return 'void';
    }
}
