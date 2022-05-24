<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\ConstFetch;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use Ssch\Typo3PhpstanRules\FileResolver;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @implements Rule<ConstFetch>
 */
final class DoNotUseConstantsInConfigurationFilesRule implements Rule, DocumentedRuleInterface
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

    public function getNodeType(): string
    {
        return ConstFetch::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (! $this->fileResolver->isConfigurationFile($scope)) {
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
