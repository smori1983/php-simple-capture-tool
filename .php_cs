<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
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
