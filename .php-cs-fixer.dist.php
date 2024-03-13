<?php
declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = (new Finder())->in(__DIR__ . '/tests');

return (new Config())
    ->setRules([
        '@PSR12' => true,
        'blank_line_after_opening_tag' => false,
        'blank_line_between_import_groups' => false,
    ])
    ->setFinder($finder)
;