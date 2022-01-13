<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('vendor/*')
    ->exclude('build/*')
    ->in([
        __DIR__ . '/Economic',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12'                            => true,
        'array_syntax'                      => ['syntax' => 'short'],
        'array_indentation'                 => true,
        'ordered_imports'                   => ['sort_algorithm' => 'alpha'],
        'no_unused_imports'                 => true,
        'not_operator_with_successor_space' => true,
        'trailing_comma_in_multiline'       => true,
        'phpdoc_scalar'                     => true,
        'unary_operator_spaces'             => true,
        'binary_operator_spaces'            => [
            'operators' => ['=>' => 'align_single_space'],
        ],
        'blank_line_before_statement' => [
            'statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try'],
        ],
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_var_without_name'        => true,
        'method_argument_space'          => [
            'on_multiline'                     => 'ensure_fully_multiline',
            'keep_multiple_spaces_after_comma' => true,
        ],
    ])
    ->setFinder($finder);
