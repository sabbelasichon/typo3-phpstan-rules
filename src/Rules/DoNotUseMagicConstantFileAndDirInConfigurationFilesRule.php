<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Scalar\MagicConst\Dir;
use PhpParser\Node\Scalar\MagicConst\File;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleError;
use Ssch\Typo3PhpstanRules\FileResolver;
use Symplify\PHPStanRules\Rules\AbstractSymplifyRule;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class DoNotUseMagicConstantFileAndDirInConfigurationFilesRule extends AbstractSymplifyRule
{
    /**
     * @var string
     */
    private const MESSAGE_DIR = 'Do not use __DIR__ constant in file "%s"';

    /**
     * @var string
     */
    private const MESSAGE_FILE = 'Do not use __FILE__ constant in file "%s"';

    private FileResolver $fileResolver;

    public function __construct(FileResolver $fileResolver)
    {
        $this->fileResolver = $fileResolver;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Do not use __FILE__ constant in ext_localconf.php or ext_tables.php', [
            new CodeSample(
                <<<'CODE_SAMPLE'
__DIR__ . '/Resources/Private/Templates/Template.html;
CODE_SAMPLE
                ,
                \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::class . '::extPath(\'my_extension\') . \'/Resources/Private/Templates/Template.html;'
            ),
        ]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [File::class, Dir::class];
    }

    /**
     * @return array<string|RuleError>
     */
    public function process(Node $node, Scope $scope): array
    {
        if (! $this->fileResolver->isConfigurationFile($scope)) {
            return [];
        }

        $errors = [];
        if ($node instanceof File) {
            $errors[] = sprintf(self::MESSAGE_FILE, $scope->getFile());
        }

        if ($node instanceof Dir) {
            $errors[] = sprintf(self::MESSAGE_DIR, $scope->getFile());
        }

        return $errors;
    }
}
