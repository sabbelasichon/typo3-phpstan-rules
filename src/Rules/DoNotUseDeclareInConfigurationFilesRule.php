<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Declare_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use Ssch\Typo3PhpstanRules\FileResolver;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @implements Rule<Declare_>
 */
final class DoNotUseDeclareInConfigurationFilesRule implements Rule, DocumentedRuleInterface
{
    /**
     * @var string
     */
    private const MESSAGE = 'Do not use declare statements in file "%s"';

    private FileResolver $fileResolver;

    public function __construct(FileResolver $fileResolver)
    {
        $this->fileResolver = $fileResolver;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Do not use declare statements in ext_localconf.php or ext_tables.php', [
            new CodeSample(
                <<<'CODE_SAMPLE'
declare(strict_types=1)

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][$packageKey] = \Prefix\MyExtension\PageRendererHooks::class . '->renderPreProcess';
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][$packageKey] = \Prefix\MyExtension\PageRendererHooks::class . '->renderPreProcess';
CODE_SAMPLE
            ),
        ]);
    }

    public function getNodeType(): string
    {
        return Declare_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (! $this->fileResolver->isConfigurationFile($scope)) {
            return [];
        }

        $errorMessage = sprintf(self::MESSAGE, $scope->getFile());

        return [$errorMessage];
    }
}
