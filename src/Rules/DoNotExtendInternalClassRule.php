<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Class_>
 */
final class DoNotExtendInternalClassRule implements Rule
{
    public function __construct(private ReflectionProvider $reflectionProvider)
    {
    }

    public function getNodeType(): string
    {
        return Class_::class;
    }

    /**
     * @param Class_ $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if ($node->extends === null) {
            return [];
        }

        $extendedClassName = $node->extends->toString();
        if (! $this->reflectionProvider->hasClass($extendedClassName)) {
            return [];
        }

        $extendedClassReflection = $this->reflectionProvider->getClass($extendedClassName);
        if (! $extendedClassReflection->isInternal()) {
            return [];
        }

        if (! $this->isTypo3Namespace($node)) {
            return [];
        }

        $currentClassName = $node->namespacedName->toString();
        $errorBuilder = $this->buildError($currentClassName, $extendedClassName);

        return [$errorBuilder->build()];
    }

    private function isTypo3Namespace(Class_ $class): bool
    {
        if ($class->extends === null) {
            return false;
        }

        return (string) $class->extends->slice(0, 1) === 'TYPO3';
    }

    private function buildError(?string $currentClassName, string $extendedClassName): RuleErrorBuilder
    {
        return RuleErrorBuilder::message(\sprintf(
            '%s extends @internal class %s.',
            $currentClassName !== null ? \sprintf('Class %s', $currentClassName) : 'Anonymous class',
            $extendedClassName
        ));
    }
}
