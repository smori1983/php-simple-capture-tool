<?php
$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src')
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'increment_style' => ['style' => 'post'],
        'ordered_imports' => ['sortAlgorithm' => 'alpha'],
        'yoda_style' => false,
    ])
    ->setFinder($finder)
;
