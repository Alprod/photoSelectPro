Php cs fixer

<?php
$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude(['assets', 'bin', 'config', 'migrations', 'node_modules', 'public', 'translations', 'templates', 'var', 'vendor'])
    ->notPath(['src/kernel.php', 'tests/bootstrap.php'])
    ->notPath(['.env', '.env.local', '.env.test', '.gitignore', '.php-cs-fixer.dist.php', '.php-cd-fixer.php'])
    ->notPath(['composer.json', 'composer.lock', 'compose.override.yml', 'compose.yml', 'package.json', 'package-lock.json', 'phpstan.neon', 'phpstan.neon.dist', 'phpunit.xml.dist', 'phpunit.xml', 'postcss.config.js', 'Readme.md', 'symfony.lock', 'tailwincss.config.js', 'yarn.lock']);


$config = new PhpCsFixer\Config();
return $config->setRules([
    '@Symfony' => true,
    'array_syntax' => ['syntax' => 'short'],
    'linebreak_after_opening_tag' => true,
    'single_quote' => true,
    'blank_line_before_statement' => ['statements' => ['return', 'if', 'try', 'throw', 'switch']],
    'binary_operator_spaces' => [
            'operators' => ['===' => 'align_single_space_minimal',
                '|' => 'no_space',
                '=>' => 'align_single_space_minimal_by_scope']],
    'class_attributes_separation' => ['elements' => ['property' => 'only_if_meta', 'const' => 'only_if_meta']],
    'class_definition' => [
            'multi_line_extends_each_single_line' => true,
            'inline_constructor_arguments' => false,
    ],
    'method_argument_space' => [
            'keep_multiple_spaces_after_comma' => true,
            'on_multiline' => 'ensure_fully_multiline'
    ],
    'no_alternative_syntax' => ['fix_non_monolithic_code' => false],
    'no_superfluous_phpdoc_tags' => ['allow_mixed' => false, 'allow_unused_params' => false],
    'phpdoc_trim' => false,
])
    ->setFinder($finder);
