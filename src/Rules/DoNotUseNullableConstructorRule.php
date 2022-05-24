<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\NullableType;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\UnionType;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use Symplify\PackageBuilder\ValueObject\MethodName;

/**
 * @implements Rule<ClassMethod>
 */
final class DoNotUseNullableConstructorRule implements Rule
{
    /**
     * @var string
     */
    public const MESSAGE = 'Do not use nullable argument in constructor';

    public function getNodeType(): string
    {
        return ClassMethod::class;
    }

    /**
     * @param ClassMethod $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if ($node->name->toString() !== MethodName::CONSTRUCTOR) {
            return [];
        }

        foreach ($node->params as $param) {
            if ($this->shouldSkipParam($param)) {
                continue;
            }

            return [self::MESSAGE];
        }

        return [];
    }

    private function shouldSkipParam(Param $param): bool
    {
        if ($param->default === null) {
            return true;
        }

        if ($param->type instanceof NullableType && $param->type->type instanceof FullyQualified) {
            return false;
        }

        if ($param->type instanceof UnionType) {
            foreach ($param->type->types as $type) {
                if (! $type instanceof Identifier) {
                    continue;
                }

                if ($type->name !== 'null') {
                    continue;
                }

                return false;
            }
        }

        return true;
    }
}
