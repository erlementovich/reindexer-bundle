<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
    ->exclude('config')
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'declare_strict_types' => true,
        'final_internal_class' => ['consider_absent_docblock_as_internal_class' => true],
        'concat_space' => ['spacing' => 'one'],
        'phpdoc_separation' => ['groups' => [['author', 'copyright', 'license', 'date', 'time', 'see']]],
        'phpdoc_align' => ['align' => 'left'],
        'trailing_comma_in_multiline' => ['elements' => ['arrays', 'arguments', 'parameters']],
    ])
    ->setFinder($finder)
;
