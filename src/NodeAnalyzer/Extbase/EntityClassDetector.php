<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\NodeAnalyzer\Extbase;

use PhpParser\Node\Stmt\Class_;
use PHPStan\Reflection\ReflectionProvider;
use TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface;

final class EntityClassDetector
{
    public function __construct(private ReflectionProvider $reflectionProvider)
    {
    }

    public function isInsideExtbaseEntity(Class_ $node): bool
    {
        $classReflection = $this->reflectionProvider->getClass($node->namespacedName->toString());

        return $classReflection->implementsInterface(DomainObjectInterface::class);
    }
}
