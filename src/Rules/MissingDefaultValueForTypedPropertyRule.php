<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;
use PHPStan\Analyser\Scope;
use Ssch\Typo3PhpstanRules\NodeAnalyzer\Extbase\EntityClassDetector;
use Symplify\PHPStanRules\Rules\AbstractSymplifyRule;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class MissingDefaultValueForTypedPropertyRule extends AbstractSymplifyRule
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'Missing default value for property "%s" in class "%s"';

    private EntityClassDetector $entityClassDetector;

    public function __construct(EntityClassDetector $entityClassDetector)
    {
        $this->entityClassDetector = $entityClassDetector;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Missing default value for property "property" in class "MissingDefaultValueForTypedProperty"',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
final class MissingDefaultValueForTypedProperty extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    protected string $property;
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
final class MissingDefaultValueForTypedProperty extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    protected string $property = '';
}
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
        return [Class_::class];
    }

    /**
     * @return string[]
     */
    public function process(Node $node, Scope $scope): array
    {
        if (! $node instanceof Class_) {
            return [];
        }

        if (! $this->entityClassDetector->isInsideExtbaseEntity($node)) {
            return [];
        }

        foreach ($node->getProperties() as $property) {
            if ($this->shouldSkipProperty($property)) {
                continue;
            }

            return [$this->createErrorMessage($property, $node->namespacedName->toString())];
        }

        return [];
    }

    private function createErrorMessage(Property $node, string $className): string
    {
        $propertyProperty = $node->props[0];

        return sprintf(self::ERROR_MESSAGE, $propertyProperty->name, $className);
    }

    private function shouldSkipProperty(Property $property): bool
    {
        if ($property->type === null) {
            return true;
        }

        $propertyProperty = $property->props[0];

        return $propertyProperty->default !== null;
    }
}
