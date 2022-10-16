<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        '@Symfony' => true,
        'declare_strict_types' => true,
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder($finder);
