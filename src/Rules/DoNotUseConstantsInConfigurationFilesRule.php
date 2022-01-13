<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\ConstFetch;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleError;
use Ssch\Typo3PhpstanRules\FileResolver;
use Symplify\PHPStanRules\Rules\AbstractSymplifyRule;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class DoNotUseConstantsInConfigurationFilesRule extends AbstractSymplifyRule
{
    /**
     * @var string
     */
    private const MESSAGE = 'Do not use constant TYPO3_MODE or TYPO3_REQUESTTYPE in file "%s"';

    private FileResolver $fileResolver;

    public function __construct(FileResolver $fileResolver)
    {
        $this->fileResolver = $fileResolver;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Do not use constants TYPO3_MODE and TYPO3_REQUESTTYPE in ext_localconf.php or ext_tables.php',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
if (TYPO3_MODE === 'BE') {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][$packageKey] = \Prefix\MyExtension\PageRendererHooks::class . '->renderPreProcess';
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][$packageKey] = \Prefix\MyExtension\PageRendererHooks::class . '->renderPreProcess';
CODE_SAMPLE
                ),

            ]
        );
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [Node\Expr\ConstFetch::class];
    }

    /**
     * @return array<string|RuleError>
     */
    public function process(Node $node, Scope $scope): array
    {
        if (! $this->fileResolver->isConfigurationFile($scope)) {
            return [];
        }

        if (! $node instanceof ConstFetch) {
            return [];
        }

        $constFetchName = $node->name->toString();

        if (! in_array($constFetchName, ['TYPO3_MODE', 'TYPO3_REQUESTTYPE'], true)) {
            return [];
        }

        $errorMessage = sprintf(self::MESSAGE, $scope->getFile());

        return [$errorMessage];
    }
}
