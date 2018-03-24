<?php

$header = <<<EOF
This file is part of the ADFC Radschulwegplan Backend package.

(c) ADFC Hamburg <http://github.com/ADFC-Hamburg>

EOF;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'long'],
        'combine_consecutive_unsets' => true,
        'header_comment' => ['header' => $header],
        'linebreak_after_opening_tag' => true,
        'no_php4_constructor' => true,
        'no_useless_else' => true,
        'ordered_class_elements' => true,
        'ordered_imports' => true,
        'php_unit_construct' => true,
        'php_unit_strict' => true,
        'phpdoc_no_empty_return' => false,
    ])
    ->setUsingCache(true)
    ->setRiskyAllowed(true)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__)
            ->exclude('app')
            ->exclude('bin')
            ->exclude('var/cache')
            ->exclude('vendor')		
    )
;
