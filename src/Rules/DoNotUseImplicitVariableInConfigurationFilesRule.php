<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PHPStan\Analyser\Scope;
use Ssch\Typo3PhpstanRules\FileResolver;
use Symplify\PHPStanRules\Rules\AbstractSymplifyRule;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class DoNotUseImplicitVariableInConfigurationFilesRule extends AbstractSymplifyRule
{
    /**
     * @var string
     */
    private const MESSAGE = 'Do not use implicit variable "$%s" in file "%s"';

    /**
     * @var string[]
     */
    private const DISALLOWED_VARIABLES = ['_EXTKEY', '_EXTCONF'];

    private FileResolver $fileResolver;

    public function __construct(FileResolver $fileResolver)
    {
        $this->fileResolver = $fileResolver;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Do not use $_EXTKEY and $_EXTCONF in ext_localconf.php or ext_tables.php', [
            new CodeSample(
                <<<'CODE_SAMPLE'
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][$_EXTKEY] = \Prefix\MyExtension\PageRendererHooks::class . '->renderPreProcess';
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess']['my_extension_key'] = \Prefix\MyExtension\PageRendererHooks::class . '->renderPreProcess';
CODE_SAMPLE
            ),
        ]);
    }

    public function getNodeTypes(): array
    {
        return [Node\Expr\Variable::class];
    }

    public function process(Node $node, Scope $scope): array
    {
        if (! $node instanceof Variable) {
            return [];
        }

        if (! $this->fileResolver->isConfigurationFile($scope)) {
            return [];
        }

        if (! is_string($node->name)) {
            return [];
        }

        if (! in_array($node->name, self::DISALLOWED_VARIABLES, true)) {
            return [];
        }

        $message = sprintf(self::MESSAGE, $node->name, $scope->getFile());

        return [$message];
    }
}
