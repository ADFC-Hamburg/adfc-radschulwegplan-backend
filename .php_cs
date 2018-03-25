<?php

$header = <<<EOF
This file is part of the ADFC Radschulwegplan Backend package.

<https://github.com/ADFC-Hamburg/adfc-radschulwegplan-backend>

(c) 2018 by James Twellmeyer
(c) 2018 by Sven Anders <github2018@sven.anders.hamburg>

Released under the GPL 3.0

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.

Please also visit our (german) webpage about the project:

<https://hamburg.adfc.de/verkehr/themen-a-z/kinder/schulwegplanung/>

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
    ->setCacheFile(__DIR__.'/.php_cs.cache/file')
    ->setRiskyAllowed(true)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__)
            ->exclude('app')
            ->exclude('bin')
            ->exclude('var')
            ->exclude('web')
            ->exclude('vendor')		
    )
;
