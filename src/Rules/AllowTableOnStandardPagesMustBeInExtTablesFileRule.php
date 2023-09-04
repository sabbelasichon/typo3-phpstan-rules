<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use Ssch\Typo3PhpstanRules\FileResolver;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * @implements Rule<StaticCall>
 */
final class AllowTableOnStandardPagesMustBeInExtTablesFileRule implements Rule
{
    public function __construct(private FileResolver $fileResolver)
    {
    }

    public function getNodeType(): string
    {
        return StaticCall::class;
    }

    /**
     * @param StaticCall $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node->class instanceof Name) {
            return [];
        }

        $className = $scope->resolveName($node->class);
        if ($className !== ExtensionManagementUtility::class) {
            return [];
        }

        if ($node->name instanceof Node\Identifier && $node->name->toString() !== 'allowTableOnStandardPages') {
            return [];
        }

        if ($this->fileResolver->isExtTablesFile($scope)) {
            return [];
        }

        return [RuleErrorBuilder::message('You must define allowTableOnStandardPages in ext_tables.php')->build()];
    }
}
