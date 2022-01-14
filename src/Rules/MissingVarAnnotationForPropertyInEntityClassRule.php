<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Rules;

use PhpParser\Comment\Doc;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Property;
use PHPStan\Analyser\Scope;
use Ssch\Typo3PhpstanRules\NodeAnalyzer\Extbase\EntityClassDetector;
use Symplify\PHPStanRules\Rules\AbstractSymplifyRule;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class MissingVarAnnotationForPropertyInEntityClassRule extends AbstractSymplifyRule
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'Missing var annotation for property "%s" in class "%s"';

    /**
     * @see https://regex101.com/r/FxdlWN/1
     * @var string
     */
    public const VAR_TAG_REGEX = '#\*\s+@var\s+.*\n?#';

    private EntityClassDetector $entityClassDetector;

    public function __construct(EntityClassDetector $entityClassDetector)
    {
        $this->entityClassDetector = $entityClassDetector;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Missing var annotation for property "property" in class "MissingDocblock"', [
            new CodeSample(
                <<<'CODE_SAMPLE'
final class MissingDocblock extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    protected ?string $property = null;
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
final class MissingDocblock extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var string|null
     */
    protected ?string $property = null;
}
CODE_SAMPLE
            ),
        ]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [ClassLike::class];
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

        $className = $node->namespacedName->toString();

        foreach ($node->getProperties() as $property) {
            $docComment = $property->getDocComment();
            if (! $docComment instanceof Doc) {
                return [$this->createErrorMessage($property, $className)];
            }

            if ($this->containsVarAnnotationInDoc($docComment)) {
                continue;
            }

            return [$this->createErrorMessage($property, $className)];
        }

        return [];
    }

    private function containsVarAnnotationInDoc(Doc $docComment): bool
    {
        return 1 === preg_match(self::VAR_TAG_REGEX, $docComment->getText());
    }

    private function createErrorMessage(Property $node, string $className): string
    {
        $propertyProperty = $node->props[0];

        return sprintf(self::ERROR_MESSAGE, $propertyProperty->name, $className);
    }
}
